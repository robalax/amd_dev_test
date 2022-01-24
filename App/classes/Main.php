<?php 

namespace App\classes;
use App\interfaces\MainInterface;
use utilities\Weather\classes\Weather;
use utilities\Sms\classes\Sms;

class Main implements MainInterface
{
    private $weatherObj = null;
    private $smsObj = null;
    private $mimTempLimit = 20;
    private $minTempNumber = "+306911111111";
    private $maxTempNumber = "+306911111111";

    public function __construct()
    {
        $this->weatherObj = new Weather();
        $this->smsObj = new Sms();
    }

    /**
     * @return [type]
     */
    public function index():string
    {
        try {
            $city = "lahore";
        $temperature = $this->weatherObj->getCurrentTemperature($city);

        
        $from = "amdTelecom";
        $apiResponse = "";

        if ($temperature > $this->mimTempLimit) {
            $message = "Muhammad Azeem and Temperature more than 20C. ".$temperature;
            $apiResponse = $this->smsObj->sendSms($this->minTempNumber, $message, $from);
        }else{
            $message = "Muhammad Azeem and Temperature less than 20C. ".$temperature;
            $apiResponse = $this->smsObj->sendSms($this->maxTempNumber, $message, $from);
        }

        return json_encode(["message" => $apiResponse]);
        } catch (\Throwable $th) {
            return json_encode(["message" => "Error: ".$th]);
        }
    }


}
