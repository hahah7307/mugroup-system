<?php

namespace app\Manage\model;

use think\Model;

class QuoteProductModel extends Model
{
    protected $name = 'quote_product';

    protected $resultSetType = 'collection';

    public function developer(): \think\model\relation\HasOne
    {
        return $this->hasOne('AccountModel', 'id', 'develop_id');
    }

    public function purchaser(): \think\model\relation\HasOne
    {
        return $this->hasOne('AccountModel', 'id', 'purchaser_id');
    }
}
