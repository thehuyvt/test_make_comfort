<?php
namespace App\Enums;

enum ProductStatusEnum: int
{
    case STOP_SELLING = 2;
    case ON_SALE = 1;

    public static function getArrayStatus()
    {
        return [
            'Mở bán' => self::ON_SALE,
            'Ngưng bán' => self::STOP_SELLING,
        ];
    }

    public static function getNameStatus($value)
    {
        return array_search($value, [
            'Ngưng bán' => 2,
            'Mở bán' => 1,

        ], true);
    }
}
