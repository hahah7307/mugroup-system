<?php

namespace app\Manage\validate;

use think\Validate;
use think\Db;

class WebsiteValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'logo'                  =>  'require',
        'web_title'             =>  'require',
        'email'                 =>  'email',
        'status'                =>  'require|number',
    ];

    protected $message = [
        'logo.require'          =>  '请上传公司Logo',
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'web_title'             =>  '网站名称',
        'seo_title'             =>  'SEO标题',
        'seo_keyword'           =>  'SEO关键词',
        'seo_description'       =>  'SEO描述',
        'logo'                  =>  'Logo',
        'ico'                   =>  'icon',
        'icp'                   =>  '网站备案号',
        'copyrights'            =>  '版权信息',
        'corporate_name'        =>  '公司名称',
        'email'                 =>  '邮箱',
        'telephone'             =>  '电话',
        'fax'                   =>  '传真',
        'address'               =>  '地址',
        'third_code_header'     =>  '统计代码',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['language_id', 'web_title', 'seo_title', 'seo_keyword', 'seo_description', 'logo', 'ico', 'icp', 'copyrights', 'corporate_name', 'email', 'telephone', 'fax', 'address', 'third_code_header', 'status'],
        'edit'      =>  ['language_id', 'web_title', 'seo_title', 'seo_keyword', 'seo_description', 'logo', 'ico', 'icp', 'copyrights', 'corporate_name', 'email', 'telephone', 'fax', 'address', 'third_code_header', 'status'],
    ];
}
