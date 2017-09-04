<?php


namespace Dmelnyk\ExtendedContact\Model;

use Dmelnyk\ExtendedContact\Api\Data\ContactInterface;

class Contact extends \Magento\Framework\Model\AbstractModel implements ContactInterface
{
    const STATUS_NEW = 0;
    const STATUS_ANSWERED = 1;
    const EXTENDED_CONTACT = 'dmelnyk_extendedcontact_contact';
    const REACTION_EMAIL_TEMPLATE = 'dmelnyk_extended_contact_reaction_email_template';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Dmelnyk\ExtendedContact\Model\ResourceModel\Contact');
    }


    /**
     * Get entity_id
     * @return string
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set entity_id
     * @param string $entity_id
     * @return \Dmelnyk\ExtendedContact\Api\Data\ContactInterface
     */
    public function setEntityId($entity_id)
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_NEW => __('New'), self::STATUS_ANSWERED => __('Answered')];
    }

}
