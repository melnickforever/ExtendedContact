<?php

namespace Dmelnyk\ExtendedContact\Block\Adminhtml\Contact\Edit\Tab;

use Magento\Framework\Registry;

/**
 * Class Stock
 * @package Magestore\InventorySuccess\Block\Adminhtml\Warehouse\Edit\Tab
 */
class ContactInfo extends \Magento\Backend\Block\Template
{
    protected $_template = 'Dmelnyk_ExtendedContact::contact/edit/tab/contactInfo.phtml';
    /**
     * @var Registry
     */
    protected $registry;
    protected $model;

    public function __construct(\Magento\Backend\Block\Template\Context $context,
                                Registry $registry,
                                array $data = []
    )
    {
        $this->registry = $registry;
        $this->model = $this->registry->registry(\Dmelnyk\ExtendedContact\Model\Contact::EXTENDED_CONTACT);
        parent::__construct($context, $data);
    }

    public function getName()
    {
        return $this->model->getName();
    }

    public function hasName()
    {
        return $this->model->hasName();
    }

    public function getEmail()
    {
        return $this->model->getEmail();
    }

    public function hasEmail()
    {
        return $this->model->hasEmail();
    }

    public function getPhone()
    {
        return $this->model->getPhone();
    }

    public function hasPhone()
    {
        return $this->model->hasPhone();
    }

    public function getsubject()
    {
        return $this->model->getSubject();
    }

    public function hasSubject()
    {
        return $this->model->hasSubject();
    }

    public function getMessage()
    {
        return $this->model->getMessage();
    }

    public function hasMessage()
    {
        return $this->model->hasMessage();
    }

    public function getCreatedAt()
    {
        return $this->model->getCreatedAt();
    }

    public function hasCreatedAt()
    {
        return $this->model->hasCreatedAt();
    }

}
