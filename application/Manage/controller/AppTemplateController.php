<?php
namespace app\Manage\controller;

use app\Manage\model\AppTemplate;
use app\Manage\validate\AppTemplateValidate;
use think\Controller;
use think\Session;
use think\Config;

class AppTemplateController extends BaseController
{
    public function index()
    {
        // 网站模板
        $appTemplate = AppTemplate::all(['status' => AppTemplate::STATUS_ACTIVE])->toArray();
        $this->assign('list', $appTemplate);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 管理
    public function manage()
    {
        // 网站模板
        $AppTemplate = AppTemplate::all()->toArray();
        $this->assign('list', $AppTemplate);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 添加新模板
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['current'] = 0;
            $post['pic'] = $post['pic'][0];
            $dataValidate = new AppTemplateValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new AppTemplate();
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

    // 删除
    public function delete()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            // 判断是否是当前默认模板
            $template = AppTemplate::get($post['id']);
            if ($template['current'] == 1) {
                echo json_encode(['code' => 0, 'msg' => '默认模板不可删除']);
                exit;
            }

            if ($template->delete()) {
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
            $AppTemplate = AppTemplate::get($post['id']);
            if ($AppTemplate['current'] == AppTemplate::CURRENT_ACTIVE) {
                echo json_encode(['code' => 0, 'msg' => '默认模板不可关闭']);
                exit;
            }
            $AppTemplate['status'] = $AppTemplate['status'] == AppTemplate::STATUS_ACTIVE ? 0 : AppTemplate::STATUS_ACTIVE;
            $AppTemplate->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 设为默认模板
    public function set_default()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $AppTemplate = AppTemplate::get(['id' => $post['id']]);
            if ($AppTemplate['status'] != AppTemplate::STATUS_ACTIVE) {
                echo json_encode(['code' => 0, 'msg' => '该模板不能设为默认']);
                exit;
            }
            $defaultLanguage = AppTemplate::get(['current' => AppTemplate::CURRENT_ACTIVE]);
            $defaultLanguage->current = 0;
            $defaultLanguage->save();

            $AppTemplate->current = AppTemplate::CURRENT_ACTIVE;
            if ($AppTemplate->save()) {
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
}
