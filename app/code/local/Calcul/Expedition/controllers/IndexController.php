<?php

class Calcul_Expedition_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * @throws Exception
     *
     * http://dev.benoit/expedition
     */
    public function indexAction()
    {
        $this->loadLayout();
        if ($this->getRequest()->isPost()) {
            // Bien préciser le "/" au début
            $this->_redirectUrl('/expedition/index/confirm');
        }
        $this->renderLayout();
    }

    /**
     * http://dev.benoit/expedition/index/confirm
     */
    public function confirmAction()
    {
        $this->loadLayout();

        /*$expedition = Mage::getModel('calcul_expedition/Expedition');
        $expedition->setData('date_expedition', date('Y-m-d'));
        $expedition->save();*/

        $this->renderLayout();
    }

    /**
     * @throws Exception
     *
     * http://dev.benoit/expedition/index/updateDateExpedition
     */
    public function updateDateExpeditionAction()
    {
        $postData = $this->getRequest()->getParams();
        //$bRightAction = Mage::getSingleton('admin/session')->isAllowed('admin/sales/order/calcul_expedition');
        $bRightAction = true;

        if (!$postData || !$bRightAction) {
            json_encode(['status' => 'error']);
        }

        $sDate = $postData['date'];
        $sParamOrderId = $postData['order_id'];

        if ($sDate && $sParamOrderId) {
            $oModelExpedition = Mage::getModel('calcul_expedition/Expedition');

            $oExpedition = $oModelExpedition->load($sParamOrderId, 'order_id');

            if ($oExpedition->getData('order_id')) {
                // Update
                $oExpedition->setData('date_expedition', $sDate);
            } else {
                // Insert
                $oExpedition = $oModelExpedition;
                $oExpedition->setData('date_expedition', $sDate);
                $oExpedition->setData('order_id', $sParamOrderId);
            }

            if($oExpedition->save()) {
                $this->getResponse()->setHeader('Content-type', 'application/json');
                $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(['status' => 'success']));
            }
        }
    }
}
