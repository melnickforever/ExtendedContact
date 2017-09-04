<?php


namespace Dmelnyk\ExtendedContact\Model\ResourceModel;

class Contact extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('extended_contact_message_entity', 'entity_id');
    }
}
