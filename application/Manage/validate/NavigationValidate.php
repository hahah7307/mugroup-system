<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class NavigationValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'pid'                   =>  'require|number',
        'type'                  =>  'require',
        'nav_name'              =>  'require',
        'nav_url'               =>  'require',
        'dropdown'              =>  'require|number',
        'new_target'            =>  'require|number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'type'                  =>  '导航类型',
        'pid'                   =>  '父级菜单',
        'nav_name'              =>  '导航名字',
        'nav_url'               =>  '导航地址',
        'dropdown'              =>  '下拉',
        'new_target'            =>  '新窗口',
    ];

    protected $scene = [
        'add'       =>  ['language_id', 'pid', 'type', 'nav_name', 'nav_url', 'dropdown','new_target'],
        'edit'      =>  ['language_id', 'pid', 'type', 'nav_name', 'nav_url', 'dropdown','new_target'],
    ];
}
