<?php

namespace Chuckbe\Chuckcms\Chuck\Matomo;

/**
 * Interface for objects that wrap an HTTP client.
 */
interface HttpClientInterface
{
    /**
     * Sets the request parameters.
     *
     * @param array $requestParams
     *                             The request parameters array.
     *
     * @return \Chuckbe\Chuckcms\Chuck\Matomo\HttpClient
     *                                                   The object itself for chain calls.
     */
    public function setRequestParameters(array $requestParams);

    /**
     * Returns the request parameters.
     *
     * @return array
     *               The request parameters.
     */
    public function getRequestParameters();

    /**
     * Returns the request method.
     *
     * @return string
     *                The request method.
     */
    public function getMethod();

    /**
     * Sets the request method.
     *
     * @param string $method
     *                       The request method.
     *
     * @throws \InvalidArgumentException
     *                                   Thrown if the method passed is not supported.
     *
     * @return \Chuckbe\Chuckcms\Chuck\Matomo\HttpClient
     *                                                   The object itself for chain calls.
     */
    public function setMethod($method);

    /**
     * Returns the request url.
     *
     * @return string
     *                The request url.
     */
    public function getUrl();

    /**
     * Sets the url of the request.
     *
     * @param string $url
     *                    The url of the request.
     *
     * @throws \InvalidArgumentException
     *                                   Thrown when the url passed is not a valid url.
     *
     * @return \Chuckbe\Chuckcms\Chuck\Matomo\HttpClient
     *                                                   The object itself for chain calls.
     */
    public function setUrl($url);

    /**
     * Sends the request and returns the results.
     *
     * @throws \Exception
     *                    Thrown when the url is not set yet.
     *
     * @return \GuzzleHttp\Psr7\Response
     *                                   A response that the request generated.
     */
    public function sendRequest();
}
