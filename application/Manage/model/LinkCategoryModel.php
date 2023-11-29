<?php

namespace app\Manage\model;

use think\Model;

class LinkCategoryModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'link_category';

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

    static public function get_category($language)
    {
        return self::all(['language_id' => $language, 'status' => self::STATUS_ACTIVE])->toArray();
    }
}
