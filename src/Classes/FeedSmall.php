<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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
class FeedSmall
{
    private   $dataxml;

    public function __construct( $feedDataModel)
    {
    $this->dataxml= $feedDataModel;

    }



    function generateXML(){


        $nsUrl = 'http://base.google.com/ns/1.0';
        $doc = new DOMDocument('1.0', 'UTF-8');
        $headerxml= $this->dataxml->getGeneral();
        $rootNode = $doc->appendChild($doc->createElement('items'));


        foreach(  $this->dataxml->getItems() as $val){

            $this->process_simple_product($val, $rootNode, $doc);
        }



        header("Content-Type: application/xml; charset=utf-8");

        echo $doc->saveXML();
    }
    function process_simple_product(ProductFeedDataModel $_product, &$channelNode, &$doc) {
        //$_product=(object)$_product;
        $itemNode = $channelNode->appendChild($doc->createElement('item'));

        $itemNode->setAttribute('id_product',$_product->getIdProduct());



        if (strlen($_product->getEan13()) > 7) {
        $itemNode->setAttribute('ean',$_product->getEan13());
        }
        $itemNode->setAttribute('price',$_product->getPrice());
        $itemNode->setAttribute('reference',$_product->getReference());
        $itemNode->setAttribute('qty',$_product->getQuantity());



    }
    public function utf8_for_xml($string)
    {
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }
}
