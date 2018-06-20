<?php

namespace Webshop\Config;

/**
 * Settings for Development
 */


/* ====================================================================================================
	01. Default Settings
==================================================================================================== */

/** Domain name */
define('DOMAIN', $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"]);

/** Debugging. */
define('DEBUG', true);

/* ====================================================================================================
	02. Database Settings
==================================================================================================== */
// ** MySQL settings ** //

/** MySql database name */
define('DB_NAME', 'gameparadise');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/* ====================================================================================================
	03. Payment Gateway
==================================================================================================== */

/** Mollie api key */
define('PAYMENT_APIKEY', "test_5Fd9rqhRBs253MsHeCaCpGmw5S9a7N");

/** Mollie webhook */
define('PAYMENT_WEBHOOK', "http://cd41a1b0.ngrok.io/payment/webhook");
