<?php
// app/Services/SMSService.php

namespace App\Services;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;

class SMSService
{

    /**
     * @var Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private mixed $username;
    /**
     * @var Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private mixed $password;
    /**
     * @var Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private mixed $sender;

    public function __construct()
    {
        $this->username = config('pan.sms_username');
        $this->password = config('pan.sms_password');
        $this->sender = config('pan.sms_sender');
    }

    public function sendSMS($message, $to): bool
    {

        if (strlen($this->sender) > 11) // if you want...
        {
            $maxLength = 11;
            $this->sender = substr($this->sender, 0, $maxLength);
        }

        $url = "https://speedlinksms.net/index.php?option=com_spc&comm=spc_api&username=".$this->username."&password=".$this->password."&sender=".urlencode($this->sender)."&recipient=".$to."&message=".urlencode($message)."&";

        $ch = curl_init();                       // initialize CURL
        curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);


        if( substr( $output, 0, 2 ) === "OK" || strpos($output, '1701') !== false || substr( $output, 0, 4 ) === "1701" )
        {
            return true;
        }else{
            return false;
        }
    }
}
