<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Util;

class PaymentController extends Controller
{
    private $mollie;

    private function initMollie()
    {
        $this->mollie = new \Mollie\Api\MollieApiClient();
        $this->mollie->setApiKey(PAYMENT_APIKEY);
    }

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
//        $this->registry->template->title = "Nick";
//        $this->registry->template->description = "Fout";
//
//        $this->registry->template->show('about');

        $this->initMollie();

        var_dump(DOMAIN);


        try {
            /*
             * Generate a unique order id for this example. It is important to include this unique attribute
             * in the redirectUrl (below) so a proper return page can be shown to the customer.
             */
            $orderId = time();
            /*
             * Determine the url parts to these example files.
             */
//            $protocol = isset($_SERVER['HTTPS']) && strcasecmp('off', $_SERVER['HTTPS']) !== 0 ? "https" : "http";
//            $hostname = $_SERVER['HTTP_HOST'];
//            $path = dirname(isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF']);
            /*
             * Payment parameters:
             *   amount        Amount in EUROs. This example creates a € 10,- payment.
             *   description   Description of the payment.
             *   redirectUrl   Redirect location. The customer will be redirected there after the payment.
             *   webhookUrl    Webhook location, used to report when the payment changes state.
             *   metadata      Custom metadata that is stored with the payment.
             */
            $payment = $this->mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => "10.00" // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                "description" => "Order #{$orderId}",
                "redirectUrl" => DOMAIN . "/payment/success/order/{$orderId}",
                "webhookUrl" => PAYMENT_WEBHOOK,
                "metadata" => [
                    "order_id" => $orderId,
                ],
            ]);

            var_dump($payment);
            /*
             * In this example we store the order with its payment status in a database.
             */
//            database_write($orderId, $payment->status);
            /*
             * Send the customer off to complete the payment.
             * This request should always be a GET, thus we enforce 303 http response code
             */
            header("Location: " . $payment->getCheckoutUrl(), true, 303);
        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
        /*
//         * NOTE: This example uses a text file as a database. Please use a real database like MySQL in production code.
//         */
//        function database_write($orderId, $status)
//        {
//            $orderId = intval($orderId);
//            $database = dirname(__FILE__) . "/orders/order-{$orderId}.txt";
//            file_put_contents($database, $status);
//        }
    }

    function success()
    {

        $this->registry->template->title = "Nick";
        $this->registry->template->description = "Fout";


        var_dump($this->registry->params);

    }

    function webhook()
    {
        try {

            $this->initMollie();
            $payment = $this->mollie->payments->get($_POST["id"]);
            $orderId = $payment->metadata->order_id;
            /*
             * Update the order in the database.
             */
            database_write($orderId, $payment->status);
            if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {
                /*
                 * The payment is paid and isn't refunded or charged back.
                 * At this point you'd probably want to start the process of delivering the product to the customer.
                 */
            } elseif ($payment->isOpen()) {
                /*
                 * The payment is open.
                 */
            } elseif ($payment->isPending()) {
                /*
                 * The payment is pending.
                 */
            } elseif ($payment->isFailed()) {
                /*
                 * The payment has failed.
                 */
            } elseif ($payment->isExpired()) {
                /*
                 * The payment is expired.
                 */
            } elseif ($payment->isCanceled()) {
                /*
                 * The payment has been canceled.
                 */
            } elseif ($payment->hasRefunds()) {
                /*
                 * The payment has been (partially) refunded.
                 * The status of the payment is still "paid"
                 */
            } elseif ($payment->hasChargebacks()) {
                /*
                 * The payment has been (partially) charged back.
                 * The status of the payment is still "paid"
                 */
            }
        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
        }
        /*
         * NOTE: This example uses a text file as a database. Please use a real database like MySQL in production code.
         */

    }

    function database_write($orderId, $status)
    {
        $orderId = intval($orderId);
        $database = dirname(__FILE__) . "/orders/order-{$orderId}.txt";
        file_put_contents($database, $status);
    }
}
