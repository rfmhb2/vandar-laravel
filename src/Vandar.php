<?php

namespace Vandar;

use Vandar\Driver\DriverInterface;
use Vandar\Driver\RestDriver;

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

    public function request($amount, $mobile = null, $factorNumber = null, $description = null, $callback)
    {
        $inputs = [
            'api_key' => $this->api,
            'amount' => $amount,
            'callback_url' => $callback,
            'mobile_number' => $mobile,
            'factorNumber' => $factorNumber,
            'description' => $description,
        ];
        $this->driver->request($inputs);
    }

    public function verify($token)
    {
        $this->driver->verify($token, $this->api);
    }

    public function redirect()
    {
        header('Location: ' . $this->redirectUrl());
        die();
    }

    public function redirectUrl()
    {
        return $this->redirectUrl . $this->token;
    }

    public function enableTest()
    {
        $this->driver->enableTest();
    }
}