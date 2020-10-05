<?php
namespace PrestaShop\Module\Ec_Xmlfeed\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class XmlFeedsRepository{

    private $connection;
    private $databasePrefix;

    public function __construct(
        Connection $connection,
        $databasePrefix
    )
    {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;

    }

    function getXmlFeeds()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->connection->createQueryBuilder();
        $qb ->addSelect('xmf.* ')
            ->from($this->databasePrefix . 'xml_feeds', 'xmf')
            ->andWhere('xmf.active = :active')
            ->setParameter('active', 1);

        return $qb->execute()->fetchAll();
    }


function getRep(){

    $entityManager = $this->get('doctrine.orm.entity_manager');
    $testRepository = $entityManager->getRepository(PrestaShop\Module\Ec_Xmlfeed\Entity\XmlFeeds::class);
    $test = $testRepository->findAll();
    return $test;
}


}