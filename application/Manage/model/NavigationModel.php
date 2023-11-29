<?php

namespace app\Manage\model;

use think\Model;
use app\Manage\model\ProductCategoryModel;
use app\Manage\model\CasesCategoryModel;
use app\Manage\model\ArticleCategoryModel;
use app\Manage\model\PageModel;
use app\Manage\model\DownloadModel;

class NavigationModel extends Model
{
    const DROP_ACTIVE = 1;
    const TARGET_ACTIVE = 1;
    const TYPE_DEFAULT = 1;

    protected $name = 'navigation';

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

    // 无限递归+排序
    static public function parent_navi($language)
    {
        return self::list_sort([], $language, 0, 1);
    }

    protected function list_sort($list = [], $language, $pid = 0, $level = 1)
    {
        $category = self::where(['language_id' => $language, 'pid' => $pid])->order('sort asc')->select()->toArray();
        if ($category) {
            foreach ($category as $k => $v) {
                $v['level'] = $level;
                $v['navi_newname'] = str_repeat('&nbsp;', ($level -1) * 6 + 1) . "↳" . $v['nav_name'];
                $list[] = $v;
                $list = self::list_sort($list, $language, $v['id'], $level + 1);
            }
        }
        return $list;
    }
}
