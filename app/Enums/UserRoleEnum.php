<?php
namespace App\Enums;

enum UserRoleEnum: int
{
    case ADMIN = 1;
    case MANAGER = 2;
    case SHIPPER = 3;

    public static function getArrayGender()
    {
        return [
            self::ADMIN->value => 'Quản trị viên',
            self::MANAGER->value => 'Quản lý shop',
            self::SHIPPER->value => 'Nhân viên giao hàng',
        ];
    }

    public static function getNameRole($key)
    {
        return self::getArrayGender()[$key];
    }
}
