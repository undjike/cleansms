<?php

/**
 * Base author: Junior DJANZOU
 * Date: 19/08/2020
 * Time: 13:49
 *
 * Enhanced by : Ulrich Pascal NDJIKE ZOA
 * Date: 26/08/2020
 * Time: 13:10
 */

namespace Undjike\CleanSmsPhp;

use Exception;

class CleanSms
{
    /**
     * SMS service URLs stubs
     *
     * @var string[]
     */
    private $urls = [
        'credit' => "http://my.cleansms.biz/api/v2/{api_key}/credit/2",
        'sms' => "http://my.cleansms.biz/api/v2/{api_key}/sms/simple",
        'histories' => "http://my.cleansms.biz/api/v2/{api_key}/logs/history"
    ];

    /**
     * Whether custom URLs should be used for the service
     *
     * @var bool
     */
    private $useCustomUrls = false;

    /**
     * SMS service custom URLs
     *
     * @var string[]
     */
    protected $customUrls = [];

    /**
     * Your API Key generated on your CleanSMS account
     *
     * @var string|null
     */
    public $apiKey = null;

    /**
     * Your email address on your CleanSMS account
     *
     * @var string|null
     */
    public $email = null;

    /**
     * Service headers
     *
     * @var string[]
     */
    private $headers = [
        "content-type: application/json",
        "accept: application/json"
    ];

    /**
     * CleanSms constructor.
     *
     * @param string|null $apiKey
     * @param string|null $email
     */
    public function __construct($apiKey = null, $email = null)
    {
        $this->setEmail($email);
        $this->setApiKey($apiKey);
    }

    /**
     * Elegant pseudo-constructor
     *
     * @param null $apiKey
     * @param null $email
     * @return CleanSms
     */
    public static function create($apiKey = null, $email = null)
    {
        return new static($apiKey, $email);
    }

    /**
     * Set api key
     *
     * @param null|string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->headers[] = "authorization: Basic {$this->apiKey}";
    }

    /**
     * Set email
     *
     * @param null|string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Elegantly set api key
     *
     * @param null|string $apiKey
     * @return CleanSms
     */
    public function apiKey($apiKey)
    {
        $this->setApiKey($apiKey);
        return $this;
    }

    /**
     * Elegantly set email
     *
     * @param null|string $email
     * @return CleanSms
     */
    public function email($email)
    {
        $this->setEmail($email);
        return $this;
    }

    /**
     * Check if API Key is defined and throw exception if not
     *
     * @throws Exception
     */
    public function checkApiKeyIsDefined()
    {
        if (!$this->apiKey)
            throw new Exception('You must define an API Key.');
    }

    /**
     * Get remaining SMS in the account
     *
     * @return false|mixed
     * @throws Exception
     */
    public function getCredit()
    {
        $this->checkApiKeyIsDefined();

        $getCreditUrl = str_replace("{api_key}", urlencode($this->apiKey), $this->urls['credit']);
        return $this->exec(array(), ($this->useCustomUrls ? $this->customUrls['credit'] : $getCreditUrl));
    }

    /**
     * Send SMS to multiple addressees
     *
     * @param string $message
     * @param string|array $to List of phone numbers (+237*****, +245*****, ...)
     * @return false|mixed
     * @throws Exception
     */
    public function sendSms($message, $to)
    {
        $this->checkApiKeyIsDefined();

        if (is_array($to))
            $to = implode(', ', $to);
        elseif (!is_string($to))
            throw new Exception('The given phone numbers have a wrong type.');

        $data = [
            'msisdn' => trim($to, ' ,'),
            'msg' => $message
        ];

        if (strpos($to, ',') === false) {
            $data['truefalse'] = true;
            $url = $this->urls['sms'];
        }
        else {
            $data['name'] = 'MyService';
            $url = str_replace('simple', 'campaign', $this->urls['sms']);
        }

        $url = str_replace("{api_key}", urlencode($this->apiKey), $url);
        return $this->exec($data, $url);
    }

    /**
     * Execute Curl request
     *
     * @param $data
     * @param $url
     * @return mixed
     */
    private function exec($data, $url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . '?' . http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            //CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'content-type: ' . "application/json",
                'accept: ' . "application/json"
            ),
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $result = curl_exec($curl);
        //$error = curl_error($curl);

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $isSuccess = 200 <= $code && $code < 300;
        curl_close($curl);

        if (!$isSuccess) {
            return false;
        } else {
            return $result;
        }
    }
}