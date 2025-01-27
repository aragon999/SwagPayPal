<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\Checkout;

use Psr\Log\LoggerInterface;
use Shopware\Storefront\Page\Checkout\Confirm\CheckoutConfirmPageLoadedEvent;
use Swag\PayPal\Setting\Exception\PayPalSettingsInvalidException;
use Swag\PayPal\Setting\Service\SettingsServiceInterface;
use Swag\PayPal\Util\PaymentMethodUtil;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CheckoutSubscriber implements EventSubscriberInterface
{
    /**
     * @var SettingsServiceInterface
     */
    private $settingsService;

    /**
     * @var PaymentMethodUtil
     */
    private $paymentMethodUtil;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(SettingsServiceInterface $settingsService, PaymentMethodUtil $paymentMethodUtil, LoggerInterface $logger)
    {
        $this->settingsService = $settingsService;
        $this->paymentMethodUtil = $paymentMethodUtil;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckoutConfirmPageLoadedEvent::class => ['onConfirmPageLoaded', 1],
        ];
    }

    public function onConfirmPageLoaded(CheckoutConfirmPageLoadedEvent $event): void
    {
        try {
            $this->settingsService->getSettings($event->getSalesChannelContext()->getSalesChannel()->getId());
        } catch (PayPalSettingsInvalidException $e) {
            $this->logger->info('PayPal is removed from the available Payment Methods: {message}', ['message' => $e->getMessage()]);
            $this->removePayPalPaymentMethodFromConfirmPage($event);
        }
    }

    private function removePayPalPaymentMethodFromConfirmPage(CheckoutConfirmPageLoadedEvent $event): void
    {
        $paymentMethodCollection = $event->getPage()->getPaymentMethods();

        $payPalPaymentMethodId = $this->paymentMethodUtil->getPayPalPaymentMethodId($event->getContext());
        if ($payPalPaymentMethodId === null) {
            return;
        }

        $paymentMethodCollection->remove($payPalPaymentMethodId);
    }
}
