<?php

namespace Dtn\ProductIngredient\Block;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Dtn\ProductIngredient\Model\IngredientFactory;

class Ingredient extends Template
{
	private $registry;

	private $stockRegistry;

	private $ingredientFactory;

	protected $_productCollectionFactory;

	protected $storeManager;

	public function __construct(
		Template\Context $context,
		Registry $registry,
		StockRegistryInterface $stockRegistry,
		CollectionFactory $productCollectionFactory,
		IngredientFactory $ingredientFactory,
		StoreManagerInterface $storeManager,
		array $data = []
	) {
		$this->registry = $registry;
		$this->stockRegistry = $stockRegistry;
		$this->_productCollectionFactory = $productCollectionFactory;
		$this->ingredientFactory = $ingredientFactory;
		$this->storeManager = $storeManager;
		parent::__construct($context, $data);
	}

	protected function getCurrentProduct()
	{
		return $this->registry->registry('product');
	}

	public function getListIngredient()
	{
		$product = $this->getCurrentProduct();
		$stock = $this->stockRegistry->getStockItem($product->getId());
		// return $stock->getId();

        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('entity_id',$stock->getId()); // fetching only 3 products
        return $collection;
	}

	public function getIngredientCollection()
	{
		$ingredient = $this->ingredientFactory->create()->getCollection();
		return $ingredient;
	}

	public function getUrlImage()
	{
	return	$this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ).'catalog/tmp/category/';
	}

}