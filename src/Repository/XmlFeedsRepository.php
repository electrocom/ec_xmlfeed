<?php
namespace PrestaShop\Module\Ec_Xmlfeed\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class XmlFeedsRepository{

    private $connection;
    private $databasePrefix;
    private $entityManager;
    public function __construct(
        Connection $connection,
        $databasePrefix,
        $entityManager
    )
    {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;
        $this->entityManager=$entityManager;
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


public function getFeed($name){

    $testRepository = $this->entityManager->getRepository(\PrestaShop\Module\Ec_Xmlfeed\Entity\XmlFeeds::class);
    $test = $testRepository->findOneBy(array('feed_name' => $name));
    return $test;
}


}