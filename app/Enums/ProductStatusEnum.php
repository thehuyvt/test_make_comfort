<?php
namespace App\Enums;

enum ProductStatusEnum: int
{
    case STOP_SELLING = 2;
    case ON_SALE = 1;
    case DRAFT = 0;

    public static function getArrayStatus()
    {
        return [
            self::ON_SALE->value => 'Mở bán',
            self::STOP_SELLING->value => 'Ngưng bán',
            self::DRAFT->value => 'Nháp',
        ];
    }

    public static function getNameStatus($key)
    {
        return self::getArrayStatus()[$key];
    }
}
