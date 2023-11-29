<?php
namespace app\Manage\controller;

use app\Manage\model\ImageCategoryModel;
use app\Manage\model\ImageModel;
use app\Manage\validate\ImageCategoryValidate;
use think\Controller;
use think\Session;
use think\Config;

class ImageCategoryController extends BaseController
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
        $where['language_id'] = $this->language_id;
        $list = ImageCategoryModel::category_list($where, $sort);
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
            $dataValidate = new ImageCategoryValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new ImageCategoryModel();
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

            $this->assign('category', ImageCategoryModel::category_fa(['language_id' => $this->language_id]));
            return view();
        }
    }

    // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $dataValidate = new ImageCategoryValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new ImageCategoryModel();
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
            $this->assign('info', ImageCategoryModel::get(['id' => $id, 'status' => ImageCategoryModel::STATUS_ACTIVE, 'language_id' => $this->language_id])->toArray());
            $this->assign('category', ImageCategoryModel::category_fa(['language_id' => $this->language_id]));
            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            // 先判断是否有子分类
            $category_child = ImageCategoryModel::get(['status' => ImageCategoryModel::STATUS_ACTIVE, 'parent_id' => $post['id']]);
            if ($category_child) {
                echo json_encode(['code' => 0, 'msg' => '请先删除子分类']);
                exit;
            }
            // 再判断该分类下是否有图片
            $images = ImageModel::get(['status' => ImageModel::STATUS_ACTIVE, 'cid' => $post['id']]);
            if ($images) {
                echo json_encode(['code' => 0, 'msg' => '请先删除该分类下的所有图片']);
                exit;
            }

            $category = ImageCategoryModel::get($post['id']);
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
            $category = new ImageCategoryModel();
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
            $category = ImageCategoryModel::get($post['id']);
            $category['status'] = $category['status'] == ImageCategoryModel::STATUS_ACTIVE ? 0 : ImageCategoryModel::STATUS_ACTIVE;
            $category->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 获取分类
    public function get_category()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $category = ImageCategoryModel::category_list(['language_id' => $this->language_id]);
            echo json_encode(['code' => 1, 'info' => $category]);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
