<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class InfoCategoryValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'name'                  =>  'require',
        'code'                  =>  'require',
        'status'                =>  'number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'name'                  =>  '分类名称',
        'code'                  =>  '分类标识',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['name', 'language_id', 'code', 'status'],
        'edit'      =>  ['name', 'language_id', 'code', 'status'],
    ];
}
