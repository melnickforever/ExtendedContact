<?php


namespace Dmelnyk\ExtendedContact\Model\ResourceModel\Contact;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Dmelnyk\ExtendedContact\Model\Contact',
            'Dmelnyk\ExtendedContact\Model\ResourceModel\Contact'
        );
    }
}
