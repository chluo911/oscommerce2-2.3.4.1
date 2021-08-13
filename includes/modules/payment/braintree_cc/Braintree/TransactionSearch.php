<?php
class Braintree_TransactionSearch
{
    public static function billingCompany()
    {
        return new Braintree_TextNode('billing_company');
    }
    public static function billingCountryName()
    {
        return new Braintree_TextNode('billing_country_name');
    }
    public static function billingExtendedAddress()
    {
        return new Braintree_TextNode('billing_extended_address');
    }
    public static function billingFirstName()
    {
        return new Braintree_TextNode('billing_first_name');
    }
    public static function billingLastName()
    {
        return new Braintree_TextNode('billing_last_name');
    }
    public static function billingLocality()
    {
        return new Braintree_TextNode('billing_locality');
    }
    public static function billingPostalCode()
    {
        return new Braintree_TextNode('billing_postal_code');
    }
    public static function billingRegion()
    {
        return new Braintree_TextNode('billing_region');
    }
    public static function billingStreetAddress()
    {
        return new Braintree_TextNode('billing_street_address');
    }
    public static function creditCardCardholderName()
    {
        return new Braintree_TextNode('credit_card_cardholderName');
    }
    public static function customerCompany()
    {
        return new Braintree_TextNode('customer_company');
    }
    public static function customerEmail()
    {
        return new Braintree_TextNode('customer_email');
    }
    public static function customerFax()
    {
        return new Braintree_TextNode('customer_fax');
    }
    public static function customerFirstName()
    {
        return new Braintree_TextNode('customer_first_name');
    }
    public static function customerId()
    {
        return new Braintree_TextNode('customer_id');
    }
    public static function customerLastName()
    {
        return new Braintree_TextNode('customer_last_name');
    }
    public static function customerPhone()
    {
        return new Braintree_TextNode('customer_phone');
    }
    public static function customerWebsite()
    {
        return new Braintree_TextNode('customer_website');
    }
    public static function id()
    {
        return new Braintree_TextNode('id');
    }
    public static function ids()
    {
        return new Braintree_MultipleValueNode('ids');
    }
    public static function orderId()
    {
        return new Braintree_TextNode('order_id');
    }
    public static function paymentMethodToken()
    {
        return new Braintree_TextNode('payment_method_token');
    }
    public static function processorAuthorizationCode()
    {
        return new Braintree_TextNode('processor_authorization_code');
    }
    public static function settlementBatchId()
    {
        return new Braintree_TextNode('settlement_batch_id');
    }
    public static function shippingCompany()
    {
        return new Braintree_TextNode('shipping_company');
    }
    public static function shippingCountryName()
    {
        return new Braintree_TextNode('shipping_country_name');
    }
    public static function shippingExtendedAddress()
    {
        return new Braintree_TextNode('shipping_extended_address');
    }
    public static function shippingFirstName()
    {
        return new Braintree_TextNode('shipping_first_name');
    }
    public static function shippingLastName()
    {
        return new Braintree_TextNode('shipping_last_name');
    }
    public static function shippingLocality()
    {
        return new Braintree_TextNode('shipping_locality');
    }
    public static function shippingPostalCode()
    {
        return new Braintree_TextNode('shipping_postal_code');
    }
    public static function shippingRegion()
    {
        return new Braintree_TextNode('shipping_region');
    }
    public static function shippingStreetAddress()
    {
        return new Braintree_TextNode('shipping_street_address');
    }

    public static function creditCardExpirationDate()
    {
        return new Braintree_EqualityNode('credit_card_expiration_date');
    }

    public static function creditCardNumber()
    {
        return new Braintree_PartialMatchNode('credit_card_number');
    }

    public static function refund()
    {
        return new Braintree_KeyValueNode("refund");
    }

    public static function amount()
    {
        return new Braintree_RangeNode("amount");
    }
    public static function authorizedAt()
    {
        return new Braintree_RangeNode("authorizedAt");
    }
    public static function authorizationExpiredAt()
    {
        return new Braintree_RangeNode("authorizationExpiredAt");
    }
    public static function createdAt()
    {
        return new Braintree_RangeNode("createdAt");
    }
    public static function failedAt()
    {
        return new Braintree_RangeNode("failedAt");
    }
    public static function gatewayRejectedAt()
    {
        return new Braintree_RangeNode("gatewayRejectedAt");
    }
    public static function processorDeclinedAt()
    {
        return new Braintree_RangeNode("processorDeclinedAt");
    }
    public static function settledAt()
    {
        return new Braintree_RangeNode("settledAt");
    }
    public static function submittedForSettlementAt()
    {
        return new Braintree_RangeNode("submittedForSettlementAt");
    }
    public static function voidedAt()
    {
        return new Braintree_RangeNode("voidedAt");
    }
    public static function disbursementDate()
    {
        return new Braintree_RangeNode("disbursementDate");
    }
    public static function disputeDate()
    {
        return new Braintree_RangeNode("disputeDate");
    }

    public static function merchantAccountId()
    {
        return new Braintree_MultipleValueNode("merchant_account_id");
    }

    public static function createdUsing()
    {
        return new Braintree_MultipleValueNode("created_using", array(
            Braintree_Transaction::FULL_INFORMATION,
            Braintree_Transaction::TOKEN
        ));
    }

    public static function creditCardCardType()
    {
        return new Braintree_MultipleValueNode("credit_card_card_type", array(
            Braintree_CreditCard::AMEX,
            Braintree_CreditCard::CARTE_BLANCHE,
            Braintree_CreditCard::CHINA_UNION_PAY,
            Braintree_CreditCard::DINERS_CLUB_INTERNATIONAL,
            Braintree_CreditCard::DISCOVER,
            Braintree_CreditCard::JCB,
            Braintree_CreditCard::LASER,
            Braintree_CreditCard::MAESTRO,
            Braintree_CreditCard::MASTER_CARD,
            Braintree_CreditCard::SOLO,
            Braintree_CreditCard::SWITCH_TYPE,
            Braintree_CreditCard::VISA,
            Braintree_CreditCard::UNKNOWN
        ));
    }

    public static function creditCardCustomerLocation()
    {
        return new Braintree_MultipleValueNode("credit_card_customer_location", array(
            Braintree_CreditCard::INTERNATIONAL,
            Braintree_CreditCard::US
        ));
    }

    public static function source()
    {
        return new Braintree_MultipleValueNode("source", array(
            Braintree_Transaction::API,
            Braintree_Transaction::CONTROL_PANEL,
            Braintree_Transaction::RECURRING,
        ));
    }

    public static function status()
    {
        return new Braintree_MultipleValueNode("status", array(
            Braintree_Transaction::AUTHORIZATION_EXPIRED,
            Braintree_Transaction::AUTHORIZING,
            Braintree_Transaction::AUTHORIZED,
            Braintree_Transaction::GATEWAY_REJECTED,
            Braintree_Transaction::FAILED,
            Braintree_Transaction::PROCESSOR_DECLINED,
            Braintree_Transaction::SETTLED,
            Braintree_Transaction::SETTLING,
            Braintree_Transaction::SUBMITTED_FOR_SETTLEMENT,
            Braintree_Transaction::VOIDED
        ));
    }

    public static function type()
    {
        return new Braintree_MultipleValueNode("type", array(
            Braintree_Transaction::SALE,
            Braintree_Transaction::CREDIT
        ));
    }
}
