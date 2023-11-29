<?php
namespace app\Manage\controller;

use app\Manage\model\InfoCategoryModel;
use app\Manage\model\InfoModel;
use app\Manage\validate\InfoCategoryValidate;
use think\Controller;
use think\Session;
use think\Config;

class InfoCategoryController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'asc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        if ($keyword) {
            $where = ['name|code' => ['like', '%' . $keyword . '%']];
        }
        $this->assign('keyword', $keyword);

        // 分类列表
        $list = new InfoCategoryModel;
        $list = $list->where($where)->order('sort ' . $sort . ',id asc')->select();
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
            $post['code'] = titleToSlug($post['name'], $post['code']);
            $dataValidate = new InfoCategoryValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new InfoCategoryModel();
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
            $dataValidate = new InfoCategoryValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new InfoCategoryModel();
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
            $this->assign('info', InfoCategoryModel::get(['id' => $id, 'language_id' => $this->language_id])->toArray());
            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            // 判断该分类下是否有图片
            $info = InfoModel::all(['status' => InfoModel::STATUS_ACTIVE, 'cid' => ['like', '%,' . $post['id']] . ',%'])->toArray();
            if ($info) {
                echo json_encode(['code' => 0, 'msg' => '请先删除该分类下的所有详情']);
                exit;
            }

            $category = InfoCategoryModel::get($post['id']);
            if ($category->delete()) {
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
            $category = new InfoCategoryModel();
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

    // 状态切换
    public function status()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $category = InfoCategoryModel::get($post['id']);
            $category['status'] = $category['status'] == InfoCategoryModel::STATUS_ACTIVE ? 0 : InfoCategoryModel::STATUS_ACTIVE;
            $category->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // // 获取分类
    // public function get_category()
    // {
    //     header('Content-Type:application/json; charset=utf-8');
    //     if ($this->request->isPost()) {
    //         $category = InfoCategoryModel::category_list(['language_id' => $this->language_id]);
    //         echo json_encode(['code' => 1, 'info' => $category]);
    //         exit;
    //     } else {
    //         echo json_encode(['code' => 0, 'msg' => '异常操作']);
    //         exit;
    //     }
    // }
}
