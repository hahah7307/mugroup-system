<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class AppTemplateValidate extends Validate
{
    protected $rule = [
        'title'         =>  'require',
        'mark'          =>  'require',
        'current'       =>  'require|number',
        'pic'           =>  'require',
        'status'        =>  'require|number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'title'         =>  '模板标识',
        'mark'          =>  '模板名称',
        'current'       =>  '是否默认',
        'pic'           =>  '预览图',
        'status'        =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['title', 'mark', 'current', 'pic', 'status'],
        'edit'      =>  ['title', 'mark', 'current', 'pic', 'status'],
    ];
}
