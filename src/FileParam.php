<?php
/**
 * Created by IntelliJ IDEA.
 * User: yustas
 * Date: 31.08.19
 * Time: 17:43
 */

namespace CSK;

class FileParam implements iFileParam
{

    private $pref;
    private $filename;

    public function __construct(string $pref = null, string $fileName = null)
    {
        if (!is_null($fileName)) {
            $this->filename = $fileName;
            $this->pref = $pref;
        } else {
            throw new \InvalidArgumentException('Error set params');
        }
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getPref()
    {
        return isset($this->pref) ? $this->pref : $this::pref;

    }

}