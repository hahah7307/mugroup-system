<?php

namespace app\Manage\model;

use think\Model;
use think\Session;

class ImageModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'image';

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
}
