<?php
namespace app\Manage\controller;

use app\Manage\model\MemberModel;
use app\Manage\model\MemberRankModel;
use app\Manage\model\MemberRelationModel;
use app\Manage\validate\MemberValidate;
use think\Controller;
use think\Session;
use think\Db;
use think\Config;

class MemberController extends BaseController
{
    public function index()
    {
        $rank = $this->request->get('rank', 0, 'intval');
        if ($rank) {
            $where['rank'] = ['like', '%,' . $rank . ',%'];
            $this->assign('rank', $rank);
        }

        $sort = $this->request->get('sort', 'desc', 'htmlspecialchars');
        $this->assign('sort', $sort);

        $keyword = $this->request->get('keyword', '', 'htmlspecialchars');
        $this->assign('keyword', $keyword);
        if ($keyword) {
            $where['company_name|legal_name|legal_tel|legal_phone|lxr_name|lxr_tel|lxr_phone'] = ['like', '%' . $keyword . '%'];
        }

        // 会员列表
        $list = new MemberModel;
        $list = MemberModel::with(['memberRelation.category'])->where($where)->order('id '.$sort)->paginate(Config::get('PAGE_NUM'));
        $this->assign('list', $list);
        $this->assign('ranks', MemberRankModel::all(['status' => MemberRankModel::STATUS_ACTIVE]));

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 添加
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['logo'] = $post['logo'][0];
            $post['slug'] = titleToSlug($post['company_name'], $post['slug']);
            $rank = explode(',', $post['rank']);
            $post['rank'] = ',' . $post['rank'] . ',';
            Db::startTrans();
            try {
                $dataValidate = new MemberValidate();
                if ($dataValidate->scene('add')->check($post)) {
                    $model = new MemberModel();
                    if ($model->allowField(true)->save($post)) {
                        $id = $model->id;
                        $sort = 0;
                        foreach ($rank as $k => $v) {
                            $data = ['mid' => $id, 'rid' => $v, 'sort' => $sort];
                            if (MemberRelationModel::create($data)) {
                                $sort ++;
                            } else {
                                throw new Exception('添加失败，请重试');
                            }
                        }
                        Db::commit();
                        echo json_encode(['code' => 1, 'msg' => '添加成功']);
                        exit;
                    } else {
                        throw new Exception('添加失败，请重试');
                    }
                } else {
                    throw new Exception($dataValidate->getError());
                }
            } catch (Exception $e) {
                Db::rollback();
                echo json_encode(['code' => 0, 'msg' => $e->getMessage()]);
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
            $post['logo'] = $post['logo'][0];
            $post['slug'] = titleToSlug($post['company_name'], $post['slug']);
            $rank = explode(',', $post['rank']);
            $post['rank'] = ',' . $post['rank'] . ',';
            Db::startTrans();
            try {
                $dataValidate = new MemberValidate();
                if ($dataValidate->scene('edit')->check($post)) {
                    $model = new MemberModel();
                    if ($model->allowField(true)->save($post, ['id' => $id])) {
                        MemberRelationModel::where('mid','=',$id)->delete();
                        $sort = 0;
                        foreach ($rank as $k => $v) {
                            $data = ['mid' => $id, 'rid' => $v, 'sort' => $sort];
                            if (MemberRelationModel::create($data)) {
                                $sort ++;
                            } else {
                                throw new Exception('修改失败，请重试');
                            }
                        }
                        Db::commit();
                        echo json_encode(['code' => 1, 'msg' => '修改成功']);
                        exit;
                    } else {
                        throw new Exception('修改失败，请重试');
                    }
                } else {
                    throw new Exception($dataValidate->getError());
                }
            } catch (Exception $e) {
                Db::rollback();
                echo json_encode(['code' => 0, 'msg' => $e->getMessage()]);
                exit;
            }
        } else {
            $info = MemberModel::get(['id' => $id]);
            $this->assign('info', $info);
            $this->assign('rank', MemberRankModel::all(['status' => MemberRankModel::STATUS_ACTIVE]));

            return view();
        }
    }

    // 风采
    public function feature($id)
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $dataValidate = new MemberValidate();
            if ($dataValidate->scene('feature')->check($post)) {
                $model = new MemberModel();
                if ($model->allowField(true)->save($post, ['id' => $id])) {
                    echo json_encode(['code' => 1, 'msg' => '提交成功']);
                    exit;
                } else {
                    echo json_encode(['code' => 0, 'msg' => '提交失败，请重试']);
                    exit;
                }
            } else {
                echo json_encode(['code' => 0, 'msg' => $dataValidate->getError()]);
                exit;
            }
        } else {
            $info = MemberModel::get(['id' => $id]);
            $this->assign('info', $info);

            return view();
        }
    }

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $member = MemberModel::get($post['id']);
            if ($member->delete()) {
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
            $member = MemberModel::get($post['id']);
            $member['status'] = $member['status'] == MemberModel::STATUS_ACTIVE ? 0 : MemberModel::STATUS_ACTIVE;
            $member->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }
}
