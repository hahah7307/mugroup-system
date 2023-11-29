<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class ImageCategoryValidate extends Validate
{
    protected $rule = [
        'parent_id'             =>  'require',
        'language_id'           =>  'require|number',
        'name'                  =>  'require',
        'code'                  =>  'require',
        'status'                =>  'number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'parent_id'             =>  '上级分类',
        'language_id'           =>  '当前默认语言',
        'name'                  =>  '分类名称',
        'code'                  =>  '分类标识',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['parent_id', 'language_id', 'name', 'code', 'status'],
        'edit'      =>  ['parent_id', 'language_id', 'name', 'code', 'status'],
    ];
}
