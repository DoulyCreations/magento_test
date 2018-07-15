<?php

class Calcul_Expeditionadmin_IndexController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @throws Exception
     *
     * http://localhost/magento/expedition
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}
