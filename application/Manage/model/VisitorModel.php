<?php

namespace app\Manage\model;

use think\Model;
use think\Session;

class VisitorModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'visitor';

    protected $resultSetType = 'collection';

    protected $insert = ['created_at', 'updated_at'];

    protected $update = ['updated_at'];

    protected function setCreatedByAttr()
    {
        return Session::get('USER_LOGIN_FLAG','backend');
    }

    protected function setCreatedAtAttr()
    {
        return time();
    }

    protected function setUpdatedByAttr()
    {
        return Session::get('USER_LOGIN_FLAG','backend');
    }

    protected function setUpdatedAtAttr()
    {
        return time();
    }
}
