<?php

namespace Vandar;

use Vandar\Drivers\DriverInterface;
use Vandar\Drivers\RestDriver;

class Vandar
{
    private $redirectUrl = "https://vandar.io/ipg/";
    private $api;
    private $driver;
    private $token;

    function __construct($api, DriverInterface $driver = null)
    {
        if (is_null($driver)) {
            $this->driver = new RestDriver();
        }
        $this->driver = $driver;
        $this->api = $api;
    }

    public function request($amount, $callback, $mobile = null, $factorNumber = null, $description = null)
    {
        $inputs = [
            'api_key' => $this->api,
            'amount' => $amount,
            'callback_url' => $callback,
            'mobile_number' => $mobile,
            'factorNumber' => $factorNumber,
            'description' => $description,
        ];
        $result = $this->driver->request("send", $inputs);
        if (isset($result['token'])) {
            $this->token = $result['token'];
        }
        return $result;
    }

    public function verify($token)
    {
        return $this->driver->request("verify", [
            'api_key' => $this->api,
            'token' => $token,
        ]);
    }

    public function redirect($token = null)
    {
        header('Location: ' . $this->redirectUrl($token));
        die();
    }

    public function redirectUrl($token = null)
    {
        return $this->redirectUrl . ($this->token ?? $token);
    }

    public function enableTest()
    {
        $this->redirectUrl .= "test/";
        $this->driver->enableTest();
    }
}