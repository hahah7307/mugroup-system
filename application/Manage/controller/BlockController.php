<?php
namespace app\Manage\controller;

use app\Manage\model\BlockModel;
use app\Manage\model\BlockChildModel;
use app\Manage\validate\BlockValidate;
use think\Controller;
use think\Session;
use think\Config;

class BlockController extends BaseController
{
    public function index()
    {
        // 广告位列表
        $list = new BlockModel;
        $list = $list->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 添加
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $dataValidate = new BlockValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new BlockModel();
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
            $this->assign('block_index', BlockModel::get_block_index());
            $this->assign('type', BlockModel::get_type());

            return view();
        }
    }

    // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $dataValidate = new BlockValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new BlockModel();
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
            $this->assign('block_index', BlockModel::get_block_index());
            $this->assign('type', BlockModel::get_type());
            $this->assign('info', BlockModel::get(['id' => $id, 'language_id' => $this->language_id, 'status' => BlockModel::STATUS_ACTIVE])->toArray());

            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            // 判断该分类下是否有图片
            $info = BlockChildModel::all(['status' => BlockChildModel::STATUS_ACTIVE, 'block_id' => $post['id']])->toArray();
            if ($info) {
                echo json_encode(['code' => 0, 'msg' => '请先删除该广告位下的所有广告']);
                exit;
            }

            $block = BlockModel::get($post['id']);
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
    public function status()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $category = BlockModel::get($post['id']);
            $category['status'] = $category['status'] == BlockModel::STATUS_ACTIVE ? 0 : BlockModel::STATUS_ACTIVE;
            $category->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
