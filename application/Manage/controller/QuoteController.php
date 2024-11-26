<?php
namespace app\Manage\controller;

use app\Manage\model\AccountModel;
use app\Manage\model\QuoteProductModel;
use app\Manage\model\QuoteTableModel;
use app\Manage\model\StorageRuleModel;
use app\Manage\validate\StorageRuleValidate;
use PHPExcel_IOFactory;
use PHPExcel_Reader_Exception;
use PHPExcel_Worksheet_Drawing;
use think\Db;
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

    // 添加
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['state'] = StorageRuleModel::STATE_ACTIVE;
            $post['storage_id'] = input('storage_id');
            $post['condition'] = json_encode(['min' => $post['min'], 'max' => $post['max']]);
            $dataValidate = new StorageRuleValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new StorageRuleModel();
                if ($model->allowField(true)->save($post)) {
                    echo json_encode(['code' => 1, 'msg' => '添加成功']);
                    exit;
                } else {
                    echo json_encode(['code' => 0, 'msg' => '添加失败，请重试']);
                    exit;
                }
            } else {
                echo json_encode(['code' => 0, 'msg' => $dataValidate->getError()]);
                exit;
            }
        } else {
            $this->assign('storage_id', input('storage_id'));

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
            $post['condition'] = json_encode(['min' => $post['min'], 'max' => $post['max']]);
            $dataValidate = new StorageRuleValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new StorageRuleModel();
                if ($model->allowField(true)->save($post, ['id' => $id])) {
                    echo json_encode(['code' => 1, 'msg' => '修改成功']);
                    exit;
                } else {
                    echo json_encode(['code' => 0, 'msg' => '修改失败，请重试']);
                    exit;
                }
            } else {
                echo json_encode(['code' => 0, 'msg' => $dataValidate->getError()]);
                exit;
            }
        } else {
            $info = StorageRuleModel::get(['id' => $id,]);
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
