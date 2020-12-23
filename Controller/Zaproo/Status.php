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

namespace Funami\Zaproo\Controller\Zaproo;

use Magento\Customer\Model\Session as CustomerSession;

class Status extends \Magento\Framework\App\Action\Action
{

    protected $resultPageFactory;
    protected $_customerSession;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        CustomerSession $customerSession,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_customerSession = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action. Or redirect if customer is not logged in.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $customerId = $this->_customerSession->getCustomer()->getId();
        if (!$customerId) {
            $this->_redirect('customer/account/login');
        }
        return $this->resultPageFactory->create();
    }
}
