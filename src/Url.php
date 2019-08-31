<?php
/**
 * Created by IntelliJ IDEA.
 * User: yustas
 * Date: 31.08.19
 * Time: 12:19
 */

namespace CSK;

use CSK\QueryCollection;

class Url
{
    private $protocol;
    private $domain;
    private $path;
    private $queryCollection;

    public function __construct()
    {

    }

    /**
     * @param mixed $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @param mixed $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @param mixed $queryCollection
     */
    public function setQueryCollection(QueryCollection $queryCollection)
    {
        $this->queryCollection = $queryCollection;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @return mixed
     */
    public function getQueryCollection()
    {
        return $this->queryCollection;
    }

    public function __sleep()
    {
        return array('protocol', 'domain', 'path', 'queryCollection');
    }
}