<?php
namespace app\Manage\controller;

use app\Manage\model\AccountModel;
use app\Manage\model\PriceModel;
use app\Manage\model\QuoteAccountingLogModel;
use app\Manage\model\QuoteProductModel;
use app\Manage\model\QuoteTableModel;
use PHPExcel_IOFactory;
use PHPExcel_Reader_Exception;
use PHPExcel_Worksheet_Drawing;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Session;
use think\Config;

class QuoteController extends BaseController
{
    /**
     * @throws DbException
     * @throws Exception
     */
    public function table(): \think\response\View
    {
        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        if ($keyword) {
            $where['table_name'] = ['like', '%' . $keyword . '%'];
        } else {
            $where = [];
        }

        // 查看权限
        $access_ids = AccountModel::account_access_ids();
        $where['user_id'] = ['in', $access_ids];

        // 报价单列表
        $quoteTableObj = new QuoteTableModel();
        $list = $quoteTableObj->with(['user'])->where($where)->order('id desc')->paginate(Config::get('PAGE_NUM'), false, ['keyword' => $keyword]);
        $this->assign('list', $list);

        $monthSum = $quoteTableObj->alias('a')
            ->join('nbtlz_quote_product b', 'a.id = b.table_id')
            ->where(['created_time' => ['egt', date('Y-m-') . '-01 00:00:00']])
            ->where(['created_time' => ['lt', date('Y-m-d H:i:s', strtotime('last day of this month'))]])
            ->where(['purchaser_id' => ['in', $access_ids]])
            ->count();
        $this->assign('monthSum', $monthSum);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    /**
     * @throws PHPExcel_Reader_Exception
     */
    public function table_import()
    {
        // phpexcel
        require_once './static/classes/PHPExcel/Classes/PHPExcel.php';

        $filename = input('filename');
        $origin = input('origin');
        $file = "./upload/excel/" . $filename;
        $excelReader = PHPExcel_IOFactory::createReaderForFile($file);
        $excelObj = $excelReader->load($file);
        $worksheet = $excelObj->getSheet(0);
        $imageArr = [];
        foreach ($worksheet->getDrawingCollection() as $drawing) {
            // 判断图片是否是图形对象（Drawing）
            if ($drawing instanceof PHPExcel_Worksheet_Drawing) {
                // 获取图片信息
                $imageExtension = $drawing->getExtension();
                $imagePath = $drawing->getPath(); // 获取图片的路径

                // 如果需要将图片保存到本地
                $newImagePath = 'upload/excel/images/' . date('YmdHis',time()).rand(100,1000) . '.' . $imageExtension; // 新图片的保存路径
                if (copy($imagePath, $newImagePath)) {
                    // 保存图片
                    $imageArr[] = $newImagePath;
                }
            }
        }
        $data = $worksheet->toArray();
        unset($data[0]);
        $data = array_values($data);

        Db::startTrans();
        try {
            $tableObj = new QuoteTableModel();
            $table = [
                'user_id'       =>  Session::get(Config::get('USER_LOGIN_FLAG')),
                'table_name'    =>  $origin,
                'created_time'  =>  date('Y-m-d H:i:s')
            ];
            if ($id = $tableObj->insertGetId($table)) {
                $productData = [];
                foreach ($data as $key => $item) {
                    if (empty($item[0])) {
                        continue;
                    }
                    $productData[] = [
                        "table_id"                      =>  $id,
                        "product_code"                  =>  $item[0],
                        "supplier_name"                 =>  $item[1],
                        "supplier_code"                 =>  $item[2],
                        "img_url"                       =>  $imageArr[$key],
                        "product_length"                =>  $item[4],
                        "product_width"                 =>  $item[5],
                        "product_height"                =>  $item[6],
                        "gross_weight"                  =>  $item[7],
                        "net_weight"                    =>  $item[8],
                        "is_multiple_boxes"             =>  $item[9] == '是' ? 1 : 0,
                        "packed_boxes"                  =>  $item[10],
                        "product_code_index"            =>  $item[11],
                        "is_multiple_carton"            =>  $item[12] == '是' ? 1 : 0,
                        "carton_quantity"               =>  $item[13],
                        "product_desc"                  =>  $item[14],
                        "cost"                          =>  $item[15],
                        "fob_port"                      =>  $item[16],
                        "fob"                           =>  $item[17],
                        "region"                        =>  $item[18],
                        "recommendation_reason"         =>  $item[19],
                        "purchaser_competitor_url"      =>  $item[20],
                        "is_recommend"                  =>  $item[21] == '是' ? 1 : 0,
                        "purchaser_id"                  =>  $table['user_id'],
                        "develop_id"                    =>  9
                    ];
                }
                $productObj = new QuoteProductModel();
                if (!$productObj->insertAll($productData)) {

                    throw new Exception('表格导入失败');
                }
            } else {
                throw new Exception('表格导入失败');
            }

            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            unlink($file);
            foreach ($imageArr as $image) {
                unlink($image);
            }
            $this->error($e->getMessage(), session('back_url', '', 'manage'));
        }
        $this->redirect(session('back_url', '', 'manage'));
    }

    /**
     * @throws DbException
     */
    public function product($id): \think\response\View
    {
        $where['table_id'] = $id;

        // 报价单列表
        $quoteTableObj = new QuoteProductModel();
        $list = $quoteTableObj->with(['developer'])->where($where)->order('id asc')->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');

        return view();
    }

    // 编辑
    /**
     * @throws DbException
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!(floatval($post['cost']) xor floatval($post['fob']))) {
                echo json_encode(['code' => 0, 'msg' => '请填写出厂价或Fob价']);
                exit();
            }
            $model = new QuoteProductModel();
            $info = $model->find($id);
            if ($info['status']) {
                echo json_encode(['code' => 0, 'msg' => '状态异常，不可编辑']);
                exit();
            }
            if ($model->save($post, ['id' => $id])) {
                echo json_encode(['code' => 1, 'msg' => '修改成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '修改失败，请重试']);
            }
            exit;
        } else {
            $info = QuoteProductModel::get(['id' => $id,]);
            $this->assign('info', $info);

            return view();
        }
    }

    // 删除
    /**
     * @throws DbException
     */
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $block = QuoteProductModel::get($post['id']);
            if ($block['status']) {
                echo json_encode(['code' => 0, 'msg' => '状态异常，不可删除']);
                exit();
            }
            $imageList = explode(',', $block['img_url']);
            if ($block->delete()) {
                foreach ($imageList as $item) {
                    unlink($item);
                }
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
        }
        exit;
    }

    /**
     * @throws DbException
     * @throws Exception
     */
    public function sample(): \think\response\View
    {
        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        if ($keyword) {
            $where['product_code|product_desc'] = ['like', '%' . $keyword . '%'];
        } else {
            $where = [];
        }

        // 查看权限
        $access_ids = AccountModel::account_access_ids();
        if (AccountModel::account_role() == "Developer") {
            $where['develop_id'] = ['in', $access_ids];
            $status = $this->request->get('status', 0, 'intval');
        } elseif (AccountModel::account_role() == "Purchaser") {
            $where['purchaser_id'] = ['in', $access_ids];
            $status = $this->request->get('status', 3, 'intval');
        } else {
            $status = $this->request->get('status', 2, 'intval');
        }

        $this->assign('status', $status);
        if ($status != -1) {
            $where['status'] = $status;
        }

        // 报价单列表
        $quoteTableObj = new QuoteProductModel();
        $list = $quoteTableObj->with(['developer', 'purchaser', 'quote'])->where($where)->order('id desc')->paginate(Config::get('PAGE_NUM'), false, ['query' => ['keyword' => $keyword, 'status' => $status]]);
        $this->assign('list', $list);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');

        return view();
    }

    /**
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     */
    public function accounting($id)
    {
        $quoteProductObj = new QuoteProductModel();
        $info = $quoteProductObj->find($id);
        $list = $quoteProductObj->where(['table_id' => $info['table_id'], 'product_code' => $info['product_code']])->select();
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!(floatval($post['cost']) xor floatval($post['fob']))) {
                echo json_encode(['code' => 0, 'msg' => '请填写出厂价或Fob价']);
                exit();
            }
            if (empty($post['min_price'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写最低市场售价']);
                exit();
            }
            if (empty($post['target_pricing'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写目标定价']);
                exit();
            }
            foreach ($list as $item) {
                unset($item['accounting']);
                unset($item['prototype_accounting']);
                $post['product'][] = $item->toArray();
            }
            $result = PriceModel::generateProductAccounting($post);
            if ($result) {
                $updateData = [
                    'accounting'    =>  $result,
                    'status'        =>  1,
                    'cost'          =>  $post['cost'],
                    'fob'           =>  $post['fob']
                ];
                if ($quoteProductObj->where(['table_id' => $info['table_id'], 'product_code' => $info['product_code']])->update($updateData)) {
                    echo json_encode(['code' => 1, 'msg' => '核算成功']);
                } else {
                    echo json_encode(['code' => 0, 'msg' => '核算失败，请重试']);
                }
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '核价失败，请重试']);
                exit();
            }
        } else {
            $this->assign('info', $info);
            $this->assign('competitor_image', $info['competitor_image'] ? explode(',', $info['competitor_image']) : []);
            $this->assign('accounting', json_decode($info['accounting'], true));
            $this->assign('competitor', json_decode($info['competitor'], true));
            $this->assign('list', $list);

            $filename = APP_PATH . 'price.php';
            $web_params = file_exists($filename) ? include($filename) : [];
            $this->assign('config', $web_params);

            return view();
        }
    }

    /**
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function accounting_save($id, $type = 1)
    {
        if ($this->request->isPost()) {
            $quoteProductObj = new QuoteProductModel();
            $info = $quoteProductObj->find($id);
            if (($type == 1 && empty($info['accounting']))
                || ($type == 2 && empty($info['prototype_accounting']))) {
                echo json_encode(['code' => 0, 'msg' => '请先提交核价']);
                exit();
            }
            $model = new QuoteAccountingLogModel();
            $accounting = json_decode($info['accounting'], true);
            $prototype_accounting = json_decode($info['prototype_accounting'], true);
            $newLog = [
                'table_id'          =>  $info['table_id'],
                'product_code'      =>  $info['product_code'],
                'cost'              =>  $type == 1 ? $info['cost'] : $info['prototype_cost'],
                'fob'               =>  $type == 1 ? $info['fob'] : $info['prototype_fob'],
                'accounting'        =>  $type == 1 ? $info['accounting'] : $info['prototype_accounting'],
                'target_pricing'    =>  $type == 1 ? $accounting['product']['target_pricing'] : $prototype_accounting['product']['target_pricing'],
                'type'              =>  $type,
                'user_id'           =>  Session::get(Config::get('USER_LOGIN_FLAG')),
                'created_time'      =>  date('Y-m-d H:i:s')
            ];

            if ($model->insert($newLog)) {
                echo json_encode(['code' => 1, 'msg' => '保存成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '保存失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作，请重试']);
        }
        exit();
    }

    /**
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     */
    public function accounting_log($id): \think\response\View
    {
        $quoteProductObj = new QuoteProductModel();
        $info = $quoteProductObj->find($id);
        $where['table_id'] = $info['table_id'];
        $where['product_code'] = $info['product_code'];

        // 列表
        $model = new QuoteAccountingLogModel();
        $list = $model->where($where)->order('id desc')->select();
        $this->assign('list', $list);

        return view();
    }

    /**
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function accounting_detail($id): \think\response\View
    {
        $model = new QuoteAccountingLogModel();
        $detail = $model->find($id);
        $quoteProductObj = new QuoteProductModel();
        $info = $quoteProductObj->where(['table_id' => $detail['table_id'], 'product_code' => $detail['product_code']])->find();
        $list = $quoteProductObj->where(['table_id' => $info['table_id'], 'product_code' => $info['product_code']])->select();

        $this->assign('info', $info);
        $this->assign('accounting', json_decode($detail['accounting'], true));
        $this->assign('list', $list);

        return view();
    }

    /**
     * @throws DbException
     */
    public function analysis($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (empty($post['competitor_image'])) {
                echo json_encode(['code' => 0, 'msg' => '请上传竞品图片']);
                exit();
            }
            if (empty($post['competitor_url'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写竞品地址']);
                exit();
            }
            $competitor = [];
            foreach ($post['competitor_image'] as $key => $item) {
                $competitor[] = [
                    'competitor_image'  =>  $item,
                    'competitor_url'    =>  $post['competitor_url'][$key]
                ];
            }
            $data['competitor'] = json_encode($competitor);
            $data['competitor_addr'] = $post['competitor_addr'];
            $data['conclusion'] = $post['conclusion'];
            $model = new QuoteProductModel();
            $block = $model->find($id);
            $data['status'] = max($block['status'], 2);
            if ($model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->update($data)) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
            exit;
        } else {
            $info = QuoteProductModel::get(['id' => $id,]);
            $this->assign('info', $info);

            return view();
        }
    }

    // 打样
    /**
     * @throws DbException
     */
    public function sample_set($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $info = QuoteProductModel::get(['id' => $id,]);
            if (!in_array($info['status'], [3, 4, 5])) {
                echo json_encode(['code' => 0, 'msg' => '异常操作！']);
                exit();
            }
            if (empty($post['sample_date'])) {
                echo json_encode(['code' => 0, 'msg' => '请选择预计打样完成时间']);
                exit();
            }
            if (strtotime('+14 days', strtotime($info['audit_date'])) < strtotime($post['sample_date'])
                || strtotime($info['audit_date']) >= strtotime($post['sample_date'])) {
                echo json_encode(['code' => 0, 'msg' => '请选择审核后14天内的预计打样时间']);
                exit();
            }
            if (!empty($post['is_sample'])){
                $post['status'] = max(5, $info['status']);
                $post['sample_completion_date'] = date('Y-m-d');
                unset($post['is_sample']);
            } else {
                $post['status'] = 4;
            }
            $model = new QuoteProductModel();
            if ($model->update($post, ['table_id' => $info['table_id'], 'product_code' => $info['product_code']])) {
                echo json_encode(['code' => 1, 'msg' => '修改成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '修改失败，请重试']);
            }
            exit;
        } else {
            $info = QuoteProductModel::get(['id' => $id,]);
            $this->assign('info', $info);

            return view();
        }
    }

    /**
     * @throws DbException
     */
    public function accounting_approve()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            $where = [
                'table_id'      =>  $block['table_id'],
                'product_code'  =>  $block['product_code']
            ];
            $updateData = [
                'status'        =>  3,
                'audit_date'    =>  date('Y-m-d'),
                'audit_content' =>  $post['content']
            ];
            if ($model->save($updateData, $where)) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
        }
        exit;
    }

    /**
     * @throws DbException
     */
    public function accounting_dismiss()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            $where = [
                'table_id'      =>  $block['table_id'],
                'product_code'  =>  $block['product_code']
            ];
            $updateData = [
                'status'        =>  0,
                'audit_date'    =>  date('Y-m-d'),
                'audit_content' =>  $post['content']
            ];
            if ($model->save($updateData, $where)) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
        }
        exit;
    }

    /**
     * @throws DbException
     */
    public function accounting_deny()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            $where = [
                'table_id'      =>  $block['table_id'],
                'product_code'  =>  $block['product_code']
            ];
            $updateData = [
                'status'        =>  11,
                'audit_date'    =>  date('Y-m-d'),
                'audit_content' =>  $post['content']
            ];
            if ($model->save($updateData, $where)) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
        }
        exit;
    }

    /**
     * @throws DbException
     * @throws Exception
     */
    public function prototype(): \think\response\View
    {
        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        if ($keyword) {
            $where['product_code|product_desc'] = ['like', '%' . $keyword . '%'];
        } else {
            $where = [];
        }

        // 查看权限
        $access_ids = AccountModel::account_access_ids();
        if (AccountModel::account_role() == "Developer") {
            $where['develop_id'] = ['in', $access_ids];
            $status = $this->request->get('status', 5, 'intval');
        } elseif (AccountModel::account_role() == "Purchaser") {
            $where['purchaser_id'] = ['in', $access_ids];
            $status = $this->request->get('status', 3, 'intval');
        } else {
            $status = $this->request->get('status', 2, 'intval');
        }

        $this->assign('status', $status);
        if ($status != -1) {
            $where['status'] = $status;
        }

        // 报价单列表
        $quoteTableObj = new QuoteProductModel();
        $list = $quoteTableObj->with(['developer', 'purchaser', 'quote'])->where($where)->order('id desc')->paginate(Config::get('PAGE_NUM'), false, ['keyword' => $keyword, 'status' => $status]);
        $this->assign('list', $list);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');

        return view();
    }

    /**
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws DataNotFoundException
     * @throws \Exception
     */
    public function prototype_accounting($id)
    {
        $quoteProductObj = new QuoteProductModel();
        $info = $quoteProductObj->find($id);
        $list = $quoteProductObj->where(['table_id' => $info['table_id'], 'product_code' => $info['product_code']])->select();
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!(floatval($post['cost']) xor floatval($post['fob']))) {
                echo json_encode(['code' => 0, 'msg' => '请填写出厂价或Fob价']);
                exit();
            }
            if (empty($post['min_price'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写最低市场售价']);
                exit();
            }
            if (empty($post['target_pricing'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写目标定价']);
                exit();
            }
            foreach ($list as $item) {
                unset($item['accounting']);
                unset($item['prototype_accounting']);
                $post['product'][] = $item->toArray();
            }
            $result = PriceModel::generateProductAccounting($post);
            if ($result) {
                $updateData = [
                    'prototype_accounting'  =>  $result,
                    'status'                =>  6,
                    'prototype_cost'        =>  $post['cost'],
                    'prototype_fob'         =>  $post['fob']
                ];
                if ($quoteProductObj->where(['table_id' => $info['table_id'], 'product_code' => $info['product_code']])->update($updateData)) {
                    $dimensions = [];
                    foreach ($post['length'] as $k => $item) {
                        $dimensions[$k] = [
                            'prototype_product_length'  =>  $post['length'][$k],
                            'prototype_product_width'   =>  $post['width'][$k],
                            'prototype_product_height'  =>  $post['height'][$k],
                            'prototype_gross_weight'    =>  $post['gross_weight'][$k],
                            'prototype_net_weight'      =>  $post['net_weight'][$k],
                            'id'                        =>  $list[$k]['id']
                        ];
                    }
                    $quoteProductObj->saveAll($dimensions);

                    echo json_encode(['code' => 1, 'msg' => '核算成功']);
                } else {
                    echo json_encode(['code' => 0, 'msg' => '核算失败，请重试']);
                }
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '核价失败，请重试']);
                exit();
            }
        } else {
            $this->assign('info', $info);
            $this->assign('accounting', json_decode($info['prototype_accounting'] ?? $info['accounting'], true));
            $this->assign('prototype_accounting', json_decode($info['prototype_accounting'], true));
            $this->assign('competitor', json_decode($info['prototype_competitor'] ?? $info['competitor'], true));
            $this->assign('prototype_competitor', json_decode($info['prototype_competitor'], true));
            $this->assign('list', $list);

            return view();
        }
    }

    /**
     * @throws DbException
     */
    public function prototype_analysis($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (empty($post['competitor_image'])) {
                echo json_encode(['code' => 0, 'msg' => '请上传竞品图片']);
                exit();
            }
            if (empty($post['competitor_url'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写竞品地址']);
                exit();
            }
            $competitor = [];
            foreach ($post['competitor_image'] as $key => $item) {
                $competitor[] = [
                    'competitor_image'  =>  $item,
                    'competitor_url'    =>  $post['competitor_url'][$key]
                ];
            }
            $data['prototype_competitor'] = json_encode($competitor);
            $data['prototype_competitor_addr'] = $post['prototype_competitor_addr'];
            $data['prototype_conclusion'] = $post['prototype_conclusion'];
            $model = new QuoteProductModel();
            $block = $model->find($id);
            $data['status'] = max($block['status'], 7);
            if ($model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->update($data)) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
            exit;
        } else {
            $info = QuoteProductModel::get(['id' => $id,]);
            $this->assign('info', $info);

            return view();
        }
    }

    /**
     * @throws DbException
     */
    public function sample_approve()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (empty($post['suggestion'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写开发意见']);
                exit();
            }
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($block['status'] != 7) {
                echo json_encode(['code' => 0, 'msg' => '状态异常，不可操作']);
                exit;
            }
            $where = [
                'table_id'      =>  $block['table_id'],
                'product_code'  =>  $block['product_code']
            ];
            $updateData = [
                'status'                =>  8,
                'suggestion'            =>  $post['suggestion'],
                'prototype_audit_date'  =>  date('Y-m-d')
            ];
            if ($model->save($updateData, $where)) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
        }
        exit;
    }

    /**
     * @throws DbException
     */
    public function sample_dismiss()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (empty($post['suggestion'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写开发意见']);
                exit();
            }
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($block['status'] != 7) {
                echo json_encode(['code' => 0, 'msg' => '状态异常，不可操作']);
                exit;
            }
            $where = [
                'table_id'      =>  $block['table_id'],
                'product_code'  =>  $block['product_code']
            ];
            $updateData = [
                'status'                =>  3,
                'suggestion'            =>  $post['suggestion'],
                'prototype_audit_date'  =>  date('Y-m-d')
            ];
            if ($model->save($updateData, $where)) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
        }
        exit;
    }

    /**
     * @throws DbException
     */
    public function sample_deny()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (empty($post['suggestion'])) {
                echo json_encode(['code' => 0, 'msg' => '请填写开发意见']);
                exit();
            }
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($block['status'] != 7) {
                echo json_encode(['code' => 0, 'msg' => '状态异常，不可操作']);
                exit;
            }
            $where = [
                'table_id'      =>  $block['table_id'],
                'product_code'  =>  $block['product_code']
            ];
            $updateData = [
                'status'                =>  12,
                'suggestion'            =>  $post['suggestion'],
                'prototype_audit_date'  =>  date('Y-m-d')
            ];
            if ($model->save($updateData, $where)) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
        }
        exit;
    }

    /**
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws DataNotFoundException
     */
    public function transfer($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            Db::startTrans();
            try {
                $model = new QuoteProductModel();
                foreach ($post['user_id'] as $user) {
                    if ($model->update(['develop_id' => $user], ['id' => $id])) {
                        Db::commit();
                        echo json_encode(['code' => 1, 'msg' => '操作成功']);
                        exit;
                    } else {
                        throw new Exception("操作失败，请重试");
                    }
                }
            } catch (Exception $e) {
                Db::rollback();
                echo json_encode(['code' => 0, 'msg' => $e->getMessage()]);
                exit;
            }
        } else {
            $accessIds = AccountModel::account_access_ids();
            $this->assign('user', AccountModel::get(['id' => ['in', $accessIds]]));
            $model = new QuoteProductModel();
            $info = $model->find($id);
            $this->assign('info', $info);

            $userModel = new AccountModel();
            $userList = $userModel->where(['id' => ['in', $accessIds]])->select();
            foreach ($userList as $key => $value) {
                if ($value['id'] == $info['develop_id']) {
                    $userList[$key]['develop'] = 1;
                } else {
                    $userList[$key]['develop'] = 0;
                }
            }
            $this->assign('userList', $userList);

            return view();
        }
    }

    /**
     * @throws DbException
     * @throws Exception
     */
    public function recommend(): \think\response\View
    {
        // 查看权限
        $access_ids = AccountModel::account_access_ids();

        $month = $this->request->get('month', date('Y-m'));
        $monthStart = $month . '-01 00:00:00';
        $monthNext = date('Y-m-01 00:00:00', strtotime('+1 month'));
        $this->assign('month', $month);

        // 报价单列表
        $quoteTableObj = new QuoteTableModel();
        $list = $quoteTableObj->query('
SELECT
	d.nickname,
	COUNT( b.id ) count 
FROM
	( SELECT user_id FROM nbtlz_admin_user_role WHERE role_id = 8 ) a
	LEFT JOIN nbtlz_quote_product b ON a.user_id = b.purchaser_id
	LEFT JOIN nbtlz_quote_table c ON b.table_id = c.id
	LEFT JOIN nbtlz_admin_user d ON a.user_id = d.id 
WHERE
	c.created_time >= "' . $monthStart . '" 
	AND c.created_time < "' . $monthNext . '" 
GROUP BY
	nickname 
ORDER BY
	count DESC;
        ');
        $this->assign('list', $list);

        $monthSum = $quoteTableObj->alias('a')
            ->join('nbtlz_quote_product b', 'a.id = b.table_id')
            ->where(['created_time' => ['egt', $monthStart]])
            ->where(['created_time' => ['lt', $monthNext]])
            ->where(['purchaser_id' => ['in', $access_ids]])
            ->count();
        $this->assign('monthSum', $monthSum);

        return view();
    }
}
