<?php
/**
 * A Magento 2 module named Funami/Zaproo
 * Copyright (C) 2019
 *
 * This file included in Funami/Zaproo is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Funami\Zaproo\Block;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Api\CustomerRepositoryInterface;

class ZaprooStatus extends \Magento\Framework\View\Element\Template
{
    protected $_customerSession;
    protected $_customerRepository;

    /**
     * ZaprooStatus constructor.
     * @param CustomerSession $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        CustomerSession $customerSession,
        CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->_customerRepository = $customerRepository;
        parent::__construct($context, $data);
    }

    /**
     * Gets zaproo_status attribute if customer is logged in
     *
     * @return mixed|string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getZaprooStatus() {
        $customerId = $this->_customerSession->getCustomer()->getId();
        if (!$customerId) {
            return 'fail';
        }
        $customer = $this->_customerRepository->getById($customerId);
        return $customer->getCustomAttribute('zaproo_status')->getValue();
    }
}
