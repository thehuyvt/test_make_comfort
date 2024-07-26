<?php
namespace App\Enums;

enum UserRoleEnum: int
{
    case ADMIN = 1;
    case EMPLOYEE = 2;

    public static function getArrayGender()
    {
        return [
            self::ADMIN->value => 'Quản trị viên',
            self::EMPLOYEE->value => 'Nhân viên',
        ];
    }

    public static function getNameRole($key)
    {
        return self::getArrayGender()[$key];
    }
}
