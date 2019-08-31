<?php
declare(strict_types=1);

namespace CSK\Recrutation;

/**
 * Urls reader interface
 */
interface UrlReader
{
    /**
     * Reads a urls collection
     *
     * @return \CSK\Recrutation\Url[]
     */
    public function read(): array;
}
