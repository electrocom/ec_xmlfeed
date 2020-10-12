<?php


namespace PrestaShop\Module\Ec_Xmlfeed\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class XmlMapFieldsRepository
{

    public function __construct(
        Connection $connection,
        $databasePrefix
    )
    {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;

    }

    function getXmlMapFields()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->connection->createQueryBuilder();
        $qb ->addSelect('xmf.* ')
            ->from($this->databasePrefix . 'xml_map_fields', 'xmf')
            ->andWhere('xmf.active = :active')
            ->addOrderBy('position','ASC')
            ->setParameter('active', 1);
        return $qb->execute()->fetchAll();
    }

}