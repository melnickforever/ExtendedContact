<?php


namespace Dmelnyk\ExtendedContact\Api\Data;

interface ContactInterface
{

    const ENTITY_ID = 'entity_id';
    
    /**
     * Get entity_id
     * @return string|null
     */
    
    public function getEntityId();

    /**
     * Set entity_id
     * @param string $entity_id
     * @return \Dmelnyk\ExtendedContact\Api\Data\ContactInterface
     */
    
    public function setEntityId($entity_id);
}
