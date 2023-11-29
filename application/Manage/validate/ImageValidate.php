<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class ImageValidate extends Validate
{
    protected $rule = [
        'cid'                   =>  'require',
        'language_id'           =>  'require|number',
        'title'                 =>  'require',
        'url'                   =>  'require',
        'status'                =>  'number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'cid'                   =>  '分类',
        'language_id'           =>  '当前默认语言',
        'title'                 =>  '图片名称',
        'short'                 =>  '备注',
        'url'                   =>  '图片路径',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['cid', 'language_id', 'title', 'url', 'status'],
        'edit'      =>  ['cid', 'title'],
    ];
}
