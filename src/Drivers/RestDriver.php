<?php

namespace Vandar\Driver;

class RestDriver implements DriverInterface
{
    protected $baseUrl = "https://vandar.io/api/ipg/";

    public function request($inputs)
    {
        $result = $this->restCall("send", $inputs);
        return json_decode($result, true);
    }

    public function verify($token, $api)
    {
        return $this->restCall("verify", [
            'api_key' => $api,
            'token' => $token,
        ]);
    }

    public function restCall($uri, $data)
    {
        $url = $this->baseUrl . $uri;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public function setAddress($url)
    {
        $this->baseUrl = $url;
    }

    public function enableTest()
    {
        $this->baseUrl .= "test/";
    }
}