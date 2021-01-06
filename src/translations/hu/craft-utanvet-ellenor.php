<?php
/**
 * Utánvét Ellenőr plugin for Craft CMS 3.x
 *
 * Utánvét Ellenőr integration for Craft CMS
 *
 * @link      https://www.webmenedzser.hu
 * @copyright Copyright (c) 2020 dr. Ottó Radics
 */

/**
 * @author    dr. Ottó Radics
 * @package   CraftUtanvetEllenor
 * @since     1.0.0
 */
return [
    'Sending Signal to Utánvét Ellenőr backend.' => 'Visszajelzés küldése az Utánvét Ellenőr rendszernek.',
    'Which backend to use?' => 'Melyik rendszert használjuk?',
    'Production or Sandbox mode.' => 'Éles vagy sandbox üzemmód.',
    'Live' => 'Éles',
    'Sandbox' => 'Sandbox',
    'Public API Key' => 'Nyilvános API Kulcs',
    'Enter Utánvét Ellenőr public API key here.' => 'Add meg az Utánvét Ellenőrben kapott publikus API kulcsodat.',
    'Private API Key' => 'Titkos API Kulcs',
    'Enter Utánvét Ellenőr private API key here.' => 'Add meg az Utánvét Ellenőrben kapott privát API kulcsodat.',
    'Reputation Threshold' => 'Megbízhatósági mutató',
    'Calculated with the following formula: `(good-bad) / all`, so a `0.5` reputation can mean 6 successful and 2 rejected deliveries. ' => 'A következő képlettel számolva: `(jó-rossz) / összes`, tehát egy `0.5` mutató 6 sikeres és 2 visszautasított kézbesítést jelenthet. ',
    'Successful Delivery Status' => 'Sikeres Kézbesítés Állapot',
    'Select which order status indicates a successful delivery.' => 'Válaszd ki, melyik rendelési állapot jelez sikeres kézbesítést.',
    'Refused Delivery Status' => 'Visszautasított Kézbesítés Állapot',
    'Select which order status indicates a refused delivery.' => 'Válaszd ki, melyik rendelési állapot jelez visszautasított kézbesítést.',
    'Payment Methods to Hide' => 'Elrejtendő fizetési módok',
    'Hide these payment methods if the reputation is below the Reputation Threshold.' => 'Ezen fizetési módok elrejtése, ha a Megbízhatósági mutató a beállított értéket nem éri el.'
];
