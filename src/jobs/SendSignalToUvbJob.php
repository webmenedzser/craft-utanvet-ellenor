<?php
/**
 * Utánvét Ellenőr plugin for Craft CMS 3.x
 *
 * Utánvét Ellenőr integration for Craft CMS
 *
 * @link      https://www.webmenedzser.hu
 * @copyright Copyright (c) 2020 dr. Ottó Radics
 */

namespace webmenedzser\craftutanvetellenor\jobs;

use webmenedzser\craftutanvetellenor\services\Connector;

use Craft;
use craft\queue\BaseJob;

/**
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 */
class SendSignalToUvbJob extends BaseJob
{
    public $orderId;
    public $outcome;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        Connector::postReputation($this->orderId, $this->outcome);
    }

    /**
     * @inheritdoc
     */
    protected function defaultDescription() : ?string
    {
        return Craft::t('craft-utanvet-ellenor', 'Sending Signal to Utánvét Ellenőr backend.');
    }
}
