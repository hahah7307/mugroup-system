<?php

namespace app\Manage\validate;

use app\Manage\model\MemberModel;
use think\Validate;
use think\Db;

class MemberValidate extends Validate
{
    protected $rule = [
        'company_name'              =>  'require',
        'slug'                      =>  'require|unique:Member',
        'status'                    =>  'require|number',
    ];

    protected $message = [
        'slug.unique'           =>  '分类标识已存在，请自行填写',
    ];

    protected $field = [
        'logo'                      =>  '企业Logo',
        'company_name'              =>  '企业名称',
        'company_property'          =>  '企业性质',
        'company_address'           =>  '企业地址',
        'legal_name'                =>  '法人代表',
        'legal_tel'                 =>  '法人手机',
        'legal_phone'               =>  '法人电话',
        'lxr_name'                  =>  '联系人姓名',
        'lxr_tel'                   =>  '联系人手机',
        'lxr_phone'                 =>  '联系人电话',
        'lxr_post'                  =>  '联系人职位',
        'site_url'                  =>  '网址',
        'email'                     =>  '邮箱',
        'fax'                       =>  '传真',
        'qq_wechat'                 =>  'QQ/微信',
        'company_profile'           =>  '企业简介',
        'products'                  =>  '主要产品',
        'certification'             =>  '通过认证',
        'slug'                      =>  '企业别名',
        'status'                    =>  '状态',
        'created_at'                =>  '创建时间',
    ];

    protected $scene = [
        'add'       =>  ['company_name', 'slug', 'status', 'created_at'],
        'edit'      =>  ['company_name', 'slug' => 'require|checkSlug', 'status'],
        'feature'   =>  ['feature'],
    ];

    protected function checkSlug($value, $rule, $data, $field, $name)
    {
        $member = MemberModel::where(['status' => MemberModel::STATUS_ACTIVE, 'slug' => $value])->select();
        switch (count($member)) {
            case 0:
                return true;
                break;
            case 1:
                if ($member[0]['id'] == input('id')) {
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
