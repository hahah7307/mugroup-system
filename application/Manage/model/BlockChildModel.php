<?php

namespace app\Manage\model;

use think\Model;
use think\Session;

class BlockChildModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'block_child';

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

    public function block()
    {
        return $this->hasOne('BlockModel', 'id', 'block_id');
    }
}
