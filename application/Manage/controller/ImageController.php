<?php
namespace app\Manage\controller;

use app\Manage\model\ImageModel;
use app\Manage\model\ImageCategoryModel;
use app\Manage\validate\ImageValidate;
use think\Controller;
use think\Session;
use think\Config;

class ImageController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $cid = $this->request->get('cid', 0, 'intval');
        $this->assign('cid', $cid);
        if ($cid) {
            $category_arr[] = $cid;
            $category_child = ImageCategoryModel::all(['language_id' => $this->language_id, 'parent_id' => $cid, 'status' => ImageCategoryModel::STATUS_ACTIVE]);
            if ($category_child) {
                foreach ($category_child as $k => $v) {
                    $category_arr[] = $v['id'];
                }
            }
            $where['cid'] = ['in', $category_arr];
        }

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        if ($keyword) {
            $where = ['title' => ['like', '%' . $keyword . '%']];
        }
        $this->assign('keyword', $keyword);

        $image = new ImageModel();
        $where['language_id'] = $this->language_id;
        $list = $image->where($where)->order('id ' . $sort)->paginate(15);
        $this->assign('list', $list);
        $this->assign('category', ImageCategoryModel::category_list(['language_id' => $this->language_id]));

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 编辑
    public function edit()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['cid'] = $post['category'];
            unset($post['category']);
            $dataValidate = new ImageValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new ImageModel();
                if ($model->allowField(true)->save($post, ['id' => $post['id']])) {
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
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 删除图片
    public function delete()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!empty($post['img'])) {
                $image = new ImageModel();
                foreach ($post['img'] as $k => $v) {
                    // 删除图片
                    $info = $image->get($v);
                    if (file_exists('upload' . $info['url'])) {
                        unlink('upload' . $info['url']);
                    }
                    ImageModel::destroy($v);
                }
                echo json_encode(['code' => 1, 'msg' => '操作完成']);
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '请先选择图片']);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 获取所有该分类下的图片
    public function get_category_images()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $id = $this->request->post('id');
            if ($id) {
                $cid[] = $id;
                $child = ImageCategoryModel::all(['parent_id' => $id])->toArray();
                if ($child) {
                    foreach ($child as $k => $v) {
                        $cid[] = $v['id'];
                    }
                }
                $where = array(
                    'language_id'   =>  $this->language_id,
                    'status'        =>  ImageModel::STATUS_ACTIVE,
                    'cid'           =>  ['in', $cid]
                );
                $info = ImageModel::all($where)->toArray();
            } else {
                $info = ImageModel::where(['language_id' => $this->language_id, 'status' => ImageModel::STATUS_ACTIVE])->order('id desc')->limit(15)->select()->toArray();
            }
            echo json_encode(['code' => 1, 'info' => $info]);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 获取某个图片的详细数据
    public function get_image_info()
    {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $post = $this->request->post();
            if (!empty($post['id'])) {
                $image = ImageModel::get($post['id']);
                echo json_encode(['code' => 1, 'info' => $image]);
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => '请先选择图片']);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
