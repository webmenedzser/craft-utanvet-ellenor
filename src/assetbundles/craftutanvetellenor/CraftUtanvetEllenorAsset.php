<?php
/**
 * Utánvét Ellenőr plugin for Craft CMS 3.x
 *
 * Utánvét Ellenőr integration for Craft CMS
 *
 * @link      https://www.webmenedzser.hu
 * @copyright Copyright (c) 2020 dr. Ottó Radics
 */

namespace webmenedzser\craftutanvetellenor\assetbundles\craftutanvetellenor;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 */
class CraftUtanvetEllenorAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@webmenedzser/craftutanvetellenor/assetbundles/craftutanvetellenor/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/CraftUtanvetEllenor.js',
        ];

        $this->css = [
            'css/CraftUtanvetEllenor.css',
        ];

        parent::init();
    }
}
