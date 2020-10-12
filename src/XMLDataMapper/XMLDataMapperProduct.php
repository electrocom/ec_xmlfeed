<?php
namespace PrestaShop\Module\Ec_Xmlfeed\XMLDataMapper;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\Module\Ec_Xmlfeed\XMLDataMapper\XMLDataMapperImage;
use PrestaShop\PrestaShop\Adapter\Tools;


class XMLDataMapperProduct implements \Countable, \Iterator, \ArrayAccess
{
    private  $productsId = [];
    private  $position = 0;
    private  $context;
    private  $product;
    private  $id_lang;
    private  $connection;
    private  $databasePrefix;

    /**
     *
     * @param Connection $connection
     * @param $databasePrefix
     */



    public function __construct(
         $connection,
        $databasePrefix
    ) {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;
        $this->context = \Context::getContext();
        $this->LoadProducts();
        $this->id_lang=$this->context->language->id;
        $this->position = 0;
    }

    public function  __toString(){
        return '';
    }
   private function LoadProducts()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->connection->createQueryBuilder();
        $qb->addSelect('ps.id_product')
            ->from($this->databasePrefix . 'product_shop', 'ps')
            ->andWhere('ps.active = :active')
            ->setParameter('active', 1);
        $rows = $qb->execute()->fetchAll();
        foreach ($rows as $row) {
            $this->productsId[] = $row['id_product'];
        }
    }

    function getval($name){


        switch ($name)
        {
            case 'id':
             return  $this->productsId[$this->position];
            case 'url':
                return  $this->product->getLink();
            case 'price':
                return  $this->product->getPrice();
            case 'price_wihout_tax':
                return  $this->product->getPrice(false);
            case 'active':
                return  $this->product->active;
            case 'quantity':
                return  $this->product::getQuantity($this->productsId[$this->position]);
            case 'description':
                return  $this->product->description[$this->id_lang];
            case 'description_short':
                return  $this->product->description_short[$this->id_lang];
            case 'name':
                return  $this->product->name[$this->id_lang];
            case 'reference':
                return $this->product->reference;
            case 'ean13':
                return $this->product->ean13;
            case 'manufacturer_name':
                return $this->product->getWsManufacturerName();
            case 'images':
                return new XMLDataMapperImage($this->productsId[$this->position],$this->databasePrefix,$this);
            case 'image_cover':
                return (new XMLDataMapperImage($this->productsId[$this->position],$this->databasePrefix,$this))->getCover();
            case  'products':
                return  new XMLDataMapperProduct($this->connection,$this->databasePrefix);

            //case 'default_category_name':
            case 'default_category_id':
                return  $this->product->getDefaultCategory();

            case 'category_path':
                $category = new \Category($this->product->getDefaultCategory(), $this->id_lang,$this->context->shop->id);
                $path=array_reverse($category->getParentsCategories());
                $path_str='';
                foreach ($path as $value)
                $path_str.=$value['name'].'/';
                return $path_str;



            default:
             return   $name;

        }


    }

  public function __get($name)
  {
      $this->getval($name);
  }

    public function current()
    {
        $this->product = new \Product($this->productsId[$this->position]);
        return $this;
    }

    public function next()
    {
        $this->position++;
      //  echo "next". $this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        $tmp = isset($this->productsId[$this->position]);
      //  echo "valid".$tmp;
        return $tmp;
    }

    public function rewind()
    {
        $this->position = 0;
        $this->product = new \Product($this->productsId[$this->position]);
    }

    public function offsetExists($offset)
    {
        return isset($this->productsId[$offset]);
    }

    public function offsetGet($offset)
    {

        return $this->productsId[$offset];
    }

    public function offsetSet($offset, $value)
    {


        if (empty($offset)) { //this happens when you do $collection[] = 1;
            $this->productsId[] = $value;
        } else {
            $this->productsId[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->productsId[$offset]);
    }

    public function count()
    {
        return count($this->productsId);
    }


}