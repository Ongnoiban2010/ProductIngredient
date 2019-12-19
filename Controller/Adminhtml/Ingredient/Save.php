<?php

namespace Dtn\ProductIngredient\Controller\Adminhtml\Ingredient;

use Dtn\ProductIngredient\Model\IngredientFactory;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Dtn\ProductLabel\Model\Uploader;
use Dtn\ProductLabel\Model\UploaderPool;

class Save extends \Magento\Backend\App\Action  implements HttpPostActionInterface
{
    private $ingredientFactory;

    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        IngredientFactory $ingredientFactory
    ) {
        $this->ingredientFactory = $ingredientFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id');
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }
        if ($id)
        {
            $model = $this->ingredientFactory->create()->load($id);
        } else {
            $model = $this->ingredientFactory->create();
        }
        $data = $this->_filterFoodData($data);
        $model->setName($data['name'])
        ->setImage($data['image'])
        ->setDescription($data['description'])
        ->save();
        $this->messageManager->addSuccessMessage(__('You save the ingredient.'));
        return $resultRedirect->setPath('*/*/');
    }

    public function _filterFoodData(array $rawData)
    {
        //Replace icon with fileuploader field name
        $data = $rawData;
        if (isset($data['image'][0]['name'])) {
            $data['image'] = $data['image'][0]['name'];
        } else {
            $data['image'] = null;
        }
        return $data;
    }
}