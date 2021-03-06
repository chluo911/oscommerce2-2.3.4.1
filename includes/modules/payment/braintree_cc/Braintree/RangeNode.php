<?php

class Braintree_RangeNode
{
    public function __construct($name)
    {
        $this->name = $name;
        $this->searchTerms = array();
    }

    public function greaterThanOrEqualTo($value)
    {
        $this->searchTerms['min'] = $value;
        return $this;
    }

    public function lessThanOrEqualTo($value)
    {
        $this->searchTerms['max'] = $value;
        return $this;
    }

    public function is($value)
    {
        $this->searchTerms['is'] = $value;
        return $this;
    }

    public function between($min, $max)
    {
        return $this->greaterThanOrEqualTo($min)->lessThanOrEqualTo($max);
    }

    public function toParam()
    {
        return $this->searchTerms;
    }
}
