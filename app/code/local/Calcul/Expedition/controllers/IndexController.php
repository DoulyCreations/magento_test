<?php

class Calcul_Expedition_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * @throws Exception
     *
     * http://localhost/magento/expedition
     */
    public function indexAction()
    {
        $this->loadLayout();
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getParams();
            $email = $postData['email'];
            $message = $postData['message'];
            $subject = "Nouveau message de la part de $email !";
            $to = 'b.decoster@douly.fr';
            if (mail($to, $subject, $message)) {
                $this->_redirectUrl('index/confirm');
            }
        }
        $this->renderLayout();
    }

    /**
     * http://localhost/magento/expedition/index/confirm
     */
    public function confirmAction()
    {
        $this->loadLayout();

        $expedition = Mage::getModel('calcul_expedition/Expedition');
        $expedition->setData('date_expedition', date('Y-m-d'));
        $expedition->save();

        $this->renderLayout();
    }
}
