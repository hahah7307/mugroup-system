<?php
namespace app\Home\controller;
use app\Home\model\WebsiteLanguage;
use app\Home\model\WebsiteModel;
use app\Home\model\AppTemplate;
use app\Home\model\NavigationModel;
use app\Home\model\ProductCategoryModel;
use app\Home\model\LinkModel;
use app\Home\model\PageModel;
use think\Controller;
use think\Config;
use think\Session;
use think\Cookie;

class BaseController extends Controller
{
    public function _initialize()
    {
		parent::_initialize();

		// 模板
		$template = AppTemplate::get(['current' => AppTemplate::CURRENT_ACTIVE, 'status' => AppTemplate::STATUS_ACTIVE]);
		$this->template = $template['mark'];
		$this->view_name = $this->template . '/' . strtolower(request()->controller()) . '/' . request()->action();
    }
}
