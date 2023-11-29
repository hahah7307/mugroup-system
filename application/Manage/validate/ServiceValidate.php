<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class ServiceValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'name'                  =>  'require',
        'type'                  =>  'require|number',
        'status'                =>  'number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'name'                  =>  '客服名称',
        'type'                  =>  '客服类型',
        'account'               =>  '客服账号',
        'image'                 =>  '客服头像',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['name', 'type', 'language_id', 'account', 'image', 'status'],
        'edit'      =>  ['name', 'type', 'language_id', 'account', 'image', 'status'],
    ];
}
