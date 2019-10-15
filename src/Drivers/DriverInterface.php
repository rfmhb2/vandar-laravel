<?php

namespace Vandar\Driver;

interface DriverInterface
{
    public function request($inputs);

    public function verify($token, $api);

    public function setAddress($url);

    public function enableTest();

    public function restCall($uri, $data);
}