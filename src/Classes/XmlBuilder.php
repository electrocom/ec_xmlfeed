<?php

namespace PrestaShop\Module\Ec_Xmlfeed\Classes;

use Doctrine\DBAL\Connection;

class XmlBuilder{

    public function __construct(
        Connection $connection,
        $databasePrefix

    ) {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;

    }

}