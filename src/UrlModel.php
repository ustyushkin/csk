<?php
/**
 * Created by IntelliJ IDEA.
 * User: yustas
 * Date: 31.08.19
 * Time: 20:53
 */

namespace CSK;

use \CSK\Url;

class UrlModel extends DataBase
{
    const CREATE_URL_TABLE_COMMAND = 'CREATE TABLE IF NOT EXISTS urls ( id INTEGER PRIMARY KEY, url TEXT NOT NULL)';
    const INSERT_URL_COMMAND = 'INSERT INTO urls (url) VALUES ';
    const DELETE_URL_COMMAND = 'DELETE FROM urls';
    const TABLE = 'urls';

    public function deleteAll()
    {
        $result = $this->exec($this::DELETE_URL_COMMAND);
        if (!$result) {
            throw new \Exception($this->lastErrorMsg());
        }
        return true;
    }

    public function insert(Url $url): bool
    {
        if (!$this->tableExist($this::TABLE)) {
            $this->createTable();
        }

        $serializedUrl = serialize($url);
        $value = base64_encode($serializedUrl);
        $result = $this->exec($this::INSERT_URL_COMMAND . " ('" . $value . "')");
        if (!$result) {
            throw new \Exception($this->lastErrorMsg());
        }
        return true;
    }

    public function select(): array
    {
        $resultArray = [];
        $result = parent::select($this::TABLE);
        foreach ($result as $item) {
            $resultArray[] = unserialize(base64_decode($item['url']));
        }
        return $resultArray;
    }

    private function createTable(): void
    {
        $command = $this::CREATE_URL_TABLE_COMMAND;
        $result = $this->exec($command);
        if (!$result) throw new \Exception($this->lastErrorMsg());
    }
}