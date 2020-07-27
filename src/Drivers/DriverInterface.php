<?php

namespace Vandar\Drivers;

interface DriverInterface
{
    public function request($uri, $inputs);

    public function setAddress($url);

    public function enableTest();
}