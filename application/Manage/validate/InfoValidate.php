<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class InfoValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'cid'                   =>  'require',
        'title'                 =>  'require',
        'pic'                   =>  'require',
        'content'               =>  'require',
        'status'                =>  'number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'cid'                   =>  '详情分类',
        'title'                 =>  '详情名称',
        'pic'                   =>  '预览图',
        'content'               =>  '内容',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['title', 'cid', 'language_id', 'pic', 'content', 'status'],
        'edit'      =>  ['title', 'cid', 'language_id', 'pic', 'content', 'status'],
    ];
}
