<?php
namespace South\CustomAddressForm\Observer;

use Magento\Framework\Exception\NoSuchEntityException;

class SaveAddressClassificationInOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Customer\Api\AddressRepositoryInterface
     */
    private $addressRepository;

    public function __construct(
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
    )
    {
        $this->addressRepository = $addressRepository;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        if ($quote->getBillingAddress()) {
            $addressClassificationInBilling = $quote->getBillingAddress()->getExtensionAttributes()->getAddressClassification();
            $order->getBillingAddress()->setAddressClassification($addressClassificationInBilling);

            try {
                $customerAddressId = $order->getBillingAddress()->getCustomerAddressId();
                if ($customerAddressId) {
                    $address = $this->addressRepository->getById($customerAddressId);
                    $address->setCustomAttribute('address_classification', $addressClassificationInBilling);
                    $this->addressRepository->save($address);
                }
            } catch (NoSuchEntityException $e) {

            }
        }

        if (!$quote->isVirtual()) {
            $addressClassificationInShipping = $quote->getShippingAddress()->getAddressClassification();
            $order->getShippingAddress()->setAddressClassification($addressClassificationInShipping);

            try {
                $customerAddressId = $order->getShippingAddress()->getCustomerAddressId();
                if ($customerAddressId) {
                    $address = $this->addressRepository->getById($customerAddressId);
                    $address->setCustomAttribute('address_classification', $addressClassificationInShipping);
                    $this->addressRepository->save($address);
                }
            } catch (NoSuchEntityException $e) {

            }
        }
        $order->save();
        return $this;
    }
}
