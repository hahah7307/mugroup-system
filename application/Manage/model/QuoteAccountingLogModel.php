<?php

namespace app\Manage\model;

use think\Model;

class QuoteAccountingLogModel extends Model
{
    protected $name = 'quote_accounting_log';

    protected $resultSetType = 'collection';

    public function user(): \think\model\relation\HasOne
    {
        return $this->hasOne('AccountModel', 'id', 'user_id');
    }
}
