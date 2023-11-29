<?php

namespace app\Manage\model;

use think\Model;

class MemberRelationModel extends Model
{
    protected $name = 'member_relation';

    protected $resultSetType = 'collection';

    public function category()
    {
        return $this->hasOne('MemberRankModel', 'id', 'rid');
    }

    public function member()
    {
        return $this->hasOne('MemberModel', 'id', 'mid');
    }
}
