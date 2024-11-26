<?php

namespace app\Manage\model;

use think\Model;

class QuoteProductModel extends Model
{
    protected $name = 'quote_product';

    protected $resultSetType = 'collection';

    public function developer()
    {
        return $this->hasOne('AccountModel', 'id', 'develop_id');
    }
}
