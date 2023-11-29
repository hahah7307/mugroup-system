<?php

namespace app\Manage\validate;

use app\Manage\model\MemberRankModel;
use think\Validate;
use think\Db;

class MemberRankValidate extends Validate
{
    protected $rule = [
        'name'                  =>  'require',
        'slug'                  =>  'require|unique:MemberRank',
        'status'                =>  'require|number',
    ];

    protected $message = [
        'slug.unique'           =>  '职位标识已存在，请自行填写',
    ];

    protected $field = [
        'name'                  =>  '职位名称',
        'slug'                  =>  '职位标识',
        'status'                =>  '状态',
    ];

    protected $scene = [
        'add'       =>  ['name', 'slug', 'status'],
        'edit'      =>  ['name', 'slug' => 'require|checkSlug', 'status'],
    ];

    protected function checkSlug($value, $rule, $data, $field, $name)
    {
        $category = MemberRankModel::where(['status' => MemberRankModel::STATUS_ACTIVE, 'slug' => $value])->select();
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
