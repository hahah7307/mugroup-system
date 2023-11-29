<?php

namespace app\Manage\model;

use think\Model;
use think\Session;

class WebsiteLanguage extends Model
{
    const STATUS_ACTIVE = 1;
    const DEFAULT_ACTIVE = 1;
    const AVIAIL_ACTIVE = 1;

    protected $name = 'website_language';

    protected $resultSetType = 'collection';

    protected $insert = ['created_at', 'updated_at'];

    protected $update = ['updated_at'];

    protected function setCreatedAtAttr()
    {
        return time();
    }

    protected function setUpdatedAtAttr()
    {
        return time();
    }

    // 获取当前默认语言
    static public function current_lang()
    {
        return self::get(['status' => self::STATUS_ACTIVE, 'is_default' => self::DEFAULT_ACTIVE, 'is_avail' => self::AVIAIL_ACTIVE]);
    }
}
