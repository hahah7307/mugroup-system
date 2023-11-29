<?php
namespace app\Manage\controller;

use app\Manage\model\NoticeModel;
use app\Manage\model\NoticeCategoryModel;
use app\Manage\validate\NoticeValidate;
use think\Controller;
use think\Session;
use think\Config;

class NoticeController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $cid = $this->request->get('cid', 0, 'intval');
        $this->assign('cid', $cid);
        if ($cid) {
            $where['cid'] = $cid;
        }

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        if ($keyword) {
            $where['title'] = ['like', '%' . $keyword . '%'];
        }
        $where['language_id'] = $this->language_id;

        // 广告列表
        $list = new NoticeModel;
        $list = NoticeModel::with(['category'])->where($where)->order('sort asc, id '.$sort)->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);
        $this->assign('category', NoticeCategoryModel::get_category($this->language_id));

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 添加
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['created_at'] = strtotime($post['created_at']);
            $post['slug'] = titleToSlug($post['title'], $post['slug']);
            $dataValidate = new NoticeValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new NoticeModel();
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
            $this->assign('category', NoticeCategoryModel::all(['language_id' => $this->language_id, 'status' => NoticeCategoryModel::STATUS_ACTIVE]));

            return view();
        }
    }

    // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['created_at'] = strtotime($post['created_at']);
            $post['slug'] = titleToSlug($post['title'], $post['slug']);
            $dataValidate = new NoticeValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new NoticeModel();
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
            $info = NoticeModel::get(['id' => $id, 'language_id' => $this->language_id, 'status' => NoticeModel::STATUS_ACTIVE])->toArray();
            $this->assign('category', NoticeCategoryModel::all(['language_id' => $this->language_id, 'status' => NoticeCategoryModel::STATUS_ACTIVE]));
            $this->assign('info', $info);

            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $block = NoticeModel::get($post['id']);
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
            $category = NoticeModel::get($post['id']);
            $category['status'] = $category['status'] == NoticeModel::STATUS_ACTIVE ? 0 : NoticeModel::STATUS_ACTIVE;
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
            $category = new NoticeModel();
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
