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
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\State\InputMismatchException;

class Save extends \Magento\Framework\App\Action\Action
{

    protected $_customerSession;
    protected $_customerRepository;
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Action\Context  $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        CustomerSession $customerSession,
        CustomerRepositoryInterface $customerRepository,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->_customerSession = $customerSession;
        $this->_customerRepository = $customerRepository;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $params = $this->_request->getParams();
        $paramsBinary = $params['zaproo'] == "yes" ? 1 : 0;
        $customerId = $this->_customerSession->getCustomer()->getId();
        try{
            $customer = $this->_customerRepository->getById($customerId);
        } catch (NoSuchEntityException $e) {

            $this->messageManager->addExceptionMessage($e);
            $this->_redirect('customer/account/login');
        } catch (LocalizedException $e) {
        }
        $customer->setCustomAttribute('zaproo_status', $paramsBinary);
        try {
            $this->_customerRepository->save($customer);
            $this->messageManager->addSuccessMessage("Zaproo status saved");
            $this->_redirect('funami/zaproo/status');

        } catch (InputException $e) {
            $this->messageManager->addExceptionMessage($e);
            $this->_redirect('/');

        }
//        return $this->resultPageFactory->create();
    }
}
