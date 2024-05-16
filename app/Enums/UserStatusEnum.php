<?php
namespace App\Enums;

enum UserStatusEnum: int
{
    case STOP_ACTIVE = 0;
    case ACTIVE = 1;

    public static function getArrayStatus()
    {
        return [
            'Hoạt động' => self::ACTIVE,
            'Dừng hoạt động' => self::STOP_ACTIVE,
        ];
    }

    public static function getNameStatus($value)
    {
        return array_search($value, [
            'Dừng hoạt động' => 0,
            'Hoạt động' => 1,

        ], true);
    }
}
