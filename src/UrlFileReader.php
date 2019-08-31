<?php
/**
 * Created by IntelliJ IDEA.
 * User: yustas
 * Date: 31.08.19
 * Time: 12:21
 */

namespace CSK;

use CSK\Recrutation\UrlReader;
use Exception;
use SplFileObject;
use CSK\Url;
use CSK\FileParam;

class UrlFileReader implements UrlReader
{
    private $fileName;
    private $arrayUrls;

    public function __construct(FileParam $fp)
    {
        $this->fileName = $fp->getFilename();
        $this->pref = $fp->getPref();
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    public function read(): array
    {
        try {
            $file = new SplFileObject(__DIR__ . '/' . $this->pref . '/' . $this->fileName);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        while (!$file->eof()) {
            $line = $file->fgets();
            if (strlen($line) > 0) $this->arrayUrls[] = $this->getUrlObjectFromUrlString($line);
        }

        $file = null;
        return $this->arrayUrls;
    }

    private function getUrlObjectFromUrlString(string $value = null): Url
    {
        $parsedUrl = $this->parseUrl($value);
        $urlObj = new Url();
        $urlObj->setDomain($parsedUrl['host']);
        $urlObj->setPath($parsedUrl['path']);
        $urlObj->setProtocol($parsedUrl['scheme']);

        if ($parsedUrl['query']) {
            $urlObj->setQueryCollection($this->parseQuery($parsedUrl['query']));
        }

        return $urlObj;
    }

    private function parseUrl(string $url): array
    {
        $r = "^(?:(?P<scheme>\w+)://)?";
        $r .= "(?:(?P<login>\w+):(?P<pass>\w+)@)?";
        $r .= "(?P<host>(?:(?P<subdomain>[\w\.]+)\.)?" . "(?P<domain>\w+\.(?P<extension>\w+)))";
        $r .= "(?::(?P<port>\d+))?";
        $r .= "(?P<path>[\w/]*/(?P<file>\w+(?:\.\w+)?)?)?";
        $r .= "(?:\?(?P<query>[(\w|\+|\.|\-|\%|\/)=&]+))?";
        $r .= "(?:#(?P<anchor>\w+))?";
        $r = "!$r!";
        preg_match($r, $url, $result);
        return $result;
    }

    private function parseQuery(string $value): QueryCollection
    {
        //pars query
        $queryColectionInstance = new QueryCollection();
        if (strpos($value, '&') > 0) {
            $query = explode('&', $value);
            foreach ($query as $item) {
                $params = explode('=', $item);
                if ($params[0] && $params[1]) $queryColectionInstance[$params[0]] = $params[1];
            }
        }
        return $queryColectionInstance;
    }
}