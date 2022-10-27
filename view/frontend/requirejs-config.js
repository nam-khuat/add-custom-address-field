var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-billing-address': {
                'South_CustomAddressForm/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/set-shipping-information': {
                'South_CustomAddressForm/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'South_CustomAddressForm/js/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'South_CustomAddressForm/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'South_CustomAddressForm/js/action/set-billing-address-mixin': true
            }
        }
    }
};
