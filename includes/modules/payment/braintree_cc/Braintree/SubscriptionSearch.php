<?php
class Braintree_SubscriptionSearch
{
    public static function billingCyclesRemaining()
    {
        return new Braintree_RangeNode('billing_cycles_remaining');
    }

    public static function daysPastDue()
    {
        return new Braintree_RangeNode('days_past_due');
    }

    public static function id()
    {
        return new Braintree_TextNode('id');
    }

    public static function inTrialPeriod()
    {
        return new Braintree_MultipleValueNode('in_trial_period', array(true, false));
    }

    public static function merchantAccountId()
    {
        return new Braintree_MultipleValueNode('merchant_account_id');
    }

    public static function nextBillingDate()
    {
        return new Braintree_RangeNode('next_billing_date');
    }

    public static function planId()
    {
        return new Braintree_MultipleValueOrTextNode('plan_id');
    }

    public static function price()
    {
        return new Braintree_RangeNode('price');
    }

    public static function status()
    {
        return new Braintree_MultipleValueNode("status", array(
            Braintree_Subscription::ACTIVE,
            Braintree_Subscription::CANCELED,
            Braintree_Subscription::EXPIRED,
            Braintree_Subscription::PAST_DUE,
            Braintree_Subscription::PENDING
        ));
    }

    public static function transactionId()
    {
        return new Braintree_TextNode('transaction_id');
    }

    public static function ids()
    {
        return new Braintree_MultipleValueNode('ids');
    }
}
