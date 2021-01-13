<?php

namespace App\Libraries\InvoiceSystem;

use App\Libraries\InvoiceSystem\InvoiceConfig;

class InvoiceSystem
{

    protected $items        = [];
    protected $invoiceData  = [];
    protected $payments     = [];
    protected $errors       = [];
    protected $billingData  = [];
    protected $shippingData = [];
    protected $authData     = [];

    // -------------------------------------------------------------------------

    /**
     * PaymentMethod Name inside handler
     * @param String $methodName
     */
    function __construct()
    {
        $this->config = new InvoiceConfig();
    }

    // -------------------------------------------------------------------------

    public function getError(string $field = null): string
    {
        if ($field === null && count($this->errors) === 1)
        {
            reset($this->errors);
            $field = key($this->errors);
        }
        return array_key_exists($field, $this->errors) ? $this->errors[$field] : '';
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setError($error_code, $error_message = null)
    {
        $this->errors[$error_code] = $error_message;
    }

    // -------------------------------------------------------------------------

    public function setBillingData($billingData)
    {
        $this->billingData = $billingData;
    }

    public function getBillingData()
    {
        return !empty($this->billingData) ? $this->billingData : [];
    }

    // -------------------------------------------------------------------------

    public function setShippingData($shippingData)
    {
        $this->shippingData = $shippingData;
    }

    public function getShippingData()
    {
        return !empty($this->shippingData) ? $this->shippingData : [];
    }

    // -------------------------------------------------------------------------

    public function setAuthData($data)
    {
        $this->authData = $data;
    }

    public function getAuthData()
    {
        return !empty($this->authData) ? $this->authData : [];
    }

    // -------------------------------------------------------------------------

    /**
     * 
     * 
     * @param string $invoice_status 
     * DRAFT,SENT,PAID,CANCELLED,REFUNDED,PARTIALLY_PAID,
     * PARTIALLY_REFUNDED,MARKED_AS_REFUNDED,UNPAID,PAYMENT_PENDING
     */
    public function setInvoiceStatus($invoice_status)
    {
        $this->invoiceData['invoice_status'] = $invoice_status;
    }

    public function getInvoiceStatus()
    {
        return $this->invoiceData['invoice_status'];
    }

    public function setInvoiceID($invoice_id)
    {
        $this->invoiceData['c4_invoice_id'] = $invoice_id;
    }

    public function getInvoiceID()
    {
        return $this->invoiceData['c4_invoice_id'] ?? NULL;
    }

    public function setCurrency($currency)
    {
        $this->invoiceData['currency'] = strtoupper($currency);
    }

    public function getCurrency()
    {
        return $this->invoiceData['currency'];
    }

    public function setRemaining($remaining)
    {
        $this->invoiceData['remaining'] = $remaining;
    }

    public function getRemaining()
    {
        return $this->invoiceData['remaining'];
    }

    public function setDesc($desc)
    {
        $this->invoiceData['description'] = $desc;
    }

    public function getDesc()
    {
        return $this->invoiceData['description'];
    }

    public function setJsonData($data)
    {
        if (is_string($data))
        {
            $data = json_decode($data, true);
        }

        $this->invoiceData['json_data'] = $data;
    }

    public function getJsonData(): array
    {
        if (is_array($this->invoiceData['json_data']))
        {
            return $this->invoiceData['json_data'];
        }

        return $this->invoiceData['json_data'] ?? [];
    }

    // -------------------------------------------------------------------------

    public function getInvoiceModel()
    {
        $defaultNamespace = service('routes')->getDefaultNamespace();
        $modelPath        = "\\" . $defaultNamespace . "Models\C4_invoiceModel";
        return new $modelPath();
    }

    public function getInvoiceItemsModel()
    {
        $defaultNamespace = service('routes')->getDefaultNamespace();
        $modelPath        = "\\" . $defaultNamespace . "Models\C4_invoice_itemModel";
        return new $modelPath();
    }

    public function getPaymentModel()
    {
        $defaultNamespace = service('routes')->getDefaultNamespace();
        $modelPath        = "\\" . $defaultNamespace . "Models\C4_paymentModel";
        return new $modelPath();
    }

    public function getAccountModel()
    {
        $defaultNamespace = service('routes')->getDefaultNamespace();
        $modelPath        = "\\" . $defaultNamespace . "Models\C4_accountModel";
        return new $modelPath();
    }

    public function getTransactionModel()
    {
        $defaultNamespace = service('routes')->getDefaultNamespace();
        $modelPath        = "\\" . $defaultNamespace . "Models\C4_transactionModel";
        return new $modelPath();
    }

    public function getTransactionHistoryItemModel()
    {
        $defaultNamespace = service('routes')->getDefaultNamespace();
        $modelPath        = "\\" . $defaultNamespace . "Models\C4_transaction_history_itemModel";
        return new $modelPath();
    }

    // -------------------------------------------------------------------------

    function addItems($items)
    {
        if (!empty($items) && is_array($items))
        {
            foreach ($items as $itemData)
            {
                if (!is_array($itemData))
                {
                    continue;
                }

                $this->addItem($itemData);
            }
        }
    }

    /**
     * name
     * quantity
     * currency
     * unit_price
     * vat_rate
     * discount_type => percentage||amount
     * discount_value
     * excise_duty_type => percentage||amount
     * excise_duty_value
     * communications_tax_type => percentage||amount
     * communications_tax_value
     * @param array $itemData
     */
    function addItem($itemData)
    {

        $itemData['name']                     = $itemData['name'] ?? 'UndefinedName';
        $itemData['quantity']                 = $itemData['quantity'] ?? 1;
        $itemData['currency']                 = $itemData['currency'] ?? $this->getCurrency();
        $itemData['unit_price']               = $itemData['unit_price'] ?? 0;
        $itemData['vat_rate']                 = $itemData['vat_rate'] ?? 0;
        $itemData['discount_type']            = $itemData['discount_type'] ?? 'percentage'; //amount
        $itemData['discount_value']           = $itemData['discount_value'] ?? 0;
        $itemData['excise_duty_type']         = $itemData['excise_duty_type'] ?? 'percentage'; //amount
        $itemData['excise_duty_value']        = $itemData['excise_duty_value'] ?? 0;
        $itemData['communications_tax_value'] = $itemData['communications_tax_value'] ?? 0;
        $itemData['communications_tax_type']  = $itemData['communications_tax_type'] ?? 'percentage'; //amount

        $itemData['subtotal'] = $itemData['quantity'] * $itemData['unit_price'];

        // INDIRIM 
        if ($itemData['discount_type'] === 'percentage')
        {
            $itemData['discount_amount']     = $this->calculatePercentage($itemData['subtotal'], $itemData['discount_value']);
            $itemData['discount_percentage'] = $itemData['discount_value'];
        }
        else
        {
            $itemData['discount_amount']     = $itemData['discount_value'];
            $itemData['discount_percentage'] = $this->getPercentageValue($itemData['subtotal'], $itemData['discount_value']);
        }

        $itemData['gross_total'] = $itemData['subtotal'] - $itemData['discount_amount'];


        // OTV 
        if ($itemData['excise_duty_type'] === 'percentage')
        {
            $itemData['excise_duty_amount']     = $this->calculatePercentage($itemData['gross_total'], $itemData['excise_duty_value']);
            $itemData['excise_duty_percentage'] = $itemData['excise_duty_value'];
        }
        else
        {
            $itemData['excise_duty_amount']     = $itemData['excise_duty_value'];
            $itemData['excise_duty_percentage'] = $this->getPercentageValue($itemData['gross_total'], $itemData['excise_duty_value']);
        }

        $gross_total_excise_duty = $itemData['gross_total'] + $itemData['excise_duty_amount'];

        // KDV 
        //Otv li fiyat uzerinden hesaplanır. verginin vergisi dahil ediliyor
        $itemData['vat_amount'] = $this->calculatePercentage($gross_total_excise_duty, $itemData['vat_rate']);

        // OIV
        //Otvli fiyat uzerinden hesaplanır. verginin vergisi dahil.
        if ($itemData['communications_tax_type'] === 'percentage')
        {
            $itemData['communications_tax_amount']     = $this->calculatePercentage($gross_total_excise_duty, $itemData['communications_tax_value']);
            $itemData['communications_tax_percentage'] = $itemData['communications_tax_value'];
        }
        else
        {
            $itemData['communications_tax_percentage'] = $this->getPercentageValue($gross_total_excise_duty, $itemData['communications_tax_value']);
            $itemData['communications_tax_amount']     = $itemData['communications_tax_value'];
        }


        $itemData['net_total'] = $gross_total_excise_duty + $itemData['vat_amount'] + $itemData['communications_tax_amount'];

        ksort($itemData);

        $this->items[] = $itemData;
    }

    function getItems()
    {
        if (!empty($this->items) && !empty($this->getInvoiceID()))
        {
            foreach ($this->items as $key => $value)
            {
                $this->items[$key]['c4_invoice_id'] = $this->getInvoiceID();
            }
        }
        elseif (empty($this->items) && !empty($this->getInvoiceID()))
        {
            $invoiceItemsModel = $this->getInvoiceItemsModel();
            $this->addItems($invoiceItemsModel->where(['c4_invoice_id' => $this->getInvoiceID()])->findAll());
        }

        return $this->items;
    }

    // -------------------------------------------------------------------------

    function setPayments($payments)
    {
        $this->payments = $payments;
    }

    function getPayments($success = true)
    {
        if (!empty($this->payments))
        {
            return $this->payments;
        }

        if (!empty($this->getInvoiceID()))
        {
            $paymentModel = $this->getPaymentModel();

            $where['c4_invoice_id'] = $this->getInvoiceID();

            if ($success)
            {
                $where['checkout_status'] = 'SUCCESS';
            }

            $payments = $paymentModel->where($where)->findAll();
            $this->setPayments($payments);
        }

        return $this->payments;
    }

    // -------------------------------------------------------------------------

    public function setInvoiceData($invoiceData)
    {
        $this->invoiceData = $invoiceData;
    }

    public function getInvoiceData()
    {

        if (!isset($this->invoiceData['issue_date']))
        {
            $this->invoiceData['issue_date'] = date('Y-m-d');
        }

        if (!isset($this->invoiceData['due_date']))
        {
            $this->invoiceData['due_date'] = date('Y-m-d');
        }

        return $this->invoiceData;
    }

    // -------------------------------------------------------------------------

    private function getPercentageValue($total, $amount)
    {
        $n = ($amount * 100) / $total;
        return round($n, 4);
    }

    private function calculatePercentage($total, $percanteage)
    {
        $n = ($total * $percanteage) / 100;
        return round($n, 4);
    }

    private function decreasePercentage($total, $percanteage)
    {
        $n = $total - (($total * $percanteage) / 100);
        return round($n, 4);
    }

    private function increasePercentage($total, $percanteage)
    {
        $n = $total + (($total * $percanteage) / 100);
        return round($n, 4);
    }

    private function _getAllJsonData()
    {
        return json_encode(
                [
                    'invoice_data' => $this->getInvoiceData(),
                    'items'        => $this->getItems(),
                    'payments'     => $this->getPayments(),
                    'errors'       => $this->getErrors(),
                    'billingData'  => $this->getBillingData(),
                    'shippingData' => $this->getShippingData(),
                    'authData'     => $this->getAuthData(),
                ]
        );
    }

    // -------------------------------------------------------------------------

    private function calculateInvoive()
    {

        $this->invoiceData['invoice_discount_value'] = $this->invoiceData['invoice_discount_value'] ?? 0;
        $this->invoiceData['invoice_discount_type']  = $this->invoiceData['invoice_discount_type'] ?? 'percentage';
        $this->invoiceData['withholding_rate']       = $this->invoiceData['withholding_rate'] ?? 0; //stopaj
        $this->invoiceData['vat_withholding_rate']   = $this->invoiceData['vat_withholding_rate'] ?? 0; //kdv tevkifat

        $this->invoiceData['subtotal']                 = 0;
        $this->invoiceData['gross_total']              = 0;
        $this->invoiceData['total_discount']           = 0;
        $this->invoiceData['total_excise_duty']        = 0; //Total OTV
        $this->invoiceData['total_communications_tax'] = 0; //Total OIV

        $this->invoiceData['has_items'] = $this->invoiceData['has_items'] ?? 1; //Total OIV

        if (intval($this->invoiceData['has_items']) === 1)
        {
            foreach ($this->getItems() as $itemData)
            {
                $this->invoiceData['subtotal']                 += $itemData['subtotal'];
                $this->invoiceData['gross_total']              += $itemData['gross_total'];
                $this->invoiceData['total_discount']           += $itemData['discount_amount'];
                $this->invoiceData['total_excise_duty']        += $itemData['excise_duty_amount']; //Otv
                $this->invoiceData['total_communications_tax'] += $itemData['communications_tax_amount']; //Oiv
            }
        }
        else
        {
            $this->invoiceData['subtotal']                 = $this->invoiceData['net_total'] - $this->invoiceData['total_vat'];
            $this->invoiceData['gross_total']              = $this->invoiceData['net_total'] - $this->invoiceData['total_vat'];
            $this->invoiceData['total_discount']           = 0;
            $this->invoiceData['total_excise_duty']        = 0; //Otv
            $this->invoiceData['total_communications_tax'] = 0; //Oiv
        }

        if ($this->invoiceData['invoice_discount_type'] === 'percentage')
        {
            $this->invoiceData['invoice_discount_amount']     = $this->calculatePercentage($this->invoiceData['gross_total'], $this->invoiceData['invoice_discount_value']);
            $this->invoiceData['invoice_discount_percentage'] = $this->invoiceData['invoice_discount_value'];
        }
        else
        {
            $this->invoiceData['invoice_discount_amount']     = $this->invoiceData['invoice_discount_value'];
            $this->invoiceData['invoice_discount_percentage'] = $this->getPercentageValue($this->invoiceData['gross_total'], $this->invoiceData['invoice_discount_value']);
        }

        $this->invoiceData['total_excise_duty']        = $this->decreasePercentage($this->invoiceData['total_excise_duty'], $this->invoiceData['invoice_discount_percentage']);
        $this->invoiceData['total_communications_tax'] = $this->decreasePercentage($this->invoiceData['total_communications_tax'], $this->invoiceData['invoice_discount_percentage']);

        // Calculate VAT ------------------------------------------------------

        if (intval($this->invoiceData['has_items']) === 1)
        {
            $vat = [];
            foreach ($this->getItems() as $itemData)
            {
                $vat_amount         = $itemData['vat_amount'];
                $vat_rate           = $itemData['vat_rate'];
                $excise_duty_amount = $itemData['excise_duty_amount'];

                if (!isset($vat['vat_' . $vat_rate]))
                {
                    $vat['vat_' . $vat_rate] = 0;
                }

                $vat['vat_' . $vat_rate] += $this->decreasePercentage($vat_amount, $this->invoiceData['invoice_discount_percentage']);
            }

            $this->invoiceData['vat_analysis'] = $vat;
            $this->invoiceData['total_vat']    = array_sum($vat);
        }
                  
        // ---------------------------------------------------------------------
        //Burut Total 
        $this->invoiceData['before_taxes_total']     = $this->invoiceData['gross_total'] - $this->invoiceData['invoice_discount_amount'];
        //Stopaj
        $this->invoiceData['withholding_amount']     = $this->calculatePercentage($this->invoiceData['before_taxes_total'], $this->invoiceData['withholding_rate']);
        //KDV TEVK.        
        $this->invoiceData['vat_withholding_amount'] = $this->calculatePercentage($this->invoiceData['total_vat'], $this->invoiceData['vat_withholding_rate']);
        //Net Total
        $this->invoiceData['net_total']              = $this->invoiceData['before_taxes_total'] //
                - $this->invoiceData['withholding_amount'] //Stopaj 0
                + $this->invoiceData['total_excise_duty'] //Otv 
                + $this->invoiceData['total_communications_tax'] //Oiv
                + $this->invoiceData['total_vat']  //KDV 18
                - $this->invoiceData['vat_withholding_amount'];    //KDV Tefkifat tutarı

        ksort($this->invoiceData);

        $payments   = $this->getPayments();
        $total_paid = 0;
        if (!empty($payments))
        {
            foreach ($payments as $paymentData)
            {
                if ($paymentData['checkout_status'] === 'SUCCESS')
                {
                    $total_paid += $paymentData['amount'];
                }
            }
        }

        $this->invoiceData['total_paid'] = round($total_paid, 4);
        $this->invoiceData['remaining']  = $this->invoiceData['net_total'] - $total_paid;

        //DRAFT,SENT,PAID,CANCELLED,REFUNDED,PARTIALLY_PAID,PARTIALLY_REFUNDED,MARKED_AS_REFUNDED,UNPAID,PAYMENT_PENDING
        if ($this->invoiceData['remaining'] > 0.01 && $this->getInvoiceStatus() === 'PAID')
        {
            if ($total_paid > 0)
            {
                $this->setInvoiceStatus('PARTIALLY_PAID');
            }
            else
            {
                $this->setInvoiceStatus('UNPAID');
            }
        }
        elseif (($this->invoiceData['remaining']) < 0.01)
        {
            $this->setInvoiceStatus('PAID');
        }
    }

    // -------------------------------------------------------------------------

    public function create()
    {

        if (empty($this->getInvoiceID()))
        {
            $this->generateInvoiceNumber();
        }

        $InvoiceModel      = $this->getInvoiceModel();
        $InvoiceItemsModel = $this->getInvoiceItemsModel();

        $this->calculateInvoive();

        $data              = $this->getInvoiceData();
        $data['json_data'] = $this->_getAllJsonData();

        $InvoiceModel->save($data);

        $invoice_id = $InvoiceModel->getInsertID();

        $this->setInvoiceID($invoice_id);

        $items = $this->getItems();

        foreach ($items as $itemData)
        {
            $InvoiceItemsModel->save($itemData);
        }
    }

    public function read($invoiceID)
    {
        $invoiceModel      = $this->getInvoiceModel();
        $this->invoiceData = $invoiceModel->find($invoiceID);

        if (empty($this->invoiceData))
        {
            $this->setError('noInvoiceData', 'There is no invoice data in database');
            return false;
        }

        $jsonData = json_decode($this->invoiceData['json_data'], TRUE);

        $this->setInvoiceID($invoiceID);
        $this->setBillingData($jsonData['billingData'] ?? []);
        $this->setShippingData($jsonData['shippingData'] ?? []);
        $this->setAuthData($jsonData['authData'] ?? []);

        $this->calculateInvoive();

        return $this->invoiceData;
    }

    public function update($updateData, $where = [])
    {
        $invoiceModel = $this->getInvoiceModel();

        if (empty($where) && !empty($this->getInvoiceID()))
        {
            $where['c4_invoice_id'] = $this->getInvoiceID();
        }

        $invoiceModel->update($where, $updateData);
    }

    // -------------------------------------------------------------------------

    public function generateInvoiceNumber()
    {
        $db = db_connect();

        $query = $db->query('SELECT invoice_series, invoice_number FROM c4_invoice ORDER BY c4_invoice_id DESC LIMIT 1');
        $row   = $query->getRowArray();

        if (!empty($row))
        {
            $this->invoiceData['invoice_number'] = intval($row['invoice_number']) + 1;
            $this->invoiceData['invoice_series'] = $this->config->invoice_series;
        }
        else
        {
            $this->invoiceData['invoice_number'] = $this->config->invoice_series;
        }
    }

    // -------------------------------------------------------------------------

    /**
     * Callback when paymeny updated.
     * @param type $param
     */
    public function onPaymentUpdated($c4_payment_id)
    {
        $paymentModel = $this->getPaymentModel();
        $paymentData  = $paymentModel->where(['c4_payment_id' => $c4_payment_id])->first();

        // ---------------------------------------------
        /**
         * Calculate Invoice
         */
        if (!empty($paymentData['c4_invoice_id']))
        {
            $this->read($paymentData['c4_invoice_id']);
            $this->update($this->getInvoiceData());
        }
        // ---------------------------------------------

        $paymentTransaction = $this->getTransactionData(['c4_payment_id' => $c4_payment_id]);

        // ---------------------------------------------
        //Invoice Payment
        if (!empty($paymentTransaction) && !empty($paymentData['c4_invoice_id']))
        {
            $invoiceData       = $this->getInvoiceData();
            $c4_transaction_id = $paymentTransaction['c4_transaction_id'];
            $c4_account_id     = $paymentTransaction['c4_account_id'];

            $invoice_type = $invoiceData['invoice_type'];

            $t_data = $paymentTransaction;


            $oldBalance = $t_data['history_items'][0]['try_balance'];
            $currency   = 'TRY';


            if ($invoice_type === 'sales_invoice')
            {
                //Musteriden tahsilat
                $t_data['c4_account_id']    = $paymentData['c4_account_id'];
                $t_data['transaction_type'] = 'contact_credit';
                $t_data['description']      = $paymentData['notes'];
                $t_data['debit_amount']     = $paymentData['amount'];
                $t_data['debit_currency']   = $paymentData['currency'];
                $t_data['date']             = $paymentData['date'];
                $t_data['c4_payment_id']    = $c4_payment_id;


                $currency          = $t_data['debit_currency'];
                $transactionAmount = $t_data['debit_amount'];
            }
            elseif ($invoice_type === 'purchase_bill')
            {
                $t_data['c4_account_id']    = $paymentData['c4_account_id'];
                $t_data['transaction_type'] = 'contact_debit';
                $t_data['description']      = $paymentData['notes'];
                $t_data['credit_amount']    = $paymentData['amount'];
                $t_data['credit_currency']  = $paymentData['currency'];
                $t_data['date']             = $paymentData['date'];
                $t_data['c4_payment_id']    = $c4_payment_id;

                $currency          = $t_data['credit_currency'];
                $transactionAmount = -1 * floatval($t_data['credit_amount']);
            }

            $this->updateTransaction($t_data, ['c4_transaction_id' => $c4_transaction_id]);


            //eur_balance gbp_balance try_balance usd_balance
            $balance_name = strtolower($currency) . '_balance';

            // New Position of transaction
            $prevTransaction = $this->getPreviousTransaction($t_data);
            $nextTransaction = $this->getNextTransactions($t_data);

            $previus_balance = 0;
            if (!empty($prevTransaction))
            {
                $previus_balance = $prevTransaction['history_items'][0][$balance_name] ?? 0;
            }

            $new_balance = $transactionAmount + $previus_balance;
            $m           = $this->getTransactionHistoryItemModel();
            $m->where(['c4_transaction_id' => $c4_transaction_id]);
            $m->set($balance_name, $new_balance, FALSE);
            $m->update();


            //Update other history

            if (!empty($nextTransaction))
            {
                $last_balance = $new_balance;

                foreach ($nextTransaction as $key => $nTransactionData)
                {

                    $history_item                   = $nTransactionData['history_items'][0] ?? null;
                    $c4_transaction_history_item_id = $history_item['c4_transaction_history_item_id'];

                    $amount = $nTransactionData['debit_amount'];

                    if ($nTransactionData['credit_amount'] > 0)
                    {
                        $amount = -1 * $nTransactionData['credit_amount'];
                    }

                    $new_balance = $last_balance + $amount;

                    $m->where(['c4_transaction_history_item_id' => $c4_transaction_history_item_id]);
                    $m->set($balance_name, $new_balance);
                    $m->update();

                    $last_balance = $new_balance;
                }
            }

            $this->setLastBalance($c4_account_id);
        }
        // ---------------------------------------------
    }

    // -------------------------------------------------------------------------

    /**
     * Callback when paymeny deleted.
     * @param type array
     */
    public function onPaymentDeleted($deletedPaymentData)
    {
        //$paymentModel = $this->getPaymentModel();

        $c4_payment_id = $deletedPaymentData['c4_payment_id'];

        if (!empty($deletedPaymentData['c4_invoice_id']))
        {
            $this->read($deletedPaymentData['c4_invoice_id']);
            $invoiceData = $this->getInvoiceData();
            $this->update($invoiceData);
        }

        if (!empty($deletedPaymentData['c4_account_id']))
        {
            helper('c4_transaction');
            helper('c4_transaction_history_item');

            //Find Payment Transaction
            $paymentTransaction = $this->getTransactionData(['c4_payment_id' => $c4_payment_id]);

            if (!empty($paymentTransaction))
            {
                $c4_transaction_id = $paymentTransaction['c4_transaction_id'];
                deleteC4_transaction($c4_transaction_id);
            }

            $this->setLastBalance($deletedPaymentData['c4_account_id']);
        }
    }

    // -------------------------------------------------------------------------

    public function onPaymentInserted($c4_payment_id)
    {
        $paymentModel = $this->getPaymentModel();
        $paymentData  = $paymentModel->where(['c4_payment_id' => $c4_payment_id])->first();


        if (!empty($paymentData['c4_invoice_id']))
        {
            $this->read($paymentData['c4_invoice_id']);
            $invoiceData = $this->getInvoiceData();
            $this->update($invoiceData);
        }

        if (!empty($paymentData['c4_invoice_id']) && !empty($paymentData['c4_account_id']))
        {
            $this->_createPaymentTransaction($paymentData, $invoiceData);
        }
    }

    private function _createPaymentTransaction($paymentData, $invoiceData)
    {

        $c4_payment_id = $paymentData['c4_payment_id'];

        if (!empty($paymentData['c4_account_id']))
        {
            helper('c4_transaction');

            $invoice_type = $invoiceData['invoice_type'];

            $getTransactionModel = $this->getTransactionModel();

            if ($invoice_type === 'sales_invoice')
            {
                //Musteriden tahsilat
                $t_data['c4_account_id']    = $paymentData['c4_account_id'];
                $t_data['transaction_type'] = 'contact_credit';
                $t_data['description']      = $paymentData['notes'];
                $t_data['debit_amount']     = $paymentData['amount'];
                $t_data['debit_currency']   = $paymentData['currency'];
                $t_data['date']             = $paymentData['date'];
                $t_data['c4_payment_id']    = $c4_payment_id;
            }
            elseif ($invoice_type === 'purchase_bill')
            {
                $t_data['c4_account_id']    = $paymentData['c4_account_id'];
                $t_data['transaction_type'] = 'contact_debit';
                $t_data['description']      = $paymentData['notes'];
                $t_data['credit_amount']    = $paymentData['amount'];
                $t_data['credit_currency']  = $paymentData['currency'];
                $t_data['date']             = $paymentData['date'];
                $t_data['c4_payment_id']    = $c4_payment_id;
            }

            $getTransactionModel->save($t_data);
        }
    }

    // ************************************************************************
    // 
    // ************************************************************************

    // -------------------------------------------------------------------------
    public function getAccountData($c4_account_id)
    {
        $accountModel = $this->getAccountModel();
        return $accountModel->where(['c4_account_id' => $c4_account_id])->first();
    }

    public function setAccountBalance($c4_account_id, $balance)
    {
        $accountModel = $this->getAccountModel();
        $accountModel->where(['c4_account_id' => $c4_account_id])->set(['balance' => $balance])->update();
    }

    public function updateTransaction($updateData, $where = [])
    {

        $tModel = $this->getTransactionModel();
        $tModel->update($where, $updateData);
    }

    public function getTransactionData($where)
    {
        if (!empty($where) && is_numeric($where))
        {
            $where = ['c4_transaction_id' => $where];
        }

        $m = $this->getTransactionModel();
        $m->where($where);

        $transaction_data = $m->first();

        if (!empty($transaction_data))
        {
            $c4_transaction_id                 = $transaction_data['c4_transaction_id'];
            $n                                 = $this->getTransactionHistoryItemModel();
            $transaction_data['history_items'] = $n->where('c4_transaction_id', $c4_transaction_id)->find();
        }

        return $transaction_data;
    }

    // -------------------------------------------------------------------------


    public function getPreviousTransaction($transactionData)
    {
        if (is_numeric($transactionData))
        {
            $transactionData = $this->getTransactionData($transactionData);
        }

        if (empty($transactionData))
        {
            return FALSE;
        }

        $date              = $transactionData['date'];
        $c4_transaction_id = $transactionData['c4_transaction_id'];
        $c4_account_id     = $transactionData['c4_account_id'];

        //Same day transaction
        $m = $this->getTransactionModel();

        $m->groupStart();
        $m->where('date', $date);
        $m->where('c4_account_id', $c4_account_id);
        $m->where('c4_transaction_id <', $c4_transaction_id);
        $m->groupEnd();

        $m->orGroupStart();
        $m->where('date <', $date);
        $m->where('c4_account_id', $c4_account_id);
        $m->groupEnd();

        $m->orderBy('date DESC');
        $m->orderBy('c4_transaction_id DESC');
        $transaction_data = $m->first();

        if (!empty($transaction_data))
        {
            $c4_transaction_id                 = $transaction_data['c4_transaction_id'];
            $n                                 = $this->getTransactionHistoryItemModel();
            $transaction_data['history_items'] = $n->where('c4_transaction_id', $c4_transaction_id)->find();
        }

        return $transaction_data;
    }

    public function getNextTransactions($transactionData)
    {

        $date              = $transactionData['date'];
        $c4_transaction_id = $transactionData['c4_transaction_id'];
        $c4_account_id     = $transactionData['c4_account_id'];

        $m = $this->getTransactionModel();

        $m->groupStart();
        $m->where('date', $date);
        $m->where('c4_account_id', $c4_account_id);
        $m->where('c4_transaction_id >', $c4_transaction_id);
        $m->groupEnd();

        $m->orGroupStart();
        $m->where('date >', $date);
        $m->where('c4_account_id', $c4_account_id);
        $m->groupEnd();

        $m->orderBy('date ASC');
        $m->orderBy('c4_transaction_id ASC');

        $transaction_data = $m->findAll();

        if (!empty($transaction_data))
        {
            $n = $this->getTransactionHistoryItemModel();

            foreach ($transaction_data as $key => $tData)
            {
                $c4_transaction_id                       = $tData['c4_transaction_id'];
                $transaction_data[$key]['history_items'] = $n->where('c4_transaction_id', $c4_transaction_id)->find();
            }
        }

        return $transaction_data;
    }

    public function saveHistoryItem($historyData)
    {
        $m = $this->getTransactionHistoryItemModel();
        $m->save($historyData);
    }

    public function updateHistoryBalance($where, $balanceName, $amount)
    {
        if (!empty($where) && is_numeric($where))
        {
            $where = ['c4_transaction_history_item_id' => $where];
        }

        $m = $this->getTransactionHistoryItemModel();
        $m->where($where);
        $m->set($balanceName, "{$balanceName} + $amount", FALSE);
        $m->update();
    }

    public function getLastTransaction($c4_account_id)
    {

        //Same day transaction
        $m                = $this->getTransactionModel();
        $m->where('c4_account_id', $c4_account_id);
        $m->orderBy('date DESC');
        $m->orderBy('c4_transaction_id DESC');
        $transaction_data = $m->first();

        if (!empty($transaction_data))
        {
            $c4_transaction_id                 = $transaction_data['c4_transaction_id'];
            $n                                 = $this->getTransactionHistoryItemModel();
            $transaction_data['history_items'] = $n->where('c4_transaction_id', $c4_transaction_id)->find();
        }

        return $transaction_data;
    }

    public function setLastBalance($c4_account_id)
    {
        $accountData = $this->getAccountData($c4_account_id);

        if (empty($accountData))
        {
            return;
        }
        $currency         = $accountData['currency'];
        $balance_name     = strtolower($currency) . '_balance';
        $transaction_data = $this->getLastTransaction($c4_account_id);
        $lastBalance      = $transaction_data['history_items'][0][$balance_name] ?? 0.0;

        return $this->setAccountBalance($c4_account_id, $lastBalance);
    }

    // -------------------------------------------------------------------------
    /**
     *  Callback when transaction deleted
     * @param type $transactionData
     */
    public function onTransactionDeleted($transactionData)
    {

        if (!empty($transactionData['c4_payment_id']))
        {
            helper('c4_payment');
            deleteC4_payment($transactionData['c4_payment_id']);
        }

        $this->_transactionProcess($transactionData, true);
    }

    // -------------------------------------------------------------------------

    /**
     * Callback when transaction inserted
     * @param type $c4_transaction_id
     */
    public function onTransactionInserted($c4_transaction_id)
    {
        $transactionData = $this->getTransactionData($c4_transaction_id);
        $this->_transactionProcess($transactionData);
    }

    // -------------------------------------------------------------------------

    /**
     * TransactionProcess
     * @param type $transactionData
     * @param type $deleteProcess
     * @return type
     */
    private function _transactionProcess($transactionData, $deleteProcess = false)
    {

        if (empty($transactionData))
        {
            return;
        }

        $c4_transaction_id = $transactionData['c4_transaction_id'];
        $c4_account_id     = $transactionData['c4_account_id'];

        $currency        = 'TRY';
        $previus_balance = 0;

        if (!empty($transactionData['debit_amount']) && $transactionData['debit_amount'] > 0)
        {
            $currency          = $transactionData['debit_currency'];
            $transactionAmount = $transactionData['debit_amount'];
        }
        else
        {
            $currency          = $transactionData['credit_currency'];
            $transactionAmount = -1 * floatval($transactionData['credit_amount']);
        }

        if ($deleteProcess)
        {
            $transactionAmount = -1 * $transactionAmount;
        }

        //eur_balance gbp_balance try_balance usd_balance
        $balance_name = strtolower($currency) . '_balance';

        $prevTransaction = $this->getPreviousTransaction($transactionData);
        $nextTransaction = $this->getNextTransactions($transactionData);

        if (!empty($prevTransaction))
        {
            $previus_balance = $prevTransaction['history_items'][0][$balance_name] ?? 0;
        }

        if ($deleteProcess === FALSE)
        {
            $this->saveHistoryItem([
                'c4_transaction_id' => $c4_transaction_id,
                $balance_name       => $previus_balance + $transactionAmount,
                'created_at'        => date('Y-m-d H:i:s'),
            ]);
        }

        if (!empty($nextTransaction))
        {
            foreach ($nextTransaction as $key => $nTransactionData)
            {
                $history_item = $nTransactionData['history_items'][0] ?? null;

                if (empty($history_item))
                {
                    $previus_balance = $previus_balance + $transactionAmount;

                    $this->saveHistoryItem([
                        'c4_transaction_id' => $c4_transaction_id,
                        $balance_name       => $previus_balance,
                        'created_at'        => date('Y-m-d H:i:s'),
                    ]);
                }
                else
                {
                    $c4_transaction_history_item_id = $history_item['c4_transaction_history_item_id'];
                    $this->updateHistoryBalance($c4_transaction_history_item_id, $balance_name, $transactionAmount);
                }
            }
        }

        $this->setLastBalance($c4_account_id);
    }

}
