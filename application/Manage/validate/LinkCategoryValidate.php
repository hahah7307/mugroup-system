<?php

namespace app\Manage\validate;

use app\Manage\model\LinkCategoryModel;
use think\Validate;
use think\Db;

class LinkCategoryValidate extends Validate
{
    protected $rule = [
        'language_id'           =>  'require|number',
        'parent_id'             =>  'require|number',
        'name'                  =>  'require',
        'slug'                  =>  'require|unique:LinkCategory',
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
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['name', 'parent_id', 'slug', 'language_id', 'status'],
        'edit'      =>  ['name', 'parent_id', 'slug' => 'require|checkSlug', 'language_id', 'status'],
    ];

    protected function checkSlug($value, $rule, $data, $field, $name)
    {
        $category = LinkCategoryModel::where(['language_id' => $data['language_id'], 'status' => LinkCategoryModel::STATUS_ACTIVE, 'slug' => $value])->select();
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
