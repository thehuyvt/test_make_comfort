<?php
namespace App\Enums;

enum OrderStatusEnum: int
{
    case DRAFT = 1; //nháp -> đang trong giỏ hàng
    case ORDERING = 2;// tiến hành đặt đơn và thanh toán
    case PENDING = 3; //đơn hàng mới được đặt và đang chờ xác nhận
    case PROCESSING = 4; //đơn hàng đã được xác nhận và đang được chuẩn bị
    case ON_HOLD = 5; // đơn hàng tạm thời dừng lại do bị vấn đề về thông tin người gửi hoặc thiếu hàng
    case CANCELLED = 6; // đơn hàng đã bị hủy
    case SHIPPED = 7; //đơn hàng đã giao cho bên đơn vị vận chuyển

    public static function getArrayStatus()
    {
        return [
            'Giỏ hàng' => self::DRAFT,
            'Đang đặt' => self::ORDERING,
            'Chờ xác nhận' => self::PENDING,
            'Đang xử lý' => self::PROCESSING,
            'Tạm dừng' => self::ON_HOLD,
            'Đã hủy' => self::CANCELLED,
            'Đã giao ĐVVC' => self::SHIPPED,
        ];
    }

    public static function getNameStatus($value)
    {
        return array_search($value, [
            'Giỏ hàng' => 1,
            'Đang đặt' => 2,
            'Chờ xác nhận' => 3,
            'Đang xử lý' => 4,
            'Tạm dừng' => 5,
            'Đã hủy' => 6,
            'Đã giao ĐVVC' => 7,

        ], true);
    }
}
