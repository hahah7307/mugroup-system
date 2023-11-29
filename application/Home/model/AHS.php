<?php

namespace app\Home\model;

use think\Model;
use think\Session;

class AHS extends Model
{
    const CM2INCHES = 2.54;

    const LBS = 50;

    static public function AHSDimension($a, $b, $c)
    {
        $arr = [$a, $b, $c];
        sort($arr);
        $length = array_reverse($arr);
        return $length[0] / self::CM2INCHES > 48 || $length[1] / self::CM2INCHES > 30 || ($length[0] + ($length[1] + $length[2]) * 2) / self::CM2INCHES > 105;
    }

    static public function AHSWeight($w)
    {
        return $w >= self::LBS;
    }

    static public function AHSFeeLiang($w, $a, $b, $c)
    {
        if (self::AHSWeight($w)) {
            $basicFee = 1.83;
            $additionalFee = 3.66;
        } elseif (self::AHSDimension($a, $b, $c)) {
            $basicFee = 1.83;
            $additionalFee = 2.55;
        } else {
            $basicFee = 0.9;
            $additionalFee = 0;
        }
        return ['basicFee' => $basicFee, 'additionalFee' => $additionalFee];
    }

    static public function AHSFeeLoctek($w, $a, $b, $c)
    {
        if (self::AHSWeight($w) && $w > 70) {
            $basicFee = 2.78;
            $additionalFee = 11.5;
        } elseif (self::AHSDimension($a, $b, $c)) {
            $basicFee = 2.78;
            $additionalFee = 8.5;
        } elseif (self::AHSWeight($w)) {
            $basicFee = 2.78;
            $additionalFee = 1.5;
        } else {
            $basicFee = 1.5;
            $additionalFee = 0;
        }
        return ['basicFee' => $basicFee, 'additionalFee' => $additionalFee];
    }
}
