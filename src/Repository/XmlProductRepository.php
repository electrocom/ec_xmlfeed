<?php

namespace PrestaShop\Module\Ec_Xmlfeed\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class XmlProductRepository implements \Countable, \Iterator, \ArrayAccess
{

    private  $products = [];
    private  $position = 0;


private  $context;


    public function __construct(
        Connection $connection,
        $databasePrefix
    ) {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;
        $this->context = \Context::getContext();
    }


   function getProducts()
   {
       /** @var QueryBuilder $qb */
       $qb = $this->connection->createQueryBuilder();
       $qb->addSelect('ps.id_product')
           ->from($this->databasePrefix . 'product_shop', 'ps')
           ->andWhere('ps.active = :active')
           ->setParameter('active', 1);
       $rows = $qb->execute()->fetchAll();
       foreach ($rows as $row) {
    $this->products[]=new \Product($row['id_product']);
       }
   }

   function getImages($id_product){


           /** @var QueryBuilder $qb */
           $qb = $this->connection->createQueryBuilder();
           $qb ->addSelect('i.*,il.*')

               ->from($this->databasePrefix . 'image', 'i')
               ->innerJoin(
                   'i'
                   ,$this->databasePrefix . 'image_lang'
                   ,'il'
                   ,'i.id_image=il.id_image')
               ->andWhere('i.id_product = :id_product')
               ->andWhere('il.id_lang = :id_lang')
               ->setParameter('id_product', $id_product)
               ->setParameter('id_lang',$this->context->language->id);

           $rows =$qb->execute()->fetchAll();
           $row2=array();
    foreach ($rows as $image){


      $image['url']=\Link::getBaseLink(). \Image::getImgFolderStatic($image['id_image']) . $image['id_image'] .'.jpg'.PHP_EOL;;

      $row2[]=$image;
           }


return $row2;
                            }

   function getListProducts(){



}


    public function current()
    {
        return $this->products[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {

        return $this->products[$this->position] instanceof \Product;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function offsetExists($offset)
    {
        return isset($this->products[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->products[$offset];
    }

    public function offsetSet($offset, $value)
    {
        if ( $value instanceof \Product) {
            throw new \InvalidArgumentException("Must be an \Product");
        }

        if (empty($offset)) { //this happens when you do $collection[] = 1;
            $this->values[] = $value;
        } else {
            $this->values[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->products[$offset]);
    }

    public function count()
    {
        return count($this->products);
    }
}