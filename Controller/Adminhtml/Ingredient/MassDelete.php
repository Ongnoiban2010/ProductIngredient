<?php

namespace Dtn\ProductIngredient\Controller\Adminhtml\Ingredient;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Dtn\ProductIngredient\Model\ResourceModel\Ingredient\CollectionFactory;

class MassDelete extends Action
{
	protected $filter;

	protected $collectionFactory;

	public function __construct(
		Context $context,
		Filter $filter,
		CollectionFactory $collectionFactory
	) {
		$this->filter = $filter;
		$this->collectionFactory = $collectionFactory;
		parent::__construct($context);
	}

	public function execute()
	{
		$collection = $this->filter->getCollection($this->collectionFactory->create());
		$collectionSize = $collection->getSize();
		foreach ($collection as $item) {
			$item->delete();
		}
		$this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
		 $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
	}
}