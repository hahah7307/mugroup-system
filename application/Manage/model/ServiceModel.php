<?php

namespace app\Manage\model;

use think\Model;
use think\Session;

class ServiceModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'service';

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

    static public function get_service_type()
    {
        $type_arr = [
            1   =>  'QQ',
            2   =>  'Skype',
            3   =>  'Email',
            4   =>  'Phone',
            5   =>  'Wechat',
            6   =>  'WhatsApp',
        ];
        return $type_arr;
    }
}
