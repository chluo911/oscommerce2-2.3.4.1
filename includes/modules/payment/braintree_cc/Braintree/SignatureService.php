<?php

class Braintree_SignatureService
{
    public function __construct($key, $digest)
    {
        $this->key = $key;
        $this->digest = $digest;
    }

    public function sign($payload)
    {
        return $this->hash($payload) . "|" . $payload;
    }

    public function hash($data)
    {
        return call_user_func($this->digest, $this->key, $data);
    }
}
