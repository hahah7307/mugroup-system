<?php

namespace app\Manage\validate;

use app\Manage\model\ArticleModel;
use think\Validate;
use think\Db;

class ArticleValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'thumb'                 =>  'require',
        'cid'                   =>  'require|number',
        'title'                 =>  'require',
        'slug'                  =>  'require|unique:Article',
        'content'               =>  'require',
        'show_home'             =>  'require|number',            
        'status'                =>  'require|number',
        'created_at'            =>  'require',
    ];

    protected $message = [
        'slug.unique'           =>  '分类标识已存在，请自行填写',
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'cid'                   =>  '上级分类',
        'title'                 =>  '单页标题',
        'slug'                  =>  '文章标识',
        'url'                   =>  '外部链接',
        'summary'               =>  '概要',
        'thumb'                 =>  '缩略图',
        'author'                =>  '作者',
        'content'               =>  '内容',
        'view_num'              =>  '点击量',
        'seo_title'             =>  'seo标题',
        'seo_keyword'           =>  'seo关键词',
        'seo_description'       =>  'seo简述',
        'show_home'             =>  '是否首页显示',
        'status'                =>  '状态',
        'created_at'            =>  '发布时间',
    ];

    protected $scene = [
        'add'       =>  ['language_id', 'thumb', 'cid', 'title', 'slug', 'content', 'show_home', 'status', 'created_at'],
        'edit'      =>  ['language_id', 'thumb', 'cid', 'title', 'slug' => 'require|checkSlug', 'content', 'show_home', 'status'],
    ];

    protected function checkSlug($value, $rule, $data, $field, $name)
    {
        $category = ArticleModel::where(['language_id' => $data['language_id'], 'status' => ArticleModel::STATUS_ACTIVE, 'slug' => $value])->select();
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
