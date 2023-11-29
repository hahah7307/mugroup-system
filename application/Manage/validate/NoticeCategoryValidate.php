<?php

namespace app\Manage\validate;

use app\Manage\model\NoticeCategoryModel;
use think\Validate;
use think\Db;

class NoticeCategoryValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'parent_id'             =>  'require|number',
        'name'                  =>  'require',
        'slug'                  =>  'require|unique:NoticeCategory',
        'status'                =>  'require|number',
    ];

    protected $message = [
        'slug.unique'           =>  '分类标识已存在，请自行填写',
    ];

    protected $field = [
        'language_id'           =>  '当前默认语言',
        'parent_id'             =>  '父级分类',
        'name'                  =>  '分类名称',
        'slug'                  =>  '分类标识',
        'seo_title'             =>  'seo标题',
        'seo_keyword'           =>  'seo关键词',
        'seo_description'       =>  'seo描述',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['name', 'parent_id', 'slug', 'language_id', 'seo_title', 'seo_keyword', 'seo_description', 'status'],
        'edit'      =>  ['name', 'parent_id', 'slug' => 'require|checkSlug', 'language_id', 'seo_title', 'seo_keyword', 'seo_description', 'status'],
    ];

    protected function checkSlug($value, $rule, $data, $field, $name)
    {
        $category = NoticeCategoryModel::where(['language_id' => $data['language_id'], 'status' => NoticeCategoryModel::STATUS_ACTIVE, 'slug' => $value])->select();
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
