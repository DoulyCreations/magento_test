<?php

class Calcul_Expedition_IndexController extends Mage_Core_Controller_Front_Action
{
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

    public function confirmAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}