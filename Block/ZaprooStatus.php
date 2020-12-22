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
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
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

    public function getZaprooStatus() {
        $customerId = $this->_customerSession->getCustomer()->getId();
        $customer = $this->_customerRepository->getById($customerId);
        return $customer->getCustomAttribute('zaproo_status')->getValue();
    }
}
