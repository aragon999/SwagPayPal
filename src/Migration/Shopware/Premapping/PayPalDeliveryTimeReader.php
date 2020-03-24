<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\Migration\Shopware\Premapping;

use Swag\PayPal\Migration\Shopware\DataSelection\PayPalDataSelection;
use SwagMigrationAssistant\Migration\MigrationContextInterface;
use SwagMigrationAssistant\Profile\Shopware\Premapping\DeliveryTimeReader;
use SwagMigrationAssistant\Profile\Shopware\ShopwareProfileInterface;

class PayPalDeliveryTimeReader extends DeliveryTimeReader
{
    public function supports(MigrationContextInterface $migrationContext, array $entityGroupNames): bool
    {
        return parent::supports($migrationContext, $entityGroupNames) || (
            $migrationContext->getProfile() instanceof ShopwareProfileInterface
            && \in_array(PayPalDataSelection::IDENTIFIER, $entityGroupNames, true)
        );
    }
}
