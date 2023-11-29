<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class WebsiteLanguageValidate extends Validate
{
    protected $rule = [
        'name'              =>  'require',
        'show_name'         =>  'require',
        'abbreviation'      =>  'require',
        'is_default'        =>  'require|number',
        'is_avail'          =>  'require|number',
        'status'            =>  'require|number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'name'              =>  '语言名称',
        'show_name'         =>  '显示名称',
        'abbreviation'      =>  '语言标识',
        'google_tag'        =>  '谷歌标识',
        'icon'              =>  'icon',
        'is_default'        =>  '当前默认语言',
        'is_avail'          =>  '是否启用',
        'status'            =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['name', 'show_name', 'abbreviation', 'is_default', 'is_avail', 'status'],
        'edit'      =>  ['name', 'show_name', 'abbreviation', 'is_default', 'is_avail', 'status'],
    ];
}
