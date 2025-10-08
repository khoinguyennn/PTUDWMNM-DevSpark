<?php

namespace App\Services;

use PayOS\PayOS;
use Exception;

class PayOSService
{
    protected $payOS;

    public function __construct()
    {
        $partnerCode = config('payos.partner_code');
        
        if (!empty($partnerCode)) {
            $this->payOS = new PayOS(
                config('payos.client_id'),
                config('payos.api_key'),
                config('payos.checksum_key'),
                $partnerCode
            );
        } else {
            $this->payOS = new PayOS(
                config('payos.client_id'),
                config('payos.api_key'),
                config('payos.checksum_key')
            );
        }
    }

    /**
     * Create payment link for course enrollment
     *
     * @param array $orderData
     * @return array
     */
    public function createPaymentLink($orderData)
    {
        try {
            $data = [
                "orderCode" => $orderData['order_code'],
                "amount" => $orderData['amount'],
                "description" => $orderData['description'],
                "returnUrl" => config('payos.return_url'),
                "cancelUrl" => config('payos.cancel_url'),
                "items" => $orderData['items'] ?? null,
                "buyerName" => $orderData['buyer_name'] ?? null,
                "buyerEmail" => $orderData['buyer_email'] ?? null,
                "buyerPhone" => $orderData['buyer_phone'] ?? null,
                "buyerAddress" => $orderData['buyer_address'] ?? null,
                "expiredAt" => $orderData['expired_at'] ?? null,
            ];

            $response = $this->payOS->createPaymentLink($data);
            return [
                'success' => true,
                'data' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get payment information
     *
     * @param int $orderCode
     * @return array
     */
    public function getPaymentInfo($orderCode)
    {
        try {
            $response = $this->payOS->getPaymentLinkInformation($orderCode);
            return [
                'success' => true,
                'data' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Cancel payment link
     *
     * @param int $orderCode
     * @param string|null $reason
     * @return array
     */
    public function cancelPaymentLink($orderCode, $reason = null)
    {
        try {
            $response = $this->payOS->cancelPaymentLink($orderCode, $reason);
            return [
                'success' => true,
                'data' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify webhook data
     *
     * @param array $webhookData
     * @return array
     */
    public function verifyWebhookData($webhookData)
    {
        try {
            $response = $this->payOS->verifyPaymentWebhookData($webhookData);
            return [
                'success' => true,
                'data' => $response
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Confirm webhook URL
     *
     * @param string $webhookUrl
     * @return array
     */
    public function confirmWebhook($webhookUrl = null)
    {
        try {
            $url = $webhookUrl ?? config('payos.webhook_url');
            $this->payOS->confirmWebhook($url);
            return [
                'success' => true,
                'message' => 'Webhook confirmed successfully'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
