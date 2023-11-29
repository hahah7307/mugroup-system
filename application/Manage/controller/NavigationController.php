<?php
namespace app\Manage\controller;

use app\Manage\model\NavigationModel;
use app\Manage\validate\NavigationValidate;
use think\Controller;
use think\Session;
use think\Config;

class NavigationController extends BaseController
{
    public function index()
    {
        // 导航栏列表
        $list = new NavigationModel;
        $list = $list->where(['language_id' => $this->language_id])->order('sort asc')->paginate(Config::get('PAGE_NUM'));
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
            $post['type'] = NavigationModel::TYPE_DEFAULT;
            $dataValidate = new NavigationValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new NavigationModel();
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
            $navis = NavigationModel::parent_navi($this->language_id);
            $this->assign('navis', $navis);

            return view();
        }
    }

    // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['type'] = NavigationModel::TYPE_DEFAULT;
            $dataValidate = new NavigationValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new NavigationModel();
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
            $this->assign('info', NavigationModel::get(['id' => $id, 'language_id' => $this->language_id])->toArray());
            $navis = NavigationModel::parent_navi($this->language_id);
            $this->assign('navis', $navis);

            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $navigation = NavigationModel::get($post['id']);
            if ($navigation->delete()) {
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

    // 排序
    public function sort()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $category = new NavigationModel();
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

    // 下拉
    public function drop()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $category = NavigationModel::get($post['id']);
            $category['dropdown'] = $category['dropdown'] == NavigationModel::DROP_ACTIVE ? 0 : NavigationModel::DROP_ACTIVE;
            $category->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 新窗口
    public function target()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $category = NavigationModel::get($post['id']);
            $category['new_target'] = $category['new_target'] == NavigationModel::TARGET_ACTIVE ? 0 : NavigationModel::TARGET_ACTIVE;
            $category->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
