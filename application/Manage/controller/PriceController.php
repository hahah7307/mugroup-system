<?php
namespace app\Manage\controller;

use app\Manage\model\PriceModel;
use app\Manage\model\ArticleCategoryModel;
use app\Manage\validate\ArticleValidate;
use think\Controller;
use think\Session;
use think\Config;

class PriceController extends BaseController
{
    public function index()
    {
        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        if ($keyword) {
            $where['title'] = ['like', '%' . $keyword . '%'];
        }

        // 核价列表
        $list = new PriceModel;
        $list = PriceModel::where($where)->order('id '.$sort)->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);

        return view();
    }

    // 添加
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['language_id'] = $this->language_id;
            $post['created_at'] = strtotime($post['created_at']);
            $post['thumb'] = $post['thumb'][0];
            $post['slug'] = titleToSlug($post['title'], $post['slug']);
            $dataValidate = new ArticleValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new PriceModel();
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
            $post['created_at'] = strtotime($post['created_at']);
            $post['thumb'] = $post['thumb'][0];
            $dataValidate = new ArticleValidate();
            if ($dataValidate->scene('edit')->check($post)) {
                $model = new PriceModel();
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
            $info = PriceModel::get(['id' => $id, 'language_id' => $this->language_id, 'status' => PriceModel::STATUS_ACTIVE])->toArray();
            $this->assign('category', ArticleCategoryModel::all(['language_id' => $this->language_id, 'status' => ArticleCategoryModel::STATUS_ACTIVE]));
            $this->assign('info', $info);

            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $block = PriceModel::get($post['id']);
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
            $category = PriceModel::get($post['id']);
            $category['status'] = $category['status'] == PriceModel::STATUS_ACTIVE ? 0 : PriceModel::STATUS_ACTIVE;
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
            $category = new PriceModel();
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

    // 校验三边长度
    public function ajaxLengthRule() {
        header('Content-Type:application/json; charset=utf-8');
        if ($this->request->isPost()) {
            $length = $this->request->post('length');
            $width = $this->request->post('width');
            $height = $this->request->post('height');
            if (!empty($length) && !empty($width) && !empty($height)) {
                if (!is_numeric($length) || !is_numeric($width) || !is_numeric($height)) {
                    echo json_encode(['code' => 2, 'info' => '请输入正确的数字！']);
                    exit;
                }
                $arr = [$length, $width, $height];
                $maxLength = max($arr);
                // verify max length
                if ($maxLength >= 240) {
                    echo json_encode(['code' => 2, 'info' => '最长边不得超过' . Config::get('min_3leng') . 'cm！']);
                    exit;
                }
                // verify volume
                $volume = 0;
                $isMax = 0;
                foreach ($arr as $value) {
                    if ($value == $maxLength && $isMax == 0) {
                        $volume += $maxLength;
                        $isMax ++;
                    } else {
                        $volume += 2 * $value;
                    }
                }
                if ($volume >= 313) {
                    echo json_encode(['code' => 2, 'info' => '最长边与其他边的两倍之和为' . $volume . 'cm超过' . Config::get('min_5leng') . 'cm！']);
                    exit;
                }
                echo json_encode(['code' => 1, 'info' => 'success']);
                exit;
            } else {
                echo json_encode(['code' => 0, 'info' => 'Incomplete data']);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => 'Abnormal operation']);
            exit;
        }
    }
}
