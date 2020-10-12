<?php
namespace PrestaShop\Module\Ec_Xmlfeed\XMLDataMapper;

use Doctrine\DBAL\Connection;

class XMLDataMapper implements  \Iterator{
    private  $arrayDataMapper = [];
    private  $products = [];
    private  $connection;
    private  $databasePrefix;




    public function __construct(
        Connection $connection,
        $databasePrefix
    ) {
        $this->connection = $connection;
        $this->databasePrefix = $databasePrefix;

    }

    function getval($name){


        switch ($name)
        {
            case 'products';
            return new XMLDataMapperProduct($this->connection,$this->databasePrefix);

            default:
                return  $this;

        }


    }

    public function current()
    {
        // TODO: Implement current() method.
      return  false;
    }

    public function next()
    {
        // TODO: Implement next() method.
        return  false;
    }

    public function key()
    {
        // TODO: Implement key() method.
    }

    public function valid()
    {
        return  false;
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
        return  false;
    }

    public function  __toString(){
        return '';
    }
}