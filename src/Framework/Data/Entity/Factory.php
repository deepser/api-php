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

namespace Deepser\Framework\Data\Entity;


class Factory
{
    protected $_className = null;

    public function __construct($className) {
        $this->_className = $className;
    }

    /**
     * @param \Deepser\Entity\AbstractEntity|null $className
     * @return \Deepser\Entity\AbstractEntity
     */
    public function create($className = null) {
        $reflection = new \ReflectionClass($className ? $className : $this->_className);
        return $reflection->newInstance();
    }
}