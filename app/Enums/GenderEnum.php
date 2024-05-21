<?php
namespace App\Enums;

enum GenderEnum: int
{
    case MALE = 1;
    case FE_MALE = 0;

    public static function getArrayGender()
    {
        return [
            'Nam' => self::MALE,
            'Nữ' => self::FE_MALE,
        ];
    }

    public static function getNameGender($value)
    {
        return array_search($value, [
            'Nữ' => 0,
            'Nam' => 1,
        ], true);
    }
}
