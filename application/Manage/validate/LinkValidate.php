<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class LinkValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'link_name'             =>  'require',
        'link_url'              =>  'require',
        'type'                  =>  'require|number',
        'status'                =>  'require|number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'link_name'             =>  '链接名称',
        'link_url'              =>  '链接地址',
        'pictures'              =>  '链接图片',
        'type'                  =>  '分类',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['link_name', 'link_url', 'language_id', 'type', 'status'],
        'edit'      =>  ['link_name', 'link_url', 'language_id', 'type', 'status'],
    ];
}
