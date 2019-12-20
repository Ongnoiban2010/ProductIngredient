<?php

namespace Dtn\ProductIngredient\Model\Ingredient;

use Dtn\ProductIngredient\Model\ResourceModel\Ingredient\CollectionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    protected $collection;

    protected $dataPersistor;

    protected $loadedData;

    private $auth;

    private $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $labelCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        ?AuthorizationInterface $auth = null,
        StoreManagerInterface $storeManager
    ) {
        $this->collection = $labelCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->auth = $auth ?? ObjectManager::getInstance()->get(AuthorizationInterface::class);
        $this->meta = $this->prepareMeta($this->meta);
        $this->storeManager = $storeManager;
    }

    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $ingredient) {
            $this->loadedData[$ingredient->getId()] = $ingredient->getData();
            if ($ingredient->getImage()) {
                $m['image'][0]['name'] = $ingredient->getImage();
                $m['image'][0]['url'] = $this->getMediaUrl().$ingredient->getImage();
                $fullData = $this->loadedData;
                $this->loadedData[$ingredient->getId()] = array_merge($fullData[$ingredient->getId()], $m);
            }
        }
        $data = $this->dataPersistor->get('dtn_productingredient_ingredient');
        if (!empty($data)) {
            $ingredient = $this->collection->getNewEmptyItem();
            $ingredient->setData($data);
            $this->loadedData[$ingredient->getId()] = $ingredient->getData();
            $this->dataPersistor->clear('dtn_productingredient_ingredient');
        }

        return $this->loadedData;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();

        if (!$this->auth->isAllowed('Dtn_ProductIngredient::ingredient')) {
            $designMeta = [
                'design' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'disabled' => true
                            ]
                        ]
                    ]
                ],
                'custom_design_update' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'disabled' => true
                            ]
                        ]
                    ]
                ]
            ];
            $meta = array_merge_recursive($meta, $designMeta);
        }

        return $meta;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'catalog/tmp/category/';
        return $mediaUrl;
    }
}