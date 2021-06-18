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
class FacebookFeed
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
        $rootNode = $doc->appendChild($doc->createElement('rss'));
        $rootNode->setAttribute('version', '2.0');
        $rootNode->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', $nsUrl);
        $channelNode = $rootNode->appendChild($doc->createElement('channel'));
        $channelNode->appendChild($doc->createElement('title',  $headerxml->getTilte()));
        $channelNode->appendChild($doc->createElement('description', $headerxml->getDescription()));
        $channelNode->appendChild($doc->createElement('link', $headerxml->getLink()));

        foreach(  $this->dataxml->getItems() as $val){

            $this->process_simple_product($val, $channelNode, $doc);
        }



        header("Content-Type: application/xml; charset=utf-8");

        echo $doc->saveXML();
    }
    function process_simple_product(ProductFeedDataModel $_product, &$channelNode, &$doc) {
        //$_product=(object)$_product;
        $itemNode = $channelNode->appendChild($doc->createElement('item'));

        $itemNode->appendChild($doc->createElement('g:id'))->appendChild($doc->createTextNode($_product->getIdProduct()));
        $itemNode->appendChild($doc->createElement('g:title'))->appendChild($doc->createTextNode(htmlspecialchars($_product->getName())));
        $itemNode->appendChild($doc->createElement('g:description'))->appendChild(  $doc->createTextNode( htmlspecialchars($this->utf8_for_xml($_product->getDescription())) ));
        $itemNode->appendChild($doc->createElement('g:image_link'))->appendChild($doc->createTextNode(htmlspecialchars($_product->getImageLink())));

        foreach($_product->getAdditionalImagesLink() as $additional_image_link )
        $itemNode->appendChild($doc->createElement('g:additional_image_link'))->appendChild($doc->createTextNode(htmlspecialchars($additional_image_link)));

        $itemNode->appendChild($doc->createElement('g:brand'))->appendChild($doc->createTextNode(htmlspecialchars($_product->getBrand())));
        $itemNode->appendChild($doc->createElement('g:link'))->appendChild($doc->createTextNode($_product->getLink()));

        if (strlen($_product->getEan13()) > 7) {
        $itemNode->appendChild($doc->createElement('g:gtin'))->appendChild($doc->createTextNode($_product->getEan13()));
        }

        $itemNode->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode($_product->getPrice().' PLN'));
        //$itemNode->appendChild($doc->createElement('g:sale_price'))->appendChild($doc->createTextNode($_product->wholesale_price));

        if($_product->getQuantity())
        $itemNode->appendChild($doc->createElement('g:availability'))->appendChild($doc->createTextNode('in stock'));
        else {
        $itemNode->appendChild($doc->createElement('g:availability'))->appendChild($doc->createTextNode('out of stock'));
        }

        $itemNode->appendChild($doc->createElement('g:custom_label_0'))->appendChild($doc->createTextNode($_product->getCustomLabel()));
        $itemNode->appendChild($doc->createElement('g:condition'))->appendChild($doc->createTextNode('new'));
        $itemNode->appendChild($doc->createElement('g:identifier_exists'))->appendChild($doc->createTextNode('TRUE'));


    }
    public function utf8_for_xml($string)
    {
        return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
    }
}
