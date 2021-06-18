<?php
namespace PrestaShop\Module\Ec_Xmlfeed\XMLDataMapper;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
class XMLDataMapperImage implements \Countable, \Iterator, \ArrayAccess
{
    private  $images = [];
    private  $position = 0;
    private  $context;
    private  $product;
    private  $id_lang;
    private $databasePrefix;
    private $products;
    public function __construct(
       $id_product,
        $databasePrefix,
    $products
    ) {

        $this->databasePrefix = $databasePrefix;
        $this->context = \Context::getContext();
        $this->id_lang=$this->context->language->id;
        $this->LoadImages($id_product);
        $this->products=$products;
        $this->position = 0;
    }

    public function  __toString(){
        return '';
    }

    private function LoadImages($id_product)
   {
  $this->images=\Image::getImages($this->id_lang,$id_product);

   }

    function getval($name){


        switch ($name)
        {  case 'id':
                return  $this->images[$this->position]['id_image'];

            case 'url':
                $id_image= $this->images[$this->position]['id_image'];
                $uriPath = _THEME_PROD_DIR_ . \Image::getImgFolderStatic($this->images[$this->position]['id_image']) . $id_image.'.jpg';
                return  $this->context->link->protocol_content.\Tools::getMediaServer($uriPath).$uriPath;

            case 'cover':
                $id_image= $this->images[$this->position]['id_image'];
                $uriPath = _THEME_PROD_DIR_ . \Image::getImgFolderStatic($this->images[$this->position]['id_image']) . $id_image.'.jpg';
                return  $this->context->link->protocol_content.\Tools::getMediaServer($uriPath).$uriPath;
        }


    }


    public function getCover(){

        if(empty($this->images))
            return '';

        foreach ($this->images as $key=>$cover){
            if ($cover['cover']==1)
            {
                $this->position=$key;
            }

        }
        $id_image= $this->images[$this->position]['id_image'];
        $uriPath = _THEME_PROD_DIR_ . \Image::getImgFolderStatic($this->images[$this->position]['id_image']) . $id_image.'.jpg';
        return  $this->context->link->protocol_content.\Tools::getMediaServer($uriPath).$uriPath;
                                }

    public function current()
    {

        return $this;
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
        $tmp = isset($this->images[$this->position]);
        return $tmp;
    }

    public function rewind()
    {
        $this->position = 0;

    }

    public function offsetExists($offset)
    {
        return isset($this->productsId[$offset]);
    }

    public function offsetGet($offset)
    {

        return $this->images[$offset];
    }

    public function offsetSet($offset, $value)
    {


        if (empty($offset)) { //this happens when you do $collection[] = 1;
            $this->images[] = $value;
        } else {
            $this->images[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->images[$offset]);
    }

    public function count()
    {
        return count($this->images);
    }


}