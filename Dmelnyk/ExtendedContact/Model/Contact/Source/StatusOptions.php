<?php
namespace Dmelnyk\ExtendedContact\Model\Contact\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class IsActive
 */
class StatusOptions implements OptionSourceInterface
{
    /**
     * @var \Magento\Cms\Model\Block
     */
    protected $extendedContact;

    /**
     * Constructor
     *
     * @param \Magento\Cms\Model\Block $cmsBlock
     */
    public function __construct(\Dmelnyk\ExtendedContact\Model\Contact $extendedContact)
    {
        $this->extendedContact = $extendedContact;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->extendedContact->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
