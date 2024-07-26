<?php
namespace App\Enums;

enum OrderPaymentMethodEnum: int
{
    case COD = 1; //Nhận hàng rồi thanh toán
//    case VN_PAY = 2;// Thanh toán online qua VnPay

    public static function getArrayPaymentMethod()
    {
        return [
//            self::VN_PAY->value => [
//                'name' => "VnPay",
//                'description' => "Ví điện tử VnPay",
//            ],
            self::COD->value => [
                'name' => "Cod",
                'description' => "Thanh toán khi nhận hàng",
            ],
        ];
    }

    public static function getNamePaymentMethod($value): string
    {
        if(!$value){
            return 'Không xác định';
        }

        return self::getArrayPaymentMethod()[$value]['name'];
    }
}
