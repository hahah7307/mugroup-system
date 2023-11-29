<?php
namespace app\Manage\controller;

use app\Manage\model\InquiryModel;
use app\Manage\model\ProductModel;
use app\Manage\model\ArticleModel;
use app\Manage\model\MemberModel;
use app\Manage\model\NoticeModel;
use app\Manage\model\PageModel;
use think\Controller;
use think\Session;
use think\Config;

class IndexController extends BaseController
{
    public function index()
    {
        // 会员
        $member = MemberModel::all(['status' => MemberModel::STATUS_ACTIVE]);
        $this->assign('member', $member);

        // 公告
        $notice = NoticeModel::all(['language_id' => $this->language_id, 'status' => NoticeModel::STATUS_ACTIVE]);
        $this->assign('notice', $notice);

        // 文章
        $article = ArticleModel::all(['language_id' => $this->language_id, 'status' => ArticleModel::STATUS_ACTIVE]);
        $this->assign('article', $article);

        // 单页
        $page = PageModel::all(['language_id' => $this->language_id, 'status' => PageModel::STATUS_ACTIVE]);
        $this->assign('page', $page);

        // 文章列表
        $article_list = ArticleModel::where(['language_id' => $this->language_id, 'status' => ArticleModel::STATUS_ACTIVE])->order('view_num desc')->limit(9)->select();
        $this->assign('article_list', $article_list);

        return view();
    }

    public function initMenu()
    {
        if ($this->request->isPost()) {
            $info = $this->request->post('info');
            if ($info) {
                Session::set(Config::get('USER_MENU'), str_replace("\n", '', $info));

                echo json_encode(['code' => 1, 'msg' => "操作成功"]);
                exit;
            } else {
                echo json_encode(['code' => 0, 'msg' => "操作失败"]);
                exit;
            }
        } else {
            echo json_encode(['code' => 0, 'msg' => "异常操作"]);
            exit;
        }
    }
}
