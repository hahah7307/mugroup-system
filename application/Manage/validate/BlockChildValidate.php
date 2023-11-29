<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class BlockChildValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'block_id'              =>  'require|number',
        'title'                 =>  'require',
        'link'                  =>  'require|number',
        'pictures'              =>  'require',
        'status'                =>  'number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'block_id'              =>  '广告位ID',
        'title'                 =>  '广告名称',
        'url'                   =>  '链接地址',
        'link'                  =>  '链接方式',
        'pictures'              =>  '图片',
        'content'               =>  '内容',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['block_id', 'title', 'language_id', 'url', 'link', 'pictures', 'content', 'status'],
        'edit'      =>  ['block_id', 'title', 'language_id', 'url', 'link', 'pictures', 'content', 'status'],
    ];
}
