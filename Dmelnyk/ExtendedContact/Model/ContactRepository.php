<?php


namespace Dmelnyk\ExtendedContact\Model;

use Dmelnyk\ExtendedContact\Api\ContactRepositoryInterface;
use Dmelnyk\ExtendedContact\Api\Data\ContactSearchResultsInterfaceFactory;
use Dmelnyk\ExtendedContact\Api\Data\ContactInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Dmelnyk\ExtendedContact\Model\ResourceModel\Contact as ResourceContact;
use Dmelnyk\ExtendedContact\Model\ResourceModel\Contact\CollectionFactory as ContactCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class ContactRepository implements ContactRepositoryInterface
{

    protected $resource;

    protected $contactFactory;

    protected $contactCollectionFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $dataContactFactory;

    private $storeManager;


    /**
     * @param ResourceContact $resource
     * @param ContactFactory $contactFactory
     * @param ContactInterfaceFactory $dataContactFactory
     * @param ContactCollectionFactory $contactCollectionFactory
     * @param ContactSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceContact $resource,
        ContactFactory $contactFactory,
        ContactInterfaceFactory $dataContactFactory,
        ContactCollectionFactory $contactCollectionFactory,
        ContactSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->contactFactory = $contactFactory;
        $this->contactCollectionFactory = $contactCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataContactFactory = $dataContactFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Dmelnyk\ExtendedContact\Api\Data\ContactInterface $contact
    ) {
        /* if (empty($contact->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $contact->setStoreId($storeId);
        } */
        try {
            $contact->getResource()->save($contact);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the contact: %1',
                $exception->getMessage()
            ));
        }
        return $contact;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($contactId)
    {
        $contact = $this->contactFactory->create();
        $contact->getResource()->load($contact, $contactId);
        if (!$contact->getId()) {
            throw new NoSuchEntityException(__('Contact with id "%1" does not exist.', $contactId));
        }
        return $contact;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->contactCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Dmelnyk\ExtendedContact\Api\Data\ContactInterface $contact
    ) {
        try {
            $contact->getResource()->delete($contact);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Contact: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($contactId)
    {
        return $this->delete($this->getById($contactId));
    }
}
