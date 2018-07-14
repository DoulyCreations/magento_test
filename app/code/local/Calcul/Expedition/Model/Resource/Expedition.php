<?php

class Calcul_Expedition_Model_Resource_Expedition extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('calcul_expedition/expedition', 'expedition_id');
    }
}