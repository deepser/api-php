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


use Deepser\Framework\DataObject;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class GuzzleHttpAdapter implements AdapterInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;
    /**
     * @var Response
     */
    protected $response;

    protected $host;
    /**
     * @param string               $token
     * @param ClientInterface|null $client
     */
    public function __construct($host, ClientInterface $client = null)
    {
        $this->host = trim($host, '/');
        $this->client = $client ?: new Client();
    }

    public function getHost(){
        return $this->host . static::API_PATH;
    }

    /**
     * {@inheritdoc}
     */
    public function get($url)
    {
        try {
            $this->response = $this->client->get($url);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }
        return (string)$this->response->getBody();
    }
    /**
     * {@inheritdoc}
     */
    public function delete($url)
    {
        try {
            $this->response = $this->client->delete($url);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function put($url, $content = '')
    {
        $options = [];
        $options[is_array($content) ? 'json' : 'body'] = $content;
        $options['allow_redirects'] = false;
        try {
            $this->response = $this->client->put($url, $options);
        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }
        return (string)$this->response->getBody();
    }
    /**
     * {@inheritdoc}
     */
    public function post($url, $content = '')
    {
        $options = [];
        $options[is_array($content) ? 'json' : 'body'] = $content;
        $options['allow_redirects'] = false;
        try {
            $this->response = $this->client->post($url, $options);

        } catch (RequestException $e) {
            $this->response = $e->getResponse();
            $this->handleError();
        }
        return (string)$this->response->getBody();
    }
    /**
     * {@inheritdoc}
     */
    public function getLatestResponseHeaders()
    {
        if (null === $this->response) {
            return null;
        }
        return [
            'reset' => (int) (string) $this->response->getHeader('RateLimit-Reset'),
            'remaining' => (int) (string) $this->response->getHeader('RateLimit-Remaining'),
            'limit' => (int) (string) $this->response->getHeader('RateLimit-Limit'),
        ];
    }
    /**
     * @throws HttpException
     */
    protected function handleError()
    {
        $body = (string) $this->response->getBody();
        $code = (int) $this->response->getStatusCode();
        $content = new DataObject(json_decode($body, true));

        $msg = 'Request not processed';
        $code = 0;
        if($content->getMessages() && is_array($content->getMessages())){
            if(array_key_exists('error', $content->getMessages())){
                $errors = $content->getMessages()['error'];
                foreach ($errors as $error){
                    $msg = $error['message'];
                    $code = $error['code'];
                }
            }
        }
        throw new \Exception($msg, $code);
    }

}