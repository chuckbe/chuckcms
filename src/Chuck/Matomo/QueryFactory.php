<?php

namespace Chuckbe\Chuckcms\Chuck\Matomo;

use GuzzleHttp\Client;

class QueryFactory implements QueryFactoryInterface
{
    /**
     * Associative array of default parameters, keyed by parameter name.
     *
     * @var array
     */
    protected $defaultParameters;

    /**
     * The URL of the Matomo server.
     *
     * @var string
     */
    protected $url;

    /**
     * The HTTP client.
     *
     * @var \Chuckbe\Chuckcms\Chuck\Matomo\HttpClient
     */
    protected $httpClient;

    /**
     * Constructs a new QueryFactory.
     *
     * @param string             $url
     *                                       The URL of the Matomo server.
     * @param \GuzzleHttp\Client $httpClient
     *                                       The Guzzle HTTP client.
     */
    public function __construct($url, Client $httpClient)
    {
        $this->url = $url;
        $this->httpClient = new HttpClient($httpClient, new RequestFactory());
    }

    /**
     * {@inheritdoc}
     */
    public static function create($url)
    {
        return new static($url, new Client());
    }

    /**
     * {@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function set($name, $value)
    {
        $this->defaultParameters[$name] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return array_key_exists($name, $this->defaultParameters);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($name)
    {
        unset($this->defaultParameters[$name]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery($method)
    {
        $query = new Query($this->url, $this->httpClient);
        if (!empty($this->defaultParameters)) {
            $query->setParameters($this->defaultParameters);
        }
        $query->setParameter('method', $method);

        return $query;
    }

    /**
     * Returns the HTTP client wrapper.
     *
     * @return \Chuckbe\Chuckcms\Chuck\Matomo\HttpClient
     *                                                   The HTTP client wrapper.
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }
}
