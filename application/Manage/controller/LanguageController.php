<?php
namespace app\Manage\controller;

use app\Manage\model\WebsiteLanguage;
use app\Manage\validate\WebsiteLanguageValidate;
use \think\Controller;
use think\Session;
use think\Config;

class LanguageController extends BaseController
{
    public function index()
    {
        // 网站语言
        $websiteLanguage = WebsiteLanguage::all(['is_avail' => WebsiteLanguage::AVIAIL_ACTIVE])->toArray();
        $this->assign('list', $websiteLanguage);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 管理
    public function manage()
    {
        // 网站语言
        $websiteLanguage = WebsiteLanguage::all()->toArray();
        $this->assign('list', $websiteLanguage);

        Session::set(Config::get('BACK_URL'), $this->request->url(), 'manage');
        return view();
    }

    // 添加新语言
    public function add()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $post['is_default'] = 0;
            $post['icon'] = $post['icon'][0];
            $dataValidate = new WebsiteLanguageValidate();
            if ($dataValidate->scene('add')->check($post)) {
                $model = new WebsiteLanguage();
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

    // 状态切换
    public function status()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $websiteLanguage = WebsiteLanguage::get($post['id']);
            if ($websiteLanguage['is_default'] == WebsiteLanguage::DEFAULT_ACTIVE) {
                echo json_encode(['code' => 0, 'msg' => '默认语言不可关闭']);
                exit;
            }
            $websiteLanguage['status'] = $websiteLanguage['status'] == WebsiteLanguage::STATUS_ACTIVE ? 0 : WebsiteLanguage::STATUS_ACTIVE;
            $websiteLanguage->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 是否开启
    public function open()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $websiteLanguage = WebsiteLanguage::get($post['id']);
            if ($websiteLanguage['is_default'] == WebsiteLanguage::DEFAULT_ACTIVE) {
                echo json_encode(['code' => 0, 'msg' => '默认语言不可关闭']);
                exit;
            }
            $websiteLanguage['is_avail'] = $websiteLanguage['is_avail'] == WebsiteLanguage::AVIAIL_ACTIVE ? 0 : WebsiteLanguage::AVIAIL_ACTIVE;
            $websiteLanguage->save();
            echo json_encode(['code' => 1, 'msg' => '操作成功']);
            exit;
        } else {
            echo json_encode(['code' => 0, 'msg' => '异常操作']);
            exit;
        }
    }

    // 设为默认语言
    public function set_default()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post();
            $websiteLanguage = WebsiteLanguage::get(['id' => $post['id']]);
            if ($websiteLanguage['is_avail'] != WebsiteLanguage::AVIAIL_ACTIVE || $websiteLanguage['status'] != WebsiteLanguage::STATUS_ACTIVE) {
                echo json_encode(['code' => 0, 'msg' => '该语言不能上设为默认']);
                exit;
            }
            $defaultLanguage = WebsiteLanguage::get(['is_default' => WebsiteLanguage::DEFAULT_ACTIVE]);
            $defaultLanguage->is_default = 0;
            $defaultLanguage->save();

            $websiteLanguage->is_default = WebsiteLanguage::DEFAULT_ACTIVE;
            if ($websiteLanguage->save()) {
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

    // 切换语言
    public function change_default($id)
    {
        $websiteLanguage = WebsiteLanguage::get(['id' => $id]);
        if ($websiteLanguage['is_default'] == WebsiteLanguage::DEFAULT_ACTIVE) {
            $this->redirect('/Manage.html');
        }
        if ($websiteLanguage['is_avail'] != WebsiteLanguage::AVIAIL_ACTIVE || $websiteLanguage['status'] != WebsiteLanguage::STATUS_ACTIVE) {
            $this->error('异常操作！');
        }
        $defaultLanguage = WebsiteLanguage::get(['is_default' => WebsiteLanguage::DEFAULT_ACTIVE]);
        $defaultLanguage->is_default = 0;
        $defaultLanguage->save();

        $websiteLanguage->is_default = WebsiteLanguage::DEFAULT_ACTIVE;
        $websiteLanguage->save();

        $this->redirect('/Manage.html');
    }
}
