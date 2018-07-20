<?php

class Calcul_Expedition_Adminhtml_CreativesController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @throws Exception
     */
    public function indexAction()
    {
        $this->loadLayout();

        /** @var Mage_Core_Block_Template $oBlock */
        $oBlock = $this->getLayout()->getBlock('list_expedition');

        if(!$oBlock) {
            // TODO : A ne faire qu'en dev...
            throw new Exception('Error initialize block');
        }

        $aDatas = $this->getListDatesExpeditions();

        $oBlock->setData('data_list_dates', $aDatas);

        // Test si une date est passée en paramètre :
        if ($this->getRequest()->getParam('date')) {
            $aDatasFiltered = $this->getListOrdersByDateExpedition($this->getRequest()->getParam('date'));
            $oBlock->setData('data_list', $aDatasFiltered);
            //order_list_by_expedition
        }

        $this->renderLayout();
    }

    /**
     * @throws Exception
     */
    public function todayAction()
    {
        $this->loadLayout();

        /** @var Mage_Core_Block_Template $oBlock */
        $oBlock = $this->getLayout()->getBlock('list_expedition');

        if(!$oBlock) {
            // TODO : A ne faire qu'en dev...
            throw new Exception('Error initialize block');
        }

        $sDate = date('Y-m-d');
        $aDatas = $this->getListOrdersByDateExpedition($sDate);

        $oBlock->setData('data_list', $aDatas);
        $oBlock->setData('choose_date', $sDate);

        $this->renderLayout();
    }

    /**
     * @throws Exception
     */
    public function yesterdayAction()
    {
        $this->loadLayout();

        /** @var Mage_Core_Block_Template $oBlock */
        $oBlock = $this->getLayout()->getBlock('list_expedition');

        if(!$oBlock) {
            // TODO : A ne faire qu'en dev...
            throw new Exception('Error initialize block');
        }

        $sDate = strftime("%Y-%m-%d", mktime(0, 0, 0, date('m'), date('d')-1, date('y')));

        $aDatas = $this->getListOrdersByDateExpedition($sDate);

        $oBlock->setData('data_list', $aDatas);
        $oBlock->setData('choose_date', $sDate);

        $this->renderLayout();
    }

    /**
     * TODO : A mettre en Helper ?
     *
     * @return array
     */
    private function getListDatesExpeditions()
    {
        /** @var Calcul_Expedition_Model_Expedition $oModelExpedition */
        $oModelExpedition = Mage::getModel('calcul_expedition/Expedition');

        /** @var Calcul_Expedition_Model_Resource_Expedition_Collection $oCollection */
        $oCollection = $oModelExpedition->getCollection();
        $aDatas = $oCollection->getData();

        return $aDatas;
    }

    /**
     * TODO : A mettre en Helper ?
     *
     * @param $sDate string
     * @return array|null
     */
    private function getListOrdersByDateExpedition($sDate)
    {
        /** @var Calcul_Expedition_Model_Expedition $oModelExpedition */
        $oModelExpedition = Mage::getModel('calcul_expedition/Expedition');
        $oModelOrder = Mage::getModel('sales/order');

        $oCollectionFiltered = $oModelExpedition->getCollection();
        $oCollectionFiltered->addFilter('date_expedition', $sDate);
        $aDatas = $oCollectionFiltered->getData();
        $aDatasFiltered = null;

        foreach ($aDatas as $aData) {
            $oOrder = $oModelOrder->load($aData['order_id']);

            $aDatasFiltered[] = [
                'a_expedition' => $aData,
                'o_order' => $oOrder
            ];
        }

        return $aDatasFiltered;
    }
}
