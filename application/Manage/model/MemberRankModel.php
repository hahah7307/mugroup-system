<?php

namespace app\Manage\model;

use think\Model;

class MemberRankModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'member_rank';

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

    public function relations()
    {
        return $this->hasMany('MemberRelationModel', 'rid', 'id');
    }

    static public function get_category()
    {
        return self::all(['status' => self::STATUS_ACTIVE])->toArray();
    }
}
