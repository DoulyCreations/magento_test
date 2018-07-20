<?php

class Calcul_Expedition_Model_Resource_Expedition_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('calcul_expedition/expedition');
    }

}