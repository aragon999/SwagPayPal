<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\Migration\Shopware\DataSelection;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Plugin\PluginService;
use SwagMigrationAssistant\Migration\DataSelection\DataSelectionStruct;
use SwagMigrationAssistant\Migration\MigrationContextInterface;
use SwagMigrationAssistant\Profile\Shopware\DataSelection\CustomerAndOrderDataSelection;
use SwagMigrationAssistant\Profile\Shopware\ShopwareProfileInterface;

class PayPalDataSelection extends CustomerAndOrderDataSelection
{
    public const IDENTIFIER = 'paypal';

    /**
     * @var PluginService
     */
    private $pluginService;

    public function __construct(
        PluginService $pluginService
    ) {
        $this->pluginService = $pluginService;
    }

    public function supports(MigrationContextInterface $migrationContext): bool
    {
        $migrationPlugin = $this->pluginService->getPluginByName('SwagMigrationAssistant', Context::createDefaultContext());

        return $migrationContext->getProfile() instanceof ShopwareProfileInterface
            && \version_compare($migrationPlugin->getVersion(), '1.1.0', '>=');
    }

    public function getData(): DataSelectionStruct
    {
        return new DataSelectionStruct(
            self::IDENTIFIER,
            $this->getEntityNames(),
            $this->getEntityNamesRequiredForCount(),
            'swag-paypal.migration.dataSelection',
            1000,
            false,
            DataSelectionStruct::PLUGIN_DATA_TYPE
        );
    }
}
