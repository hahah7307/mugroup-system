<?php
namespace app\Manage\controller;

use app\Manage\model\AccountModel;
use app\Manage\model\PriceModel;
use app\Manage\model\QuoteProductModel;
use app\Manage\model\QuoteTableModel;
use app\Manage\model\StorageRuleModel;
use app\Manage\validate\StorageRuleValidate;
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
     */
    public function table()
    {
        // 查看权限
        $access_ids = AccountModel::account_access_ids();
        $where['user_id'] = ['in', $access_ids];

        // 报价单列表
        $quoteTableObj = new QuoteTableModel();
        $list = $quoteTableObj->where($where)->order('id asc')->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);

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
                        "table_id"              =>  $id,
                        "product_code"          =>  $item[0],
                        "supplier_name"         =>  $item[1],
                        "supplier_code"         =>  $item[2],
                        "img_url"               =>  $imageArr[$key],
                        "product_length"        =>  $item[4],
                        "product_width"         =>  $item[5],
                        "product_height"        =>  $item[6],
                        "gross_weight"          =>  $item[7],
                        "net_weight"            =>  $item[8],
                        "product_desc"          =>  $item[9],
                        "cost"                  =>  $item[10],
                        "currency"              =>  $item[11],
                        "region"                =>  $item[12],
                        "purchaser_id"          =>  $table['user_id'],
                        "develop_id"            =>  1
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
    public function product($id)
    {
        $where['table_id'] = $id;

        // 查看权限
        $access_ids = AccountModel::account_access_ids();
        $where['develop_id'] = ['in', $access_ids];

        // 报价单列表
        $quoteTableObj = new QuoteProductModel();
        $list = $quoteTableObj->with(['developer'])->where($where)->order('id asc')->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');

        return view();
    }

    /**
     * @throws DbException
     */
    public function sample()
    {
        // 查看权限
        $access_ids = AccountModel::account_access_ids();
        $where['develop_id'] = ['in', $access_ids];

        // 报价单列表
        $quoteTableObj = new QuoteProductModel();
        $list = $quoteTableObj->with(['developer'])->where($where)->order('id asc')->paginate(Config::get('PAGE_NUM'));
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
            $post['product'] = $list->toArray();
            $result = PriceModel::generateProductAccounting($post);
            if ($quoteProductObj->where(['table_id' => $info['table_id'], 'product_code' => $info['product_code']])->update(['accounting' => $result, 'status' => 1])) {
                echo json_encode(['code' => 1, 'msg' => '核算成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '核算失败，请重试']);
            }
            exit;
        } else {
            $this->assign('info', $info);
            $this->assign('competitor_image', explode(',', $info['competitor_image']));
            $this->assign('accounting', json_decode($info['accounting'], true));
            $this->assign('list', $list);

            $filename = APP_PATH . 'price.php';
            $web_params = file_exists($filename) ? include($filename) : [];
            $this->assign('config', $web_params);

            return view();
        }
    }

    // 编辑
    /**
     * @throws DbException
     */
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $info = QuoteProductModel::get(['id' => $id,]);
            if (!empty($post['is_sample'])){
                $post['status'] = max(5, $info['status']);
                unset($post['is_sample']);
            }
            $model = new QuoteProductModel();
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

    /**
     * @throws DbException
     */
    public function analysis($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $data['competitor_image'] = implode(',', $post['competitor_image']);
            $data['competitor_url'] = $post['competitor_url'];
            $data['conclusion'] = $post['conclusion'];
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->save($data, ['id' => $id])) {
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
    public function approved()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->setField('status', 3)) {
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
    public function reject()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->setField('status', 7)) {
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
    public function audit()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->setField('status', 6)) {
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
    public function refuse()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->setField('status', 6)) {
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
    public function suggestion()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            $block = $model->find($post['id']);
            if ($model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->setField('status', 3)) {
                $model->where(['table_id' => $block['table_id'], 'product_code' => $block['product_code']])->setField('suggestion', $post['suggestion']);
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
        }
        exit;
    }

    // 编辑
    /**
     * @throws DbException
     */
    public function sample_set($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $model = new QuoteProductModel();
            if ($model->save($post, ['id' => $id])) {
                echo json_encode(['code' => 1, 'msg' => '修改成功']);
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '修改失败，请重试']);
                exit;
            }
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
            $block = StorageRuleModel::get($post['id']);
            if ($block->delete()) {
                echo json_encode(['code' => 1, 'msg' => '操作成功']);
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 状态切换

    /**
     * @throws DbException
     */
    public function status()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $user = StorageRuleModel::get($post['id']);
            $user['state'] = $user['state'] == StorageRuleModel::STATE_ACTIVE ? 0 : StorageRuleModel::STATE_ACTIVE;
            $user->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
