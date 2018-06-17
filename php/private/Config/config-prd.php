<?php

/* ====================================================================================================
	01. Default Settings
==================================================================================================== */

/** Domain name */
define('DOMAIN', $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"]);

/** Debugging. */
define('DEBUG', true);

/* ====================================================================================================
	02. Database Settings
==================================================================================================== */
// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gameparadise');

/** MySQL database username */
define('DB_USER', 'gameparadiseUser');

/** MySQL database password */
define('DB_PASSWORD', 'rx5G_f92');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/* ====================================================================================================
	03. Payment Gateway
==================================================================================================== */

/** Mollie api key */
define('PAYMENT_APIKEY', "test_5Fd9rqhRBs253MsHeCaCpGmw5S9a7N");

/** Mollie webhook */
define('PAYMENT_WEBHOOK', DOMAIN . "/payment/webhook");
