<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\Test\Pos\Mock\Client;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Swag\PayPal\Pos\Api\Service\ApiKeyDecoder;
use Swag\PayPal\Pos\Client\TokenClient;
use Swag\PayPal\Pos\Client\TokenClientFactory;

class TokenClientFactoryMock extends TokenClientFactory
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ApiKeyDecoder
     */
    private $apiKeyDecoder;

    public function __construct()
    {
        $this->logger = new NullLogger();
        $this->apiKeyDecoder = new ApiKeyDecoder();
        parent::__construct($this->logger, $this->apiKeyDecoder);
    }

    public function createTokenClient(): TokenClient
    {
        return new TokenClientMock($this->logger, $this->apiKeyDecoder);
    }
}