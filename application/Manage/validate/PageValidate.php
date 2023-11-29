<?php

namespace app\Manage\validate;

use app\Manage\model\PageModel;
use think\Validate;
use think\Db;

class PageValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'cid'                   =>  'require|number',
        'title'                 =>  'require',
        'slug'                  =>  'require|unique:Page',
        'content'               =>  'require',
        'template_file'         =>  'require',              
        'status'                =>  'require|number',
    ];

    protected $message = [
        'slug.unique'           =>  '分类标识已存在，请自行填写',
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'cid'                   =>  '上级分类',
        'title'                 =>  '单页标题',
        'slug'                  =>  '单页标识',
        'url'                   =>  '外部链接',
        'brief'                 =>  '概要',
        'content'               =>  '内容',
        'seo_title'             =>  'seo标题',
        'seo_keyword'           =>  'seo关键词',
        'seo_description'       =>  'seo简述',
        'template_file'         =>  '模板文件',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['language_id', 'cid', 'title', 'slug', 'url', 'brief', 'content', 'seo_title', 'seo_keyword', 'seo_description', 'template_file', 'status'],
        'edit'      =>  ['language_id', 'cid', 'title', 'slug' => 'require|checkSlug', 'url', 'brief', 'content', 'seo_title', 'seo_keyword', 'seo_description', 'template_file', 'status'],
    ];

    protected function checkSlug($value, $rule, $data, $field, $name)
    {
        $category = PageModel::where(['language_id' => $data['language_id'], 'status' => PageModel::STATUS_ACTIVE, 'slug' => $value])->select();
        switch (count($category)) {
            case 0:
                return true;
                break;
            case 1:
                if ($category[0]['id'] == input('id')) {
                    return true;
                } else {
                    return $name . '已存在';
                }
                break;
            default:
                return $name . '已存在';
                break;
        }
    }
}
