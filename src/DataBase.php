<?php
/**
 * Created by IntelliJ IDEA.
 * User: yustas
 * Date: 31.08.19
 * Time: 19:08
 */

namespace CSK;

use SQLite3;
use CSK\FileParam;

class DataBase extends SQLite3
{
    const SELECT_URL_COMMAND = 'SELECT * FROM ';

    public function __construct(FileParam $fp)
    {
        $file = __DIR__ . '/' . $fp->getPref() . '/' . $fp->getFilename();
        //$file = $fp->getPref() . '/' . $fp->getFilename();
        $this->open($file);
    }

    public function select(string $tableName): array
    {
        $resultArray = [];
        $result = $this->query($this::SELECT_URL_COMMAND . $tableName . ';');
        while ($row = $result->fetchArray()) {
            $resultArray[] = $row;
        }
        if ($result) {
            return $resultArray;
        }
        return false;
    }

    public function tableExist(string $tableName): bool
    {
        $result = $this->exec($this::SELECT_URL_COMMAND . $tableName);
        if ($result) {
            return true;
        }
        return false;
    }
}