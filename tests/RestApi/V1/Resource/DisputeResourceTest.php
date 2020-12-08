<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\Test\RestApi\V1\Resource;

use PHPUnit\Framework\TestCase;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Test\TestCaseBase\KernelTestBehaviour;
use Swag\PayPal\RestApi\Client\PayPalClientFactory;
use Swag\PayPal\RestApi\V1\Resource\DisputeResource;

class DisputeResourceTest extends TestCase
{
    use KernelTestBehaviour;

//    public function testList(): void
//    {
//        $clientFactory = $this->getContainer()->get(PayPalClientFactory::class);
//        $resource = new DisputeResource($clientFactory);
//
//        $result = $resource->list(Defaults::SALES_CHANNEL);
//
//        $dispute = $resource->get($result->getItems()[0]->getDisputeId(), Defaults::SALES_CHANNEL);
//        echo 'DisputeResourceTest.php Zeile: 22';
//        dd($dispute);
//    }
}
