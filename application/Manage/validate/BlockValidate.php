<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class BlockValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'title'                 =>  'require',
        'block_code'            =>  'require|alphaDash',
        'index_code'            =>  'require|alphaDash',
        'number'                =>  'require|number',
        'status'                =>  'number',
        'type'                  =>  'require|number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'title'                 =>  '广告位名称',
        'block_code'            =>  '模块标识',
        'index_code'            =>  '前台标识',
        'number'                =>  '展示条目数',
        'content'               =>  '内容',
        'status'                =>  '状态',
        'type'                  =>  '类型',
    ];

    protected $scene = [
        'add'       =>  ['title', 'language_id', 'block_code', 'index_code', 'number', 'content', 'status', 'type'],
        'edit'      =>  ['title', 'language_id', 'block_code', 'index_code', 'number', 'content', 'status', 'type'],
    ];
}
