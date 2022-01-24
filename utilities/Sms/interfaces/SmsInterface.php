<?php 

namespace utilities\Sms\interfaces;

interface SmsInterface{

    public function sendSms(string $to, string $message, string $from):string;

}