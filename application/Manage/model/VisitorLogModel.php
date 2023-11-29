<?php

namespace app\Manage\model;

use think\Db;
use think\Model;
use think\Session;

class VisitorLogModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'visitor_log';

    protected $resultSetType = 'collection';

    protected $insert = ['created_at', 'updated_at'];

    protected $update = ['updated_at'];

    protected function setCreatedByAttr()
    {
        return Session::get('USER_LOGIN_FLAG','backend');
    }

    protected function setCreatedAtAttr()
    {
        return time();
    }

    protected function setUpdatedByAttr()
    {
        return Session::get('USER_LOGIN_FLAG','backend');
    }

    protected function setUpdatedAtAttr()
    {
        return time();
    }

    // 获取国家统计
    public function get_country_log($start_time, $end_time)
    {
        $sql = "SELECT country, count(country) as csum FROM (SELECT * FROM `" . config('database.prefix') . $this->name . "` WHERE `created_at` >= ". strtotime($start_time) ." AND `created_at` <". strtotime('+1 day', strtotime($end_time)) .") as visitor_log GROUP BY country ORDER BY csum DESC LIMIT 9;";
        $query = Db::query($sql);

        return $query;
    }

    // 获取来源网址
    public function get_source_web($start_time, $end_time)
    {
        $sql = "SELECT `referrer`, count(referrer) as rsum FROM (SELECT * FROM `cms_visitor_log` WHERE `created_at` >= ". strtotime($start_time) ." AND `created_at` <". strtotime('+1 day', strtotime($end_time)) .") as visitor_log GROUP BY referrer ORDER BY rsum DESC LIMIT 9;";
        $query = Db::query($sql);

        return $query;
    }

    // 获取浏览器分布
    public function get_source_browser($start_time, $end_time)
    {
        $sql = "SELECT `user_agent`, count(user_agent) as asum FROM (SELECT * FROM `cms_visitor_log` WHERE `created_at` >= ". strtotime($start_time) ." AND `created_at` <". strtotime('+1 day', strtotime($end_time)) .") as visitor_log GROUP BY user_agent ORDER BY asum DESC;";
        $query = Db::query($sql);

        return $query;
    }
}
