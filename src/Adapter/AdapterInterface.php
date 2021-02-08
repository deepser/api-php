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

namespace Deepser\Adapter;


interface AdapterInterface
{

    const API_PATH = '/api/rest/';
    /**
     * @param string $url
     *
     * @throws \Exception
     *
     * @return string
     */
    public function get($url);
    /**
     * @param string $url
     *
     * @throws \Exception
     */
    public function delete($url);
    /**
     * @param string       $url
     * @param array|string $content
     *
     * @throws \Exception
     *
     * @return string
     */
    public function put($url, $content = '');
    /**
     * @param string       $url
     * @param array|string $content
     *
     * @throws \Exception
     *
     * @return string
     */
    public function post($url, $content = '');
    /**
     * @return array|null
     */
    public function getLatestResponseHeaders();

    /**
     * @return string
     */
    public function getHost();
}