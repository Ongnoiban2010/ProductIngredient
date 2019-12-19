<?php

namespace Dtn\ProductIngredient\Controller\Adminhtml\Ingredient;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected $coreRegistry;

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->_objectManager->create('Dtn\ProductIngredient\Model\Ingredient');

        $registryObject = $this->_objectManager->get('Magento\Framework\Registry');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Ingredient no longer exists.'));
                // $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dtn_ProductIngredient::ingredient')
            ->addBreadcrumb(
                $id ? __('Edit Ingredient') : __('New Ingredient'),
                $id ? __('Edit Ingredient') : __('New Ingredient')
            );
        $resultPage->getConfig()->getTitle()->prepend(__('Ingredient'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Ingredient'));
        return $resultPage;
    }
}