<?php
namespace app\Manage\controller;

use app\Manage\model\LinkModel;
use app\Manage\model\LinkCategoryModel;
use app\Manage\validate\LinkValidate;
use think\Controller;
use think\Session;
use think\Config;

class LinkController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $type = $this->request->get('type', 0, 'intval');
        if ($type) {
            $where['type'] = $type;
            $this->assign('type', $type);
        }

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        if ($keyword) {
            $where = ['link_name|link_url' => ['like', '%' . $keyword . '%']];
        }
        $this->assign('keyword', $keyword);

        $where['language_id'] = $this->language_id;
        $list = LinkModel::with(['category'])->where($where)->order('sort asc, id ' . $sort)->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);
        $this->assign('category', LinkCategoryModel::get_category($this->language_id));

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
            $dataValidate = new LinkValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new LinkModel();
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
            $this->assign('category', LinkCategoryModel::get_category($this->language_id));

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
            $dataValidate = new LinkValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new LinkModel();
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
            $info = LinkModel::get(['id' => $id])->toArray();
            $this->assign('info', $info);
            $this->assign('category', LinkCategoryModel::get_category($this->language_id));

            return view();
        }
    }

    // 删除
    public function delete()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (LinkModel::destroy($post['id'])) {
                echo json_encode(['code' => 1, 'msg' => '删除成功']);
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '删除失败，请重试']);
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
            $category = LinkModel::get($post['id']);
            $category['status'] = $category['status'] == LinkModel::STATUS_ACTIVE ? 0 : LinkModel::STATUS_ACTIVE;
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
            $info = new LinkModel();
            $data = [];
            foreach ($post['sort'] as $k => $v) {
                $data[] = ['id' => $k, 'sort' => $v];
            }
            $info->saveAll($data);
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
