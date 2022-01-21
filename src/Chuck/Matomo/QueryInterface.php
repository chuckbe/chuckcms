<?php

namespace Chuckbe\Chuckcms\Chuck\Matomo;

/**
 * Interface for classes that query the Matomo reporting API.
 */
interface QueryInterface
{
    /**
     * Sets a range of query parameters.
     *
     * @param array $parameters
     *                          An associative array of query parameters, keyed by parameter name.
     *
     * @return $this
     *               The updated query object.
     */
    public function setParameters(array $parameters);

    /**
     * Sets a query parameter.
     *
     * @param string $name
     *                      The name of the parameter to set.
     * @param mixed  $value
     *                      The value to set.
     *
     * @return $this
     *               The updated query object.
     */
    public function setParameter($name, $value);

    /**
     * Returns the query parameters that have been set.
     *
     * @return array
     *               An associative array of query parameters, keyed by parameter name.
     */
    public function getParameters();

    /**
     * Returns the query parameters with the given name.
     *
     * @param string $name
     *                     The name of the parameter.
     *
     * @throws \InvalidArgumentException
     *                                   Thrown when the query parameter with the given name is not set.
     *
     * @return mixed
     *               The value of the parameter.
     */
    public function getParameter($name);

    /**
     * Executes the query.
     *
     * @return \Chuckbe\Chuckcms\Chuck\Matomo\QueryResult
     *                                                    The query result.
     */
    public function execute();
}
