<?php
namespace app\Manage\controller;

use app\Manage\model\InfoModel;
use app\Manage\model\InfoCategoryModel;
use app\Manage\validate\InfoValidate;
use think\Controller;
use think\Session;
use think\Config;

class InfoController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $cid = $this->request->get('cid', 0, 'intval');
        $this->assign('cid', $cid);
        if ($cid) {
            $where['cid'] = ['like', "%" . $cid . "%"];
        }

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        if ($keyword) {
            $where = ['title' => ['like', '%' . $keyword . '%']];
        }
        $this->assign('keyword', $keyword);

        $image = new InfoModel();
        $where['language_id'] = $this->language_id;
        $list = $image->where($where)->order('sort asc, id ' . $sort)->select()->toArray();
        $this->assign('list', $list);
        $this->assign('category', InfoCategoryModel::all(['language_id' => $this->language_id, 'status' => InfoCategoryModel::STATUS_ACTIVE]));

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 添加
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['cid'] = ',' . $post['cid'] . ',';
            $post['content'] = htmlentities($post['content']);
            $post['pic'] = $post['pic'][0];
            $dataValidate = new InfoValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new InfoModel();
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
            return view();
        }
    }

    // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['cid'] = ',' . $post['cid'] . ',';
            $post['content'] = htmlentities($post['content']);
            $post['pic'] = $post['pic'][0];
            $dataValidate = new InfoValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new InfoModel();
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
            $info = InfoModel::get(['id' => $id])->toArray();
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
            if (InfoModel::destroy($post['id'])) {
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

    // 排序
    public function sort()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $info = new InfoModel();
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

    // 获取详情列表
    public function get_infos()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $id = $this->request->post('id');
            $list = InfoModel::all(['language_id' => $this->language_id, 'status' => InfoModel::STATUS_ACTIVE, 'cid' => ['like', '%,'.$id.',%']])->toArray();
            if ($list) {
                echo json_encode(['code' => 1, 'info' => $list]);
                exit;
            } else {
                echo json_encode(['code' => 0, 'info' => '数据异常']);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 获取具体详情内容
    public function get_info_content()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $id = $this->request->post('id');
            $info = InfoModel::get(['language_id' => $this->language_id, 'status' => InfoModel::STATUS_ACTIVE, 'id' => $id])->toArray();
            if ($info) {
                echo json_encode(['code' => 1, 'info' => $info['content']]);
                exit;
            } else {
                echo json_encode(['code' => 0, 'info' => '数据异常']);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
