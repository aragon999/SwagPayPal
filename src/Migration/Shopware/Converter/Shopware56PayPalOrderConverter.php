<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\Migration\Shopware\Converter;

use Shopware\Core\Checkout\Cart\Tax\TaxCalculator;
use Swag\PayPal\Util\PaymentMethodUtil;
use SwagMigrationAssistant\Migration\Logging\LoggingServiceInterface;
use SwagMigrationAssistant\Migration\Mapping\MappingServiceInterface;
use SwagMigrationAssistant\Migration\MigrationContextInterface;
use SwagMigrationAssistant\Profile\Shopware\Converter\OrderConverter;

class Shopware56PayPalOrderConverter extends PayPalOrderConverter
{
    public function __construct(
        MappingServiceInterface $mappingService,
        LoggingServiceInterface $loggingService,
        TaxCalculator $taxCalculator,
        PaymentMethodUtil $paymentMethodUtil,
        OrderConverter $orderConverter
    ) {
        parent::__construct($mappingService, $loggingService, $taxCalculator, $paymentMethodUtil);
        $this->orderConverter = $orderConverter;
    }

    public function supports(MigrationContextInterface $migrationContext): bool
    {
        return $this->orderConverter->supports($migrationContext);
    }
}
