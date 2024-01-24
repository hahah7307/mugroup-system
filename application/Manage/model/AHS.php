<?php

namespace app\Manage\model;

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
        return $length[0] > floor(48 * self::CM2INCHES) || $length[1] > floor(30 * self::CM2INCHES) || ($length[0] + ($length[1] + $length[2]) * 2) > floor(105 * self::CM2INCHES);
    }

    static public function AHSWeight($w)
    {
        return $w >= self::LBS;
    }

    static public function AHSFeeLiang($w, $a, $b, $c)
    {
        if (self::AHSWeight($w)) {
            $basicFee = 0.8;
            $additionalFee = 4.43;
        } elseif (self::AHSDimension($a, $b, $c)) {
            $basicFee = 0.8;
            $additionalFee = 3.06;
        } else {
            $basicFee = 0;
            $additionalFee = 0;
        }
        return ['basicFee' => $basicFee, 'additionalFee' => $additionalFee];
    }

    static public function AHSFeeLoctek($w, $a, $b, $c)
    {
        if (self::AHSWeight($w) && $w > 70) {
            $basicFee = 1;
            $additionalFee = 11.5;
        } elseif (self::AHSDimension($a, $b, $c)) {
            $basicFee = 1;
            $additionalFee = 8.5;
        } elseif (self::AHSWeight($w)) {
            $basicFee = 1;
            $additionalFee = 9.7;
        } else {
            $basicFee = 0;
            $additionalFee = 0;
        }
        return ['basicFee' => $basicFee, 'additionalFee' => $additionalFee];
    }
}
