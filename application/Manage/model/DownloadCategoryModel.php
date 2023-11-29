<?php

namespace app\Manage\model;

use think\Model;

class DownloadCategoryModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'download_category';

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

    static public function get_category()
    {
        return self::all(['status' => self::STATUS_ACTIVE])->toArray();
    }
}
