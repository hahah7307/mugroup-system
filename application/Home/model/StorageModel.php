<?php

namespace app\Home\model;

use think\exception\DbException;
use think\Model;

class StorageModel extends Model
{
    const STATE_ACTIVE = 1;

    protected $name = 'storage';

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

    /**
     * @throws DbException
     */
    static public function get_storage()
    {
        return self::all(['state' => self::STATE_ACTIVE]);
    }
}
