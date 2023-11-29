<?php
namespace app\Manage\controller;

use app\Manage\model\DownloadModel;
use app\Manage\model\DownloadCategoryModel;
use app\Manage\validate\DownloadValidate;
use think\Controller;
use think\Session;
use think\Config;

class DownloadController extends BaseController
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

        // 下载列表
        $list = new DownloadModel;
        $list = DownloadModel::where($where)->order('sort asc, id '.$sort)->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);
        $this->assign('category', DownloadCategoryModel::all(['status' => DownloadCategoryModel::STATUS_ACTIVE]));

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 添加
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $dataValidate = new DownloadValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new DownloadModel();
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
            $category = DownloadCategoryModel::all(['status' => DownloadCategoryModel::STATUS_ACTIVE]);
            $this->assign('category', $category);

            return view();
        }
    }

    // 编辑
    public function edit($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $dataValidate = new DownloadValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new DownloadModel();
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
            $category = DownloadCategoryModel::all(['status' => DownloadCategoryModel::STATUS_ACTIVE]);
            $this->assign('category', $category);

            $info = DownloadModel::get(['id' => $id, 'status' => DownloadModel::STATUS_ACTIVE])->toArray();
            $this->assign('info', $info);

            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $download = DownloadModel::get($post['id']);
            if (unlink(substr($download['url'], 1))) {
                if ($download->delete()) {
                    echo json_encode(['code' => 1, 'msg' => '操作成功']);
                    exit;
                } else {
                    echo json_encode(['code' => 0, 'msg' => '操作失败，请重试']);
                    exit;
                }
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
            $category = DownloadModel::get($post['id']);
            $category['status'] = $category['status'] == DownloadModel::STATUS_ACTIVE ? 0 : DownloadModel::STATUS_ACTIVE;
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
            $category = new DownloadModel();
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
