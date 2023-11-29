<?php
namespace app\Manage\controller;

use app\Manage\model\PageCategoryModel;
use app\Manage\model\PageModel;
use app\Manage\validate\PageCategoryValidate;
use think\Controller;
use think\Session;
use think\Config;

class PageCategoryController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'asc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        if ($keyword) {
            $where = ['name|slug' => ['like', '%' . $keyword . '%']];
        }
        $this->assign('keyword', $keyword);

        // 分类列表
        $where['language_id'] = $this->language_id;
        $list = PageCategoryModel::where($where)->order('sort asc, id '.$sort)->paginate(Config::get('PAGE_NUM'));
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
            $post['slug'] = titleToSlug($post['name'], $post['slug']);
            $dataValidate = new PageCategoryValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new PageCategoryModel();
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
            $dataValidate = new PageCategoryValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new PageCategoryModel();
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
            $this->assign('info', PageCategoryModel::get(['id' => $id, 'status' => PageCategoryModel::STATUS_ACTIVE, 'language_id' => $this->language_id])->toArray());

            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            // 判断该分类下是否有单页
            $images = PageModel::get(['status' => PageModel::STATUS_ACTIVE, 'cid' => $post['id']]);
            if ($images) {
                echo json_encode(['code' => 0, 'msg' => '请先删除该分类下的所有单页']);
                exit;
            }

            $category = PageCategoryModel::get($post['id']);
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

    // 状态切换
    public function status()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $category = PageCategoryModel::get($post['id']);
            $category['status'] = $category['status'] == PageCategoryModel::STATUS_ACTIVE ? 0 : PageCategoryModel::STATUS_ACTIVE;
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
            $category = new PageCategoryModel();
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
}
