<?php

namespace SmartInvesting;

class SMS
{
    private $token;
    private $senderID;
    private $apiUrl = 'https://app.philmoresms.com/api/';

    public function __construct($token = null, $senderID = null)
    {
        $this->token = $token;
        $this->senderID = $senderID;
    }

    /**
     * Send SMS using PhilmoreSMS API
     * 
     * @param string $recipients Comma-separated list of phone numbers
     * @param string $message The message content
     * @return array Response from API
     */
    public function send($recipients, $message)
    {
        $endpoint = $this->apiUrl . 'sms.php';
        
        $params = [
            'token' => $this->token,
            'senderID' => $this->senderID,
            'recipients' => $recipients,
            'message' => $message
        ];

        return $this->postRequest($endpoint, $params);
    }

    /**
     * Check wallet balance
     * 
     * @return array Response from API
     */
    public function getBalance()
    {
        $endpoint = $this->apiUrl . 'balance.php';
        $params = ['token' => $this->token];
        
        return $this->postRequest($endpoint, $params);
    }

    /**
     * Submit a new Sender ID for approval
     * 
     * @param string $senderID The Sender ID to register
     * @param string $sampleMessage A sample message
     * @return array Response from API
     */
    public function submitSenderID($senderID, $sampleMessage)
    {
        $endpoint = $this->apiUrl . 'senderID.php';
        $params = [
            'token' => $this->token,
            'senderID' => $senderID,
            'message' => $sampleMessage
        ];
        
        return $this->postRequest($endpoint, $params);
    }

    /**
     * Check status of a Sender ID
     * 
     * @param string $senderID The Sender ID to check
     * @return array Response from API
     */
    public function checkSenderIDStatus($senderID)
    {
        $endpoint = $this->apiUrl . 'check_senderID.php';
        $params = [
            'token' => $this->token,
            'senderID' => $senderID
        ];
        
        return $this->postRequest($endpoint, $params);
    }

    /**
     * Helper to perform POST requests
     */
    private function postRequest($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['status' => 'error', 'message' => $error];
        }

        return json_decode($response, true);
    }
}
