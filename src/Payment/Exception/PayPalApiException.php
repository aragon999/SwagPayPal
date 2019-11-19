<?php declare(strict_types=1);

namespace Swag\PayPal\Payment\Exception;

use Shopware\Core\Framework\ShopwareHttpException;

class PayPalApiException extends ShopwareHttpException
{
    public function __construct(string $name, string $message)
    {
        parent::__construct(
            'The error "{{ name }}" with the following message: {{ message }}',
            ['name' => $name, 'message' => $message]
        );
    }

    public function getErrorCode(): string
    {
        return 'SWAG_PAYPAL__API_EXCEPTION';
    }
}