<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\Migration\Shopware\Converter;

use Shopware\Core\Checkout\Cart\Tax\TaxCalculator;
use Shopware\Core\Framework\Context;
use Swag\PayPal\Migration\Shopware\DataSelection\PayPalDataSelection;
use Swag\PayPal\SwagPayPal;
use Swag\PayPal\Util\PaymentMethodUtil;
use SwagMigrationAssistant\Migration\Converter\ConvertStruct;
use SwagMigrationAssistant\Migration\Logging\LoggingServiceInterface;
use SwagMigrationAssistant\Migration\Mapping\MappingServiceInterface;
use SwagMigrationAssistant\Migration\MigrationContextInterface;
use SwagMigrationAssistant\Profile\Shopware\Converter\OrderConverter;
use SwagMigrationAssistant\Profile\Shopware\Exception\AssociationEntityRequiredMissingException;

abstract class PayPalOrderConverter extends OrderConverter
{
    /**
     * @var OrderConverter
     */
    protected $orderConverter;

    /**
     * @var PaymentMethodUtil
     */
    private $paymentMethodUtil;

    public function __construct(
        MappingServiceInterface $mappingService,
        LoggingServiceInterface $loggingService,
        TaxCalculator $taxCalculator,
        PaymentMethodUtil $paymentMethodUtil
    ) {
        parent::__construct($mappingService, $loggingService, $taxCalculator);

        $this->paymentMethodUtil = $paymentMethodUtil;
    }

    /**
     * @throws AssociationEntityRequiredMissingException
     */
    public function convert(
        array $data,
        Context $context,
        MigrationContextInterface $migrationContext
    ): ConvertStruct {
        $paymentId = $data['temporaryID'];

        $convertStruct = parent::convert($data, $context, $migrationContext);

        $payPalMigrationSelected = false;
        $dataSelections = $migrationContext->getDataSelection();
        if ($data) {
            foreach ($dataSelections as $dataSelection) {
                if ($dataSelection['id'] === PayPalDataSelection::IDENTIFIER) {
                    $payPalMigrationSelected = true;
                }
            }
        }

        if ($paymentId && $payPalMigrationSelected) {
            $converted = $convertStruct->getConverted();
            if ($converted === null) {
                return $convertStruct;
            }
            $transaction = $converted['transactions'][0];
            $paymentMethodId = $transaction['paymentMethodId'];

            if ($paymentMethodId === $this->paymentMethodUtil->getPayPalPaymentMethodId($context)
                || $paymentMethodId === $this->paymentMethodUtil->getPayPalPuiPaymentMethodId($context)) {
                $transaction['customFields'] = [
                    SwagPayPal::ORDER_TRANSACTION_CUSTOM_FIELDS_PAYPAL_TRANSACTION_ID => $paymentId,
                ];

                $converted['transactions'][0] = $transaction;

                return new ConvertStruct($converted, $convertStruct->getUnmapped(), $convertStruct->getMappingUuid());
            }
        }

        return $convertStruct;
    }
}
