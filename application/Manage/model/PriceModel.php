<?php

namespace app\Manage\model;

use think\Config;
use think\exception\DbException;
use think\Model;

class PriceModel extends Model
{
    const STATUS_ACTIVE = 1;

    protected $name = 'price';

    protected $resultSetType = 'collection';

    protected $insert = ['created_at', 'updated_at'];

    protected $update = ['updated_at'];

    protected function setCreatedAtAttr()
    {
        return date('Y-m-d H:i:s');
    }

    protected function setUpdatedAtAttr()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * @throws DbException
     */
    static public function generateProductAccounting($data)
    {
        $volumeSum = 0;
        $gross_weight_lbsSum = 0;
        $volume_lbsSum = 0;
        $loading_qtySum = 0;
        $lc_tail_end = 0;
        $le_tail_end = 0;
        $lc_warehouse_rent = 0;
        $le_warehouse_rent = 0;
        $lc_tail_label = [];
        $le_tail_label = [];
        foreach ($data['product'] as $item) {
            // 体积
            $volume = round($item['product_length'] * $item['product_width'] * $item['product_height'] / 1000000, 4);

            // 实重和体积重
            $gross_weight_lbs = ceil($item['gross_weight'] * Config::get('kg_pound'));
            $volume_lbs = ceil($item['product_length'] * $item['product_width'] * $item['product_height'] / Config::get('density_fraction'));

            // 装柜体积
            $loading_qty = round(Config::get('container_volume') / $volume, 2);

            // 尾程
            $w = max($gross_weight_lbs, $volume_lbs); // 计费重
            $lc_outbound = StorageRuleModel::w2outbound(1, $w);
            $lc_deliver_fee = DeliverFeeModel::w2deliverFee(1, $w);
            $lc_ahs_fee = AHS::AHSFeeLiang($gross_weight_lbs, $item['product_length'], $item['product_width'], $item['product_height']);
            $lc_tail_end += round(300 / $loading_qty + $lc_outbound + ($lc_deliver_fee + 4.43 + $lc_ahs_fee['basicFee'] + $lc_ahs_fee['additionalFee']) * 1.16 + 3, 2);

            $le_outbound = StorageRuleModel::w2outbound(2, $gross_weight_lbs);
            $le_deliver_fee = DeliverFeeModel::w2deliverFee(2, $w);
            $le_ahs_fee = AHS::AHSFeeLoctek($gross_weight_lbs, $item['product_length'], $item['product_width'], $item['product_height']);
            $le_tail_end += round(350 / $loading_qty + $le_outbound + ($le_deliver_fee + 2.9 + $le_ahs_fee['basicFee'] + $le_ahs_fee['additionalFee']) * 1.16 + 3, 2);

            // 仓储
            $lc_warehouse_rent += round(10 * 0.3 * $volume + 90 * 0.35 * $volume, 2);
            $le_warehouse_rent += round(30 * 0.25 * $volume + 60 * 0.3 * $volume, 2);

            //
            $lc_tail_label[] = "300 / " . $loading_qty . " + " . $lc_outbound . " + (" . $lc_deliver_fee . " + 4.43 + " . $lc_ahs_fee['basicFee'] . " + " . $lc_ahs_fee['additionalFee'] . ") * 1.16 + 3";
            $le_tail_label[] = "350 / " . $loading_qty . " + " . $le_outbound . " + (" . $le_deliver_fee . " + 2.9 + " . $le_ahs_fee['basicFee'] . " + " . $le_ahs_fee['additionalFee'] . ") * 1.16 + 3";

            $volumeSum += $volume;
            $gross_weight_lbsSum += $gross_weight_lbs;
            $volume_lbsSum += $volume_lbs;
            $loading_qtySum += $loading_qty;
        }

        // fob
        if (floatval($data['cost'])) {
            $fob = round($data['cost'] / $data['exchange_rate'], 2);
        } elseif (floatval($data['fob'])) {
            $fob = round($data['fob'], 2);
        } else {
            $fob = round($data['fob'], 2);
        }

        // 头程成本
        $initial_cost = round($data['flp_standard'] / $data['exchange_rate'] * $volumeSum, 2);

        // 头程成本占比
        $initial_cost_rate = round($initial_cost / $data['target_pricing'], 4);

        // 关税
        $tariff = round($fob * 0.7 * $data['tariff_rate'], 2);

        // 关税占比
        $tariff_proportion = round($tariff / $data['target_pricing'], 4);

        // 仓储占比
        $lc_storage_charge_proportion = round($lc_warehouse_rent / $data['target_pricing'], 4);
        $le_storage_charge_proportion = round($le_warehouse_rent / $data['target_pricing'], 4);

        // 尾程占比
        $lc_tail_end_proportion = round($lc_tail_end / $data['target_pricing'], 4);
        $le_tail_end_proportion = round($le_tail_end / $data['target_pricing'], 4);

        // 广告费
        $advertising_expenses = round($data['target_pricing'] * $data['ad_rate'], 4);

        // 退货费
        $return_fee = round($data['target_pricing'] * $data['return_rate'], 2);

        // 平台费
        $platform_fees = round($data['target_pricing'] * $data['platform_rate'], 2);

        // 零利润售价
        $lc_no_profit_price = round(($fob + $initial_cost + $tariff + $lc_warehouse_rent + $lc_tail_end) / (1 - $data['ad_rate'] - $data['return_rate'] - $data['platform_rate']), 2);
        $le_no_profit_price = round(($fob + $initial_cost + $tariff + $le_warehouse_rent + $le_tail_end) / (1 - $data['ad_rate'] - $data['return_rate'] - $data['platform_rate']), 2);

        // 最低售价利润
        $lc_min_selling_profit = round($data['min_price'] - $fob - $initial_cost - $tariff - $lc_warehouse_rent - $lc_tail_end - $data['min_price'] * 0.3, 2);
        $le_min_selling_profit = round($data['min_price'] - $fob - $initial_cost - $tariff - $le_warehouse_rent - $le_tail_end - $data['min_price'] * 0.3, 2);

        // 最低售价利润率
        $lc_min_selling_profit_rate = round($lc_min_selling_profit / $data['min_price'], 4);
        $le_min_selling_profit_rate = round($le_min_selling_profit / $data['min_price'], 4);

        // 目标定价利润
        $lc_target_pricing_profit = round($data['target_pricing'] - $fob - $initial_cost - $tariff - $lc_warehouse_rent - $lc_tail_end - $advertising_expenses - $return_fee - $platform_fees, 2);
        $le_target_pricing_profit = round($data['target_pricing'] - $fob - $initial_cost - $tariff - $le_warehouse_rent - $le_tail_end - $advertising_expenses - $return_fee - $platform_fees, 2);

        // 目标定价利润率
        $lc_target_pricing_profit_rate = round($lc_target_pricing_profit / $data['target_pricing'], 4);
        $le_target_pricing_profit_rate = round($le_target_pricing_profit / $data['target_pricing'], 4);

        // excel data
        $result['product'] = $data;
        $result['lc_tail_end_label'] = implode('；', $lc_tail_label);
        $result['le_tail_end_label'] = implode('；', $le_tail_label);
        $result['storage'][] = [
            'storage_name'  => '良仓',
            'data'          =>  [
                'volume'                        =>  $volumeSum,
                'gross_weight_lbs'              =>  $gross_weight_lbsSum,
                'volume_lbs'                    =>  $volume_lbsSum,
                'loading_qty'                   =>  $loading_qtySum,
                'fob'                           =>  $fob,
                'initial_cost'                  =>  $initial_cost,
                'initial_cost_rate'             =>  $initial_cost_rate,
                'tariff'                        =>  $tariff,
                'tariff_proportion'             =>  $tariff_proportion,
                'storage_charge'                =>  $lc_warehouse_rent,
                'storage_charge_proportion'     =>  $lc_storage_charge_proportion,
                'tail_end'                      =>  $lc_tail_end,
                'tail_end_proportion'           =>  $lc_tail_end_proportion,
                'advertising_expenses'          =>  $advertising_expenses,
                'return_fee'                    =>  $return_fee,
                'platform_fees'                 =>  $platform_fees,
                'no_profit_price'               =>  $lc_no_profit_price,
                'min_selling_profit'            =>  $lc_min_selling_profit,
                'min_selling_profit_rate'       =>  $lc_min_selling_profit_rate,
                'target_pricing_profit'         =>  $lc_target_pricing_profit,
                'target_pricing_profit_rate'    =>  $lc_target_pricing_profit_rate
            ]
        ];
        $result['storage'][] = [
            'storage_name'  =>  '乐歌',
            'data'          =>  [
                'volume'                        =>  $volumeSum,
                'gross_weight_lbs'              =>  $gross_weight_lbsSum,
                'volume_lbs'                    =>  $volume_lbsSum,
                'loading_qty'                   =>  $loading_qtySum,
                'fob'                           =>  $fob,
                'initial_cost'                  =>  $initial_cost,
                'initial_cost_rate'             =>  $initial_cost_rate,
                'tariff'                        =>  $tariff,
                'tariff_proportion'             =>  $tariff_proportion,
                'storage_charge'                =>  $le_warehouse_rent,
                'storage_charge_proportion'     =>  $le_storage_charge_proportion,
                'tail_end'                      =>  $le_tail_end,
                'tail_end_proportion'           =>  $le_tail_end_proportion,
                'advertising_expenses'          =>  $advertising_expenses,
                'return_fee'                    =>  $return_fee,
                'platform_fees'                 =>  $platform_fees,
                'no_profit_price'               =>  $le_no_profit_price,
                'min_selling_profit'            =>  $le_min_selling_profit,
                'min_selling_profit_rate'       =>  $le_min_selling_profit_rate,
                'target_pricing_profit'         =>  $le_target_pricing_profit,
                'target_pricing_profit_rate'    =>  $le_target_pricing_profit_rate
            ]
        ];

        return json_encode($result);
    }
}
