<?php
class Braintree_CustomerSearch
{
    public static function addressCountryName()
    {
        return new Braintree_TextNode('address_country_name');
    }
    public static function addressExtendedAddress()
    {
        return new Braintree_TextNode('address_extended_address');
    }
    public static function addressFirstName()
    {
        return new Braintree_TextNode('address_first_name');
    }
    public static function addressLastName()
    {
        return new Braintree_TextNode('address_last_name');
    }
    public static function addressLocality()
    {
        return new Braintree_TextNode('address_locality');
    }
    public static function addressPostalCode()
    {
        return new Braintree_TextNode('address_postal_code');
    }
    public static function addressRegion()
    {
        return new Braintree_TextNode('address_region');
    }
    public static function addressStreetAddress()
    {
        return new Braintree_TextNode('address_street_address');
    }
    public static function cardholderName()
    {
        return new Braintree_TextNode('cardholder_name');
    }
    public static function company()
    {
        return new Braintree_TextNode('company');
    }
    public static function email()
    {
        return new Braintree_TextNode('email');
    }
    public static function fax()
    {
        return new Braintree_TextNode('fax');
    }
    public static function firstName()
    {
        return new Braintree_TextNode('first_name');
    }
    public static function id()
    {
        return new Braintree_TextNode('id');
    }
    public static function lastName()
    {
        return new Braintree_TextNode('last_name');
    }
    public static function paymentMethodToken()
    {
        return new Braintree_TextNode('payment_method_token');
    }
    public static function paymentMethodTokenWithDuplicates()
    {
        return new Braintree_IsNode('payment_method_token_with_duplicates');
    }
    public static function phone()
    {
        return new Braintree_TextNode('phone');
    }
    public static function website()
    {
        return new Braintree_TextNode('website');
    }

    public static function creditCardExpirationDate()
    {
        return new Braintree_EqualityNode('credit_card_expiration_date');
    }
    public static function creditCardNumber()
    {
        return new Braintree_PartialMatchNode('credit_card_number');
    }

    public static function ids()
    {
        return new Braintree_MultipleValueNode('ids');
    }

    public static function createdAt()
    {
        return new Braintree_RangeNode("created_at");
    }
}
