<?php
/**
 * Utánvét Ellenőr plugin for Craft CMS 3.x
 *
 * Utánvét Ellenőr integration for Craft CMS
 *
 * @link      https://www.webmenedzser.hu
 * @copyright Copyright (c) 2020 dr. Ottó Radics
 */

namespace webmenedzser\craftutanvetellenor;

use webmenedzser\craftutanvetellenor\jobs\SendSignalToUvbJob;
use webmenedzser\craftutanvetellenor\models\Settings;
use webmenedzser\craftutanvetellenor\services\Connector;
use webmenedzser\craftutanvetellenor\variables\UtanvetEllenorVariable;

use Craft;
use craft\base\Plugin;
use craft\commerce\events\OrderStatusEvent;
use craft\commerce\services\Gateways;
use craft\commerce\services\OrderHistories;
use craft\events\PluginEvent;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Plugins;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * Class CraftUtanvetEllenor
 *
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 *
 */
class CraftUtanvetEllenor extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var CraftUtanvetEllenor
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = true;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            OrderHistories::class,
            OrderHistories::EVENT_ORDER_STATUS_CHANGE,
            function (OrderStatusEvent $event) {
                $outcome = 0;
                $orderHistory = $event->orderHistory;
                $successfulDeliveryOrderState = (int) $this->getSettings()->successfulDeliveryOrderState;
                $refusedDeliveryOrderState = (int) $this->getSettings()->refusedDeliveryOrderState;

                /**
                 * If the new order status ID is none of them, return;
                 */
                if (!in_array($orderHistory->newStatusId, [$successfulDeliveryOrderState, $refusedDeliveryOrderState])) {
                    return;
                }

                if ($orderHistory->newStatusId === $successfulDeliveryOrderState) {
                    $outcome = 1;
                }

                if ($orderHistory->newStatusId === $refusedDeliveryOrderState) {
                    $outcome = -1;
                }

                Craft::$app->queue->push(new SendSignalToUvbJob([
                    'orderId' => $event->order->id,
                    'outcome' => $outcome
                ]));
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $e) {
                /** @var CraftVariable $variable */
                $variable = $e->sender;

                // Attach a service:
                $variable->set('utanvetellenor', UtanvetEllenorVariable::class);
            }
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'craft-utanvet-ellenor/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
