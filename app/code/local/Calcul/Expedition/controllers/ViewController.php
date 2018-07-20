<?php

class Calcul_Expedition_ViewController extends Mage_Core_Controller_Front_Action
{
    /**
     * @throws Exception
     *
     * http://dev.benoit/expedition/view
     */
    public function indexAction()
    {
        $this->loadLayout();

        /** @var Calcul_Expedition_Model_Expedition $oModelExpedition */
        $oModelExpedition = Mage::getModel('calcul_expedition/Expedition');
        $oModelOrder = Mage::getModel('sales/order');

        /** @var Calcul_Expedition_Model_Resource_Expedition_Collection $oCollection */
        $oCollection = $oModelExpedition->getCollection();
        $aDatas = $oCollection->getData();

        /** @var Mage_Core_Block_Template $oBlock */
        $oBlock = $this->getLayout()->getBlock('list_expedition');

        if(!$oBlock) {
            // TODO : A ne faire qu'en dev...
            throw new Exception('Error initialize block');
        }

        $oBlock->setData('data_list', $aDatas);

        // Test si une date est passée en paramètre :
        if ($this->getRequest()->getParam('date')) {
            $oCollectionFiltered = $oModelExpedition->getCollection();
            $oCollectionFiltered->addFilter('date_expedition', $this->getRequest()->getParam('date'));
            $aDatas = $oCollectionFiltered->getData();
            $aDatasFiltered = null;

            foreach ($aDatas as $aData) {
                $oOrder = $oModelOrder->load($aData['order_id']);

                $aDatasFiltered[] = [
                    'a_expedition' => $aData,
                    'o_order' => $oOrder
                ];
            }

            $oBlock->setData('order_list_by_expedition', $aDatasFiltered);
        }

        $this->renderLayout();
    }
}
