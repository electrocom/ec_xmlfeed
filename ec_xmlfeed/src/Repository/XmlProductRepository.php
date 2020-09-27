<?php

namespace PrestaShop\Module\Ec_Xmlfeed\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class XmlProductRepository{

    public function __construct(
        Connection $connection,
        $databasePrefix

    ) {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;

    }

   function getProducts(){


       /** @var QueryBuilder $qb */
       $qb = $this->connection->createQueryBuilder();
       $qb
           ->addSelect('ps.* ')

           ->from($this->databasePrefix . 'product_shop', 'ps')
           ->andWhere('ps.active = :active')
           ->setParameter('active', 1);


       return $qb->execute()->fetchAll();
   }

}