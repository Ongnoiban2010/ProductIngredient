<?php

namespace Dtn\ProductIngredient\Model\Config\Source;

use Dtn\ProductIngredient\Model\ResourceModel\Ingredient\CollectionFactory;
use Magento\Backend\App\Action\Context;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Multiselect extends AbstractSource implements \Magento\Framework\Option\ArrayInterface 
{
	private $collectionFactory;

	public function __construct(
		CollectionFactory $collectionFactory
	) {
		$this->collectionFactory = $collectionFactory;
	}
	
	protected $optionFactory;

	public function getAllOptions()
	{
		$collection = $this->collectionFactory->create();
		$this->_options = [];
		foreach ($collection as $col) {
			$this->_options[] = [
				'label' => $col->getName(),
				'value' => $col->getId()
			];
		}
		return $this->_options;
	}
}