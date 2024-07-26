<?php
namespace App\Enums;

enum UserStatusEnum: int
{
    case STOP_ACTIVE = 0;
    case ACTIVE = 1;

    public static function getArrayStatus()
    {
        return [
            self::ACTIVE->value => 'Hoạt động',
            self::STOP_ACTIVE->value => 'Dừng hoạt động',
        ];
    }

    public static function getNameStatus($value)
    {
        return self::getArrayStatus()[$value];
    }
}
