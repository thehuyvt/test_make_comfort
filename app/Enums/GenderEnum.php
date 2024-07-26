<?php
namespace App\Enums;

enum GenderEnum: int
{
    case MALE = 1;
    case FE_MALE = 0;

    public static function getArrayGender()
    {
        return [
            self::MALE->value => 'Nam',
            self::FE_MALE->value => 'Nữ',
        ];
    }

    public static function getNameGender($key)
    {
        return self::getArrayGender()[$key];
    }
}
