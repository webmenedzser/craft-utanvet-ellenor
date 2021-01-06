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

use craft\commerce\Plugin as Commerce;
use Craft;
use craft\base\Component;
use craft\commerce\elements\Order;

use webmenedzser\UVBConnector\UVBConnector;

/**
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 */
class Connector extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @param Order $order
     *
     * @return int
     */
    public static function getReputation(Order $order) : int
    {
        $email = $order->email ?? '';
        if (!$email) {
            return 1;
        }

        /**
         * Initialize UVB Connector
         */
        $settings = CraftUtanvetEllenor::$plugin->getSettings();
        $publicApiKey = Craft::parseEnv($settings->publicApiKey);
        $privateApiKey = Craft::parseEnv($settings->privateApiKey);
        $production = Craft::parseEnv($settings->production) ? true : false;
        $threshold = (float) Craft::parseEnv($settings->threshold);
        $paymentMethodsToHide = $settings->paymentMethodsToHide;

        /**
         * If there are no payment methods to be hidden, return instantly.
         */
        if (!count($paymentMethodsToHide)) {
            return 1;
        }

        /**
         * if no API keys are set, return;
         */
        if (!$publicApiKey || !$privateApiKey) {
            return 1;
        }

        $connector = new UVBConnector(
            $email,
            $publicApiKey,
            $privateApiKey,
            $production
        );

        $connector->threshold = $threshold;

        $reputation = json_decode($connector->get());
        if (!$reputation) {
            return 1;
        }

        return $reputation->message->totalRate;
    }

    /**
     * @param Int $orderId
     * @param Int $outcome
     */
    public static function postReputation(Int $orderId, Int $outcome) : void
    {
        $order = Commerce::getInstance()->getOrders()->getOrderById($orderId);

        $email = $order->email ?? null;
        if (!$email) {
            return;
        }

        /**
         * Initialize UVB Connector
         */
        $settings = CraftUtanvetEllenor::$plugin->getSettings();
        $publicApiKey = Craft::parseEnv($settings->publicApiKey);
        $privateApiKey = Craft::parseEnv($settings->privateApiKey);
        $production = Craft::parseEnv($settings->production) ? true : false;

        /**
         * If no API keys are set, return.
         */
        if (!$publicApiKey || !$privateApiKey) {
            return;
        }

        $connector = new UVBConnector(
            $email,
            $publicApiKey,
            $privateApiKey,
            $production
        );

        $connector->post($outcome);
    }
}
