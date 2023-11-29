<?php
namespace app\Manage\controller;

use app\Manage\model\ServiceModel;
use app\Manage\validate\ServiceValidate;
use think\Controller;
use think\Session;
use think\Config;

class ServiceController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        if ($keyword) {
            $where = ['name|account' => ['like', '%' . $keyword . '%']];
        }
        $this->assign('keyword', $keyword);

        $service = new ServiceModel();
        $where['language_id'] = $this->language_id;
        $list = $service->where($where)->order('sort asc, id ' . $sort)->paginate(Config::get('PAGE_NUM'));
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
            $post['image'] = $post['image'][0];
            $dataValidate = new ServiceValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new ServiceModel();
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
            $this->assign('type', ServiceModel::get_service_type());

            return view();
        }
    }

    // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['image'] = $post['image'][0];
            $dataValidate = new ServiceValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new ServiceModel();
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
            $this->assign('type', ServiceModel::get_service_type());
            $info = ServiceModel::get(['id' => $id])->toArray();
            $this->assign('info', $info);

            return view();
        }
    }

    // 删除
    public function delete()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (ServiceModel::destroy($post['id'])) {
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
            $category = ServiceModel::get($post['id']);
            $category['status'] = $category['status'] == ServiceModel::STATUS_ACTIVE ? 0 : ServiceModel::STATUS_ACTIVE;
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
            $info = new ServiceModel();
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
