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

namespace Deepser\Entity\Service;

use Deepser\Entity\AbstractEntity;

class Operation extends AbstractEntity
{
    const ENDPOINT = '/service/operation';
    const MULTIPLE_ENDPOINT = '/service/operations';
}