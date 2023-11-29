<?php

namespace app\Manage\model;

use think\Model;

class NoticeModel extends Model
{
    const STATUS_ACTIVE = 1;
    
    protected $name = 'notice';

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

    public function category()
    {
        return $this->hasOne('NoticeCategoryModel', 'id', 'cid');
    }
}
