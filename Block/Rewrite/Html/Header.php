<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Funami\Zaproo\Block\Rewrite\Html;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Template;


/**
 * Html page header block
 *
 * @api
 * @since 100.0.2
 */
class Header extends \Magento\Framework\View\Element\Template
{

    protected $_customerSession;
    protected $_customerRepository;
    /**
     * Current template name
     *
     * @var string
     */
    protected $_template = 'Funami_Zaproo::html/header.phtml';


    public function __construct(
        CustomerSession $customerSession,
        CustomerRepositoryInterface $customerRepository,
        Template\Context $context,
        array $data = [])
    {
        $this->_customerSession = $customerSession;
        $this->_customerRepository = $customerRepository;
        parent::__construct($context, $data);
    }


    public function getZaprooStatus() {
        $customerId = $this->_customerSession->getCustomer()->getId();
        $customer =$this->_customerRepository->getById($customerId);
        return $customer->getCustomAttribute('zaproo_status')->getValue() ? "Yes" : "No";
    }

    /**
     * Retrieve welcome text
     *
     * @return string
     */
    public function getWelcome()
    {
        if (empty($this->_data['welcome'])) {
            $this->_data['welcome'] = $this->_scopeConfig->getValue(
                'design/header/welcome',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        return __($this->_data['welcome']);
    }
}
