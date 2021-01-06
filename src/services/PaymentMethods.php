<?php
/**
 * Utánvét Ellenőr plugin for Craft CMS 3.x
 *
 * Utánvét Ellenőr integration for Craft CMS
 *
 * @link      https://www.webmenedzser.hu
 * @copyright Copyright (c) 2020 dr. Ottó Radics
 */

namespace webmenedzser\craftutanvetellenor\services;

use webmenedzser\craftutanvetellenor\CraftUtanvetEllenor;

use Craft;
use craft\base\Component;
use craft\commerce\base\GatewayInterface;
use craft\commerce\Plugin as Commerce;
use craft\errors\ElementNotFoundException;

use Throwable;
use yii\base\Exception;

/**
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 */
class PaymentMethods extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @return GatewayInterface[]|null
     * @throws Throwable
     * @throws ElementNotFoundException
     * @throws Exception
     */
    public static function getAllCustomerEnabledGateways() : ?array
    {
        $availablePaymentMethods = Commerce::getInstance()->getGateways()->getAllCustomerEnabledGateways();

        if (!Craft::$app->request->isSiteRequest) {
            return $availablePaymentMethods;
        }

        $order = Commerce::getInstance()->getCarts()->getCart();
        $settings = CraftUtanvetEllenor::getInstance()->getSettings();
        $threshold = (float) Craft::parseEnv($settings->threshold);
        $paymentMethodsToHide = $settings->paymentMethodsToHide;
        $reputation = Connector::getReputation($order);

        /**
         * If reputation is below the threshold, filter payment methods.
         */
        if ($reputation < $threshold) {
            foreach ($availablePaymentMethods as $key => $value) {
                if (in_array($value->id, $paymentMethodsToHide)) {
                    unset($availablePaymentMethods[$key]);
                }
            }
        }

        return $availablePaymentMethods;
    }
}
