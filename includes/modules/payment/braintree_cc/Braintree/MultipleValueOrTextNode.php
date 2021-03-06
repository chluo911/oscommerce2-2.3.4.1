<?php

class Braintree_MultipleValueOrTextNode extends Braintree_MultipleValueNode
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->textNode = new Braintree_TextNode($name);
    }

    public function contains($value)
    {
        $this->textNode->contains($value);
        return $this;
    }

    public function endsWith($value)
    {
        $this->textNode->endsWith($value);
        return $this;
    }

    public function is($value)
    {
        $this->textNode->is($value);
        return $this;
    }

    public function isNot($value)
    {
        $this->textNode->isNot($value);
        return $this;
    }

    public function startsWith($value)
    {
        $this->textNode->startsWith($value);
        return $this;
    }

    public function toParam()
    {
        return array_merge(parent::toParam(), $this->textNode->toParam());
    }
}
