<?php 

namespace utilities\Sms\classes;
use utilities\Sms\interfaces\SmsInterface;
use helpers\Helper;
use constents\Config;

class Sms implements SmsInterface
{
    /**
     * @param string $to
     * @param string $message
     * @param string $from
     * 
     * @return string
     */
    public function sendSms(string $to, string $message, string $from):string
    {
        $token = $this->getAccessToken();
        $headers = [
            'content-type: application/json',
            'authorization: Bearer '.$token
        ];
        $body = [
            "body" => $message,
            "to" => $to,
            "from" => $from
        ];
        $jsonEncoded = json_encode($body);
        $url = Config::ROUTEE_SMS_URL;
        
        $response = Helper::postReq($url, $jsonEncoded, $headers);
        $responseMessage = "";
        if (count($response) > 0) {
            $responseMessage = "SMS status: ".$response['status'];
        }else{
            $responseMessage = "Something went wrong while sending SMS";
        }
        return $responseMessage;
    }

    /**
     * @return string
     */
    private function getAccessToken():string
    {
        $key = Config::ROUTEE_APP_ID;
        $secretKey = Config::ROUTEE_SECRET_KEY;
        $encodedCreds = base64_encode($key.':'.$secretKey);

        $url = Config::ROUTEE_TOKEN_URL;
        $body = [
            "grant_type" => "client_credentials"
        ];

        $headers = [
            "authorization: Basic ".$encodedCreds,
            "content-type: application/x-www-form-urlencoded"
        ];
        $toString = http_build_query($body);
        $response = Helper::postReq($url,$toString, $headers);
        if ($response) {
            return $response['access_token'];
        }else{
            throw new \Exception("Access Token Not Found!");
        }

    }


}
