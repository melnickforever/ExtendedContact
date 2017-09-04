<?php


namespace Dmelnyk\ExtendedContact\Api\Data;

interface ContactSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Contact list.
     * @return \Dmelnyk\ExtendedContact\Api\Data\ContactInterface[]
     */
    
    public function getItems();

    /**
     * Set entity_id list.
     * @param \Dmelnyk\ExtendedContact\Api\Data\ContactInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
