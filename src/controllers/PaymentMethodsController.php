<?php
/**
 * Utánvét Ellenőr plugin for Craft CMS 3.x
 *
 * Utánvét Ellenőr integration for Craft CMS
 *
 * @link      https://www.webmenedzser.hu
 * @copyright Copyright (c) 2020 dr. Ottó Radics
 */

namespace webmenedzser\craftutanvetellenor\controllers;

use webmenedzser\craftutanvetellenor\services\PaymentMethods;

use Craft;
use craft\web\Controller;

use yii\web\Response;

/**
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 */
class PaymentMethodsController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * @return Response
     */
    public function actionIndex() : Response
    {
        return $this->asJson(PaymentMethods::getAllCustomerEnabledGateways());
    }
}
