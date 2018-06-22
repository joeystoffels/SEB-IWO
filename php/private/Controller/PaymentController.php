<?php

namespace Webshop\Controller;

use Webshop\Core\Controller;
use Webshop\Core\Database;
use Webshop\Core\Registry;

/**
 * Controller for Payment
 * Class PaymentController
 * @package Webshop\Controller
 */
class PaymentController extends Controller
{
    private $mollie;

    /**
     * PaymentController constructor.
     */
    function __construct()
    {
        // Call parent constructor
        parent::__construct();

        // Set title and description of the page
        $this->registry->template->title = "Payment";
        $this->registry->template->description = "Payment";

        $this->mollie = new \Mollie\Api\MollieApiClient();
        $this->mollie->setApiKey(PAYMENT_APIKEY);
    }

    /**
     * @all controllers must contain an index method
     */
    function index()
    {
        if(!Registry::Instance()->userAccount->isLogedIn()){
            $_SESSION['addToCartError'] = "U moet ingelogged zijn om de bestelling af te kunnen ronden <br> U kunt <a href='/account'>HIER</a> inloggen of registreren";
            header("Location: /cart");
        } elseif (isset($_POST['totalPrice'])) {

            try {
                /*
                 * Generate a unique order id for this example. It is important to include this unique attribute
                 * in the redirectUrl (below) so a proper return page can be shown to the customer.
                 */
                $orderId = time();
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
                        "value" => $_POST['totalPrice'] // You must send the correct number of decimals, thus we enforce the use of strings
                    ],
                    "description" => "Order #{$orderId}",
                    "redirectUrl" => DOMAIN . "/payment/success/order/{$orderId}",
                    "webhookUrl" => PAYMENT_WEBHOOK,
                    "metadata" => [
                        "order_id" => $orderId,
                    ],
                ]);

                /*
                 * In this example we store the order with its payment status in a database.
                 */
                /*
                 * Send the customer off to complete the payment.
                 * This request should always be a GET, thus we enforce 303 http response code
                 */
                header("Location: " . $payment->getCheckoutUrl(), true, 303);
            } catch (\Mollie\Api\Exceptions\ApiException $e) {
                echo "API call failed: " . htmlspecialchars($e->getMessage());
            }
        }
    }

    function success()
    {
        $this->updateSupply();
        unset($_SESSION['cart']);
        $this->registry->template->show("payment-success");
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

    /**
     * Update the supply of the items in the cart
     */
    function updateSupply()
    {
        foreach ($_SESSION['cart'] as $game) {
            $gameId = $game[0];
            $amount = $game[1];

            // The insert query
            $query = "UPDATE `games` SET `supply` = `supply` - :amount WHERE `id` = :gameId";
            $stmt = Database::getConnection()->prepare($query);

            // Bind param string to user entered information
            $stmt->bindValue(':amount', $amount, \PDO::PARAM_INT);
            $stmt->bindValue(':gameId', $gameId, \PDO::PARAM_INT);

            // Execute the query
            $count = $stmt->execute();
        }
    }
}
