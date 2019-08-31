<?php
/**
 * Created by IntelliJ IDEA.
 * User: yustas
 * Date: 31.08.19
 * Time: 17:44
 */

namespace CSK;

interface iFileParam
{
    const pref = "../_data_";

    public function getFileName();

    public function getPref();
}