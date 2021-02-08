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

namespace Deepser\Entity\Cmdb;


use Deepser\Entity\AbstractEntity;

class Ci extends AbstractEntity
{
    const ENDPOINT = '/cmdb/ci';
    const MULTIPLE_ENDPOINT = '/cmdb/cis';
}