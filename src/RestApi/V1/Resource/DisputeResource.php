<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\RestApi\V1\Resource;

use Swag\PayPal\RestApi\Client\PayPalClientFactoryInterface;
use Swag\PayPal\RestApi\V1\Api\Disputes;
use Swag\PayPal\RestApi\V1\Api\Disputes\Item as DisputeItem;
use Swag\PayPal\RestApi\V1\RequestUriV1;

class DisputeResource
{
    /**
     * @var PayPalClientFactoryInterface
     */
    private $payPalClientFactory;

    public function __construct(PayPalClientFactoryInterface $payPalClientFactory)
    {
        $this->payPalClientFactory = $payPalClientFactory;
    }

    public function list(string $salesChannelId): Disputes
    {
        $response = $this->payPalClientFactory->getPayPalClient($salesChannelId)->sendGetRequest(
            RequestUriV1::DISPUTES_RESOURCE
        );

        return (new Disputes())->assign($response);
    }

    public function get(string $disputeId, string $salesChannelId): DisputeItem
    {
        $response = $this->payPalClientFactory->getPayPalClient($salesChannelId)->sendGetRequest(
            \sprintf('%s/%s', RequestUriV1::DISPUTES_RESOURCE, $disputeId)
        );

        dump($response);

        return (new DisputeItem())->assign($response);
    }
}
