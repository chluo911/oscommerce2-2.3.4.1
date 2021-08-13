<?php

class Braintree_TextNode extends Braintree_PartialMatchNode
{
    public function contains($value)
    {
        $this->searchTerms["contains"] = strval($value);
        return $this;
    }
}
