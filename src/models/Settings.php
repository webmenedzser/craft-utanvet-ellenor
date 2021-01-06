<?php
/**
 * Utánvét Ellenőr plugin for Craft CMS 3.x
 *
 * Utánvét Ellenőr integration for Craft CMS
 *
 * @link      https://www.webmenedzser.hu
 * @copyright Copyright (c) 2020 dr. Ottó Radics
 */

namespace webmenedzser\craftutanvetellenor\models;

use webmenedzser\craftutanvetellenor\CraftUtanvetEllenor;

use Craft;
use craft\base\Model;
use craft\validators\ArrayValidator;

/**
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var bool
     */
    public $production = false;

    /**
     * @var string
     */
    public $publicApiKey = '';

    /**
     * @var string
     */
    public $privateApiKey = '';

    /**
     * @var string
     */
    public $threshold = '0';

    /**
     * @var int
     */
    public $successfulDeliveryOrderState;

    /**
     * @var int
     */
    public $refusedDeliveryOrderState;

    /**
     * @var array
     */
    public $paymentMethodsToHide = [];

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'publicApiKey',
                    'privateApiKey',
                    'successfulDeliveryOrderState',
                    'refusedDeliveryOrderState',
                    'threshold'
                ],
                'required'
            ],
        ];
    }
}
