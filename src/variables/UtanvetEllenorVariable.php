<?php
/**
 * Utánvét Ellenőr plugin for Craft CMS 3.x
 *
 * Utánvét Ellenőr integration for Craft CMS
 *
 * @link      https://www.webmenedzser.hu
 * @copyright Copyright (c) 2020 dr. Ottó Radics
 */

namespace webmenedzser\craftutanvetellenor\variables;

use webmenedzser\craftutanvetellenor\services\PaymentMethods;

use craft\base\Component;
use craft\errors\ElementNotFoundException;

use Throwable;
use yii\base\Exception;

/**
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 */
class UtanvetEllenorVariable extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * @return array|null
     * @throws Throwable
     * @throws ElementNotFoundException
     * @throws Exception
     */
    public static function getAllCustomerEnabledGateways() : ?array
    {
        return PaymentMethods::getAllCustomerEnabledGateways();
    }
}
