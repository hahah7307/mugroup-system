<?php

namespace app\Manage\model;

use think\Model;

class QuoteTableModel extends Model
{
    protected $name = 'quote_table';

    protected $resultSetType = 'collection';

    public function user(): \think\model\relation\HasOne
    {
        return $this->hasOne('AccountModel', 'id', 'user_id');
    }
}
