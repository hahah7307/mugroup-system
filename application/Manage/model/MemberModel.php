<?php

namespace app\Manage\model;

use think\Model;

class MemberModel extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 0;

    protected $name = 'member';

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

    public function memberRelation()
    {
        return $this->hasMany('MemberRelationModel', 'mid', 'id');
    }
}
