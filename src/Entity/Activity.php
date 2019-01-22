<?php
/**
 * IntoDeep
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) IntoDeep Srl - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Serman Nerjaku <serman84@gmail.com>
 *
 * @category       Deep
 * @copyright      Copyright (c) 2019
 */

namespace DeepDesk\Entity;

class Activity extends AbstractEntity
{
    const ENDPOINT = '/activity';
    const MULTIPLE_ENDPOINT = '/activities';

    /**
     * @var null|AbstractEntity
     */
    protected $_entity = null;

    /**
     * @param $entity AbstractEntity
     * @return $this
     */
    public function setEntity($entity){
        $this->_entity = $entity;
        return $this;
    }

    /**
     * @return AbstractEntity|null
     */
    public function getEntity(){
        return $this->_entity;
    }

    public function getEndpoint(){
        return trim($this->getEntity()->getEndpoint(), '/') . '/' . $this->getEntity()->getId() . static::ENDPOINT;
    }

    public function getMultipleEndpoint(){
        return trim($this->getEntity()->getEndpoint(), '/') . '/' . $this->getEntity()->getId() . static::MULTIPLE_ENDPOINT;
    }
}