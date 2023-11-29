<?php

namespace app\Manage\model;

use think\Model;

class BlockModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'block';

    protected $resultSetType = 'collection';

    protected $insert = ['created_at', 'updated_at'];

    protected $update = ['updated_at'];

    protected function setCreatedAtAttr()
    {
        return time();
    }

    protected function setUpdatedAtAttr()
    {
        return time();
    }

    static public function get_block_index()
    {
        return [
            'index'     =>  ['title' =>  '首页'],
            'product'   =>  ['title' =>  '产品'],
            'case'      =>  ['title' =>  '案例'],
            'news'      =>  ['title' =>  '新闻'],
            'inquiry'   =>  ['title' =>  '询盘'],
            'page'      =>  ['title' =>  '单页'],
            'member'    =>  ['title' =>  '会员']
        ];
    }

    static public function get_type()
    {
        return [
            1   =>  '图文',
            2   =>  '文章',
            3   =>  '单页面广告图文'
        ];
    }

    static public function get_block($language_id)
    {
        return self::all(['language_id' => $language_id, 'status' => self::STATUS_ACTIVE])->toArray();
    }

    static public function get_group_block($language_id)
    {
        $res = array();
        foreach (self::get_block_index() as $key => $value) {
            $res[$key] = self::all(['language_id' => $language_id, 'status' => self::STATUS_ACTIVE, 'block_code' => $key])->toArray();
        }
        return $res;
    }
}
