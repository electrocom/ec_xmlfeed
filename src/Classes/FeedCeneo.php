<?php


namespace PrestaShop\Module\Ec_Xmlfeed\Classes;

use Db;
use DOMDocument;
use Manufacturer;
use PrestaShop\PrestaShop\Adapter\Shop\Context;
use Product;
use Tools;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\FeedDataModel;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\ProductFeedDataModel;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\GeneralFeedDataModel;
class FeedCeneo
{


    private   $dataxml;

    public function __construct( $feedDataModel)
    {
        $this->dataxml= $feedDataModel;

    }


    function generateXML($tofile=false){


        $xmlstr   ='<?xml version="1.0" encoding="UTF-8" '
            . 'standalone="yes"?><offers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1"></offers>';
        $xml = new SimpleXMLExtended($xmlstr);


        foreach( $this->dataxml->getItems() as $val){


            $qty=$val->getQuantity();
            $avail=empty($qty)?'14':'1';
            $cat= $val->getCategoryPath();

            $allimg=$val->getAdditionalImagesLink();
            $basket=0;

         //   $manufacturer = new Manufacturer((int)  $product->id_manufacturer);
            $xml_product= $xml->addChild('o');
            $xml_product->addAttribute('id', $val->getIdProduct());
            $xml_product->addAttribute('url', $val->getLink());
            $xml_product->addAttribute('price',$val->getPrice());
            $xml_product->addAttribute('avail',$avail);
            $xml_product->addAttribute('stock',$qty);
            $xml_product->addAttribute('basket',$basket);
            $xml_product->addChildWithCDATA('cat', htmlspecialchars($cat));
           $xml_product->addChildWithCDATA('desc', htmlspecialchars(strip_tags( $this->utf8_for_xml($val->getDescription()) ) ));
            $xml_product->addChildWithCDATA('name', htmlspecialchars(strip_tags( $val->getName()) ));

            $attrs=$xml_product->addChild('attrs');
            $attrs->addChild('a', htmlspecialchars($val->getBrand()))->addAttribute('name' , 'Producent');
            $attrs->addChild('a',htmlspecialchars($val->getReference()))->addAttribute('name' , 'Kod_Producenta');
            $attrs->addChild('a',htmlspecialchars($val->getEan13()))->addAttribute('name' , 'EAN');

            $imgs=$xml_product->addChild('imgs');
            $imgs->addChild('main')->addAttribute('url' , $val->getImageLink());

            foreach($allimg as $img)
                $imgs->addChild('i')->addAttribute('url' ,  $img);
        }


        header("Content-Type: application/xml; charset=utf-8");
        echo $xml->saveXML();

    }




    public function addCDATA($string){
        $string = trim($string);
        $string = str_replace(array("\n", "\t", "\r"), ' ', $string);
        return '<![CDATA['.$string.']]>';
    }

    public function utf8_for_xml($string)
    {
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }
}