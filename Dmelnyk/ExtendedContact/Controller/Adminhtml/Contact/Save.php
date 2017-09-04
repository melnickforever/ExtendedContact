<?php


namespace Dmelnyk\ExtendedContact\Controller\Adminhtml\Contact;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Mail\Template\TransportBuilder;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param TransportBuilder $transportBuilder
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        ScopeConfigInterface $scopeConfig,
        TransportBuilder $transportBuilder,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->scopeConfig = $scopeConfig;
        $this->transportBuilder = $transportBuilder;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            $model = $this->_objectManager->create('Dmelnyk\ExtendedContact\Model\Contact')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Contact no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $sendEmailToCustomer = ($model->getReaction() != $data['reaction']) ? true : false;
            $model->setData($data);

            try {
                $model->save();
                $contactSaveMessage = 'You saved the Contact.';
                if ($sendEmailToCustomer) {
                    $dataObject = new \Magento\Framework\DataObject();
                    $dataObject->setData(['reaction' => $model->getReaction()]);
                    $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                    $transport = $this->transportBuilder
                        ->setTemplateIdentifier(\Dmelnyk\ExtendedContact\Model\Contact::REACTION_EMAIL_TEMPLATE)
                        ->setTemplateOptions(
                            [
                                'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                            ]
                        )
                        ->setTemplateVars(['data' => $dataObject])
                        ->setFrom($this->scopeConfig->getValue(\Magento\Contact\Controller\Index::XML_PATH_EMAIL_SENDER, $storeScope))
                        ->addTo($model->getEmail())
                        ->setReplyTo($this->scopeConfig->getValue(\Magento\Contact\Controller\Index::XML_PATH_EMAIL_RECIPIENT, $storeScope))
                        ->getTransport();
                    $transport->sendMessage();
                    $contactSaveMessage = $contactSaveMessage . ' Email has been send to the customer.';

                }
                $this->messageManager->addSuccessMessage(__($contactSaveMessage));
                $this->dataPersistor->clear(\Dmelnyk\ExtendedContact\Model\Contact::EXTENDED_CONTACT);

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Contact.'));
            }

            $this->dataPersistor->set(\Dmelnyk\ExtendedContact\Model\Contact::EXTENDED_CONTACT, $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
