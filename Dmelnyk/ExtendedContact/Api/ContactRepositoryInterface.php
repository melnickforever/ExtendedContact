<?php


namespace Dmelnyk\ExtendedContact\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ContactRepositoryInterface
{


    /**
     * Save Contact
     * @param \Dmelnyk\ExtendedContact\Api\Data\ContactInterface $contact
     * @return \Dmelnyk\ExtendedContact\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \Dmelnyk\ExtendedContact\Api\Data\ContactInterface $contact
    );

    /**
     * Retrieve Contact
     * @param string $contactId
     * @return \Dmelnyk\ExtendedContact\Api\Data\ContactInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($contactId);

    /**
     * Retrieve Contact matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Dmelnyk\ExtendedContact\Api\Data\ContactSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Contact
     * @param \Dmelnyk\ExtendedContact\Api\Data\ContactInterface $contact
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \Dmelnyk\ExtendedContact\Api\Data\ContactInterface $contact
    );

    /**
     * Delete Contact by ID
     * @param string $contactId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($contactId);
}
