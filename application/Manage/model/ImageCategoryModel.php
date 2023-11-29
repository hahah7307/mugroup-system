<?php

namespace app\Manage\model;

use think\Model;
use think\Session;

class ImageCategoryModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'image_category';

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

    // 获取条件筛选后并排序的分类列表
    static public function category_list($where, $sort = 'asc')
    {
        $where_father = $where;
        $where_father['parent_id'] = 0;
        $category = new ImageCategoryModel();
        // 父级分类
        $category_father = $category->where($where_father)->order('sort asc, id ' . $sort)->select()->toArray();
        $list = array();
        foreach ($category_father as $k => $v) {
            $list[] = $v;
            $where_child = $where;
            $where_child['parent_id'] = $v['id'];
            // 子级分类
            $category_child = $category->where($where_child)->order('sort asc, id ' . $sort)->select()->toArray();
            foreach ($category_child as $ka => $va) {
                $va['name'] = '&nbsp;&nbsp;&nbsp;&nbsp;|---' . $va['name'];
                $list[] = $va;
            }
        }
        return $list;
    }

    // 获取一级分类
    static public function category_fa($where)
    {
        $where['parent_id'] = 0;
        $category = new ImageCategoryModel();

        return $category->where($where)->select()->toArray();
    }
}
