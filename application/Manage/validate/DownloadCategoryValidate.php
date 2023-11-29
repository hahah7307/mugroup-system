<?php

namespace app\Manage\validate;

use app\Manage\model\DownloadCategoryModel;
use think\Validate;
use think\Db;

class DownloadCategoryValidate extends Validate
{
    protected $rule = [
        'name'                  =>  'require',
        'slug'                  =>  'require|unique:DownloadCategory',
        'status'                =>  'require|number',
    ];

    protected $message = [
        'slug.unique'           =>  '分类标识已存在，请自行填写',
    ];

    protected $field = [
        'name'                  =>  '分类名称',
        'slug'                  =>  '分类标识',
        'seo_title'             =>  'seo标题',
        'seo_keyword'           =>  'seo关键词',
        'seo_description'       =>  'seo描述',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['name', 'slug', 'status'],
        'edit'      =>  ['name', 'slug' => 'require|checkSlug', 'status'],
    ];

    protected function checkSlug($value, $rule, $data, $field, $name)
    {
        $category = DownloadCategoryModel::where(['status' => DownloadCategoryModel::STATUS_ACTIVE, 'slug' => $value])->select();
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
