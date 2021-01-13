<?php

namespace App\Libraries\PaymentSystem\Handlers;

interface PaymentInterface
{

    //------------------------------------------------------------------------//

    public function setPaymentID($payment_id);

    public function getPaymentID();

    public function setInvoiceID($invoice_id);

    public function getInvoiceID();

    public function setOrderRef($order_ref);

    public function getOrderRef();

    public function setDate($date);

    public function getDate();

    public function setAmount($amount);

    public function getAmount();

    public function setCurrency($currency);

    public function getCurrency();

    public function setPaymentMethod($payment_method);

    public function getPaymentMethod();

    public function setJsonData($data);

    public function getJsonData();

    public function setCheckoutStatus($checkout_status);

    public function getCheckoutStatus();

    public function setResponseStatus($responseStatus);

    public function getResponseStatus();

    public function setResponseID($response_id);

    public function getResponseID();

    public function setResponseData($response);

    public function getResponseData();

    public function setPaymentData($data);

    public function getPaymentData();

    //------------------------------------------------------------------------//

    public function setLang($lang);

    public function getLang();

    //------------------------------------------------------------------------//

    public function setError($error_code, $error_message);

    public function getErrors();

    //------------------------------------------------------------------------//

    public function getConfig();

    //------------------------------------------------------------------------//
    public function addProduct($productData);

    public function getProducts();

    //------------------------------------------------------------------------//

    public function setUrlBack($backUrl);

    public function getUrlBack();

    public function setUrl3Ds($url3Ds);

    public function getUrl3Ds();

    //------------------------------------------------------------------------//

    public function setCardData($cardData);

    public function getCardData();

    //------------------------------------------------------------------------//

    public function setBillingData($data);

    public function getBillingData();

    //------------------------------------------------------------------------//

    public function setShippingData($param);

    public function getShippingData();

    //------------------------------------------------------------------------//

    public function setBuyerData($buyerData);

    public function getBuyerData();

    //------------------------------------------------------------------------//
//    public function deleteStoredProducts(string $orderRef);

    public function get3dHtmlContent();

    public function checkout();

    public function check3dResponse();
}
