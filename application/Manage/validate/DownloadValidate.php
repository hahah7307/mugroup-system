<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class DownloadValidate extends Validate
{
    protected $rule = [
        'title'                 =>  'require',
        'suffix'                =>  'require',
        'cid'                   =>  'require|number',
        'url'                   =>  'require',
        'created_at'            =>  'require|number',
    ];

    protected $message = [
        
    ];

    protected $field = [
        'title'                 =>  '标题',
        'short'                 =>  '描述',
        'suffix'                =>  '文件类型',
        'cid'                   =>  '分类',
        'url'                   =>  '地址',
        'status'                =>  '状态',
        'created_at'            =>  '发布时间',
    ];

    protected $scene = [
        'add'       =>  ['title', 'suffix', 'cid', 'url', 'short'],
        'edit'      =>  ['title', 'suffix', 'cid', 'url', 'short'],
    ];
}
