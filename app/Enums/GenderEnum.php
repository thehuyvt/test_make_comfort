<?php
namespace App\Enums;

enum GenderEnum: int
{
    case MALE = 1;
    case FE_MALE = 0;

    public static function getArrayGender()
    {
        return [
            self::MALE->value => 'Male',
            self::FE_MALE->value => 'Female',

        ];
    }

    public static function getNameGender($key)
    {
        return self::getArrayGender()[$key];
    }
}
