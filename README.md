# Utánvét Ellenőr plugin for Craft CMS 3.x

Utánvét Ellenőr integration for Craft CMS

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft Commerce 3.2.13.2 or later.

## Installation

To install the plugin, follow these instructions.

1. [Register](https://utanvet-ellenor.hu/register) to obtain API keys, then set them in the module's settings.

2. Open your terminal and go to your Craft project:

        cd /path/to/project

3. Then tell Composer to load the plugin:

        composer require webmenedzser/craft-utanvet-ellenor

4. In the Control Panel, go to Settings → Plugins and click the “Install” button for Utánvét Ellenőr.

5. Configure the plugin:
    1. Set your API keys.
    2. Set your preferred threshold.
    3. Select which order statuses should trigger the feedback to our service.
    4. Select which payment methods should be hidden if the user's reputation is below the set threshold.

## Utánvét Ellenőr Overview

Utánvét Ellenőr is a SaaS provided by Dro-IT Ltd from Hungary: a service which will let shop owners filter orders with Cash on Delivery coming from known fraudulent e-mail addresses.

## How does it work?

The idea behind the service is the following:
* Someone orders with Cash on Delivery payment method, but later refuses to accept the package from the courier.
* The shop owner flags this order with the `Refused Package` order status.
* The module listens for orders entering this status.
* Once an order ends up in this status, the module will hash the e-mail address of the user on the shop server with SHA-256 and sends the hash to our service, accompanied by a `-1`.
* If the courier could hand over the package successfully, the shop owner flags the order with the successful order status. In this case the module hashes the e-mail with the same SHA-256 and sends the hash to our service, accompanied by a `+1`.
* When someone with the same e-mail address would like to order (from the same or from another shop), this module can disable Cash on Delivery from available payment methods:
    * The user enters his e-mail address.
    * This value gets hashed with the same SHA-256 algorithm, and the module asks our service about this hash.
    * The service will return a JSON array and if the e-mail reputation provided in this payload does not meet the minimum value set by the shop owner in the module settings (`Reputation Threshold`), the module will disable the selected payment methods.

### Privacy implications

All inputs are hashed with SHA-256 by the module on your server. This means:
* The entered e-mail address will NEVER leave your system.
* SHA-256 is considered to be safe for hashing.
* On "check requests" we don't receive the e-mail address, just a hash, and we provide only a couple of "numbers" about that hash. There is no way for us to know what was the original string before hashing.
* In order to use our services, you MUST notify your users that "Automated individual decision-making" might be applied during checkout. For more information, please see GDPR Art. 22.

> Note: this is not legal advice. Consult your lawyer before using this service in production.

## Found a bug?

Check the issues or [open a new one](https://github.com/webmenedzser/craft-utanvet-ellenor/issues)!
    
Brought to you by [dr. Ottó Radics](https://www.webmenedzser.hu)
