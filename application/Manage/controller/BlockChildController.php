<?php
namespace app\Manage\controller;

use app\Manage\model\BlockChildModel;
use app\Manage\model\BlockModel;
use app\Manage\validate\BlockChildValidate;
use think\Controller;
use think\Session;
use think\Config;

class BlockChildController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $cid = $this->request->get('cid', 0, 'intval');
        $this->assign('cid', $cid);
        if ($cid) {
            $where['block_id'] = $cid;
        }

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        if ($keyword) {
            $where['title'] = ['like', '%' . $keyword . '%'];
        }

        // 广告列表
        $list = new BlockChildModel;
        $list = BlockChildModel::with(['block'])->where($where)->order('id '.$sort.', sort asc')->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);
        $this->assign('group', BlockModel::get_group_block($this->language_id));

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 添加
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['pictures'] = $post['pictures'][0];
            $dataValidate = new BlockChildValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new BlockChildModel();
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
            $this->assign('banners', $this->banners);

            return view();
        }
    }

    // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['pictures'] = $post['pictures'][0];
            $dataValidate = new BlockChildValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new BlockChildModel();
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
            $info = BlockChildModel::get(['id' => $id, 'language_id' => $this->language_id])->toArray();
            $block = BlockModel::get(['id' => $info['block_id'], 'language_id' => $this->language_id, 'status' => BlockModel::STATUS_ACTIVE]);
            $this->assign('info', $info);
            $this->assign('block', $block);
            $this->assign('banners', $this->banners);

            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $block = BlockChildModel::get($post['id']);
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
            $category = BlockChildModel::get($post['id']);
            $category['status'] = $category['status'] == BlockChildModel::STATUS_ACTIVE ? 0 : BlockChildModel::STATUS_ACTIVE;
            $category->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 排序
    public function sort()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $category = new BlockChildModel();
            $data = [];
            foreach ($post['sort'] as $k => $v) {
                $data[] = ['id' => $k, 'sort' => $v];
            }
            $category->saveAll($data);
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 获取当前模板该木块下的banner
    public function get_template_banner()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $index = $this->request->post('index');
            $list = $this->banners[$index];
            echo json_encode(['code' => 1, 'info' => $list]);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
