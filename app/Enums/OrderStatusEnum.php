<?php
namespace App\Enums;

enum OrderStatusEnum: int
{
    case DRAFT = 1; //nháp -> đang trong giỏ hàng
    case ORDERING = 2;// tiến hành đặt đơn và thanh toán
    case PENDING = 3; //đơn hàng mới được đặt và đang chờ xác nhận
    case PROCESSED = 4; //đơn hàng đã được xác nhận và đang được chuẩn bị
    case REJECT = 5; // đơn hàng tạm thời dừng lại do bị vấn đề về thông tin người gửi hoặc thiếu hàng
    case CANCELLED = 6; // đơn hàng đã bị hủy
//    case SHIPPED = 7; //đơn hàng đã giao cho bên đơn vị vận chuyển
//    case COMPLETED = 8; //đơn hàng đã giao cho bên đơn vị vận chuyển

    public static function getArrayStatus()
    {
        return [
            self::DRAFT->value => "Giỏ hàng",
            self::ORDERING->value => "Đang thanh toán",
            self::PENDING->value => "Chờ xử lý",
            self::PROCESSED->value => "Đã xử lý",
            self::REJECT->value => "Đã từ chối",
            self::CANCELLED->value => "Đã hủy",
//            self::SHIPPED->value => "Đang vận chuyển",
//            self::COMPLETED->value => "Hoàn thành",
        ];
    }

    public static function getNameStatus($value)
    {
        return self::getArrayStatus()[$value];
    }
}
