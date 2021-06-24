<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace PrestaShop\Module\Ec_Xmlfeed\Classes;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\ProductFeedDataModel;
use DOMDocument;
class SkapiecFeed
{
    private   $dataxml;

    public function __construct( $feedDataModel)
    {
        $this->dataxml= $feedDataModel;

    }


    function generateXML(){




        $doc = new DOMDocument('1.0', 'UTF-8');

        $xmldata = $doc->appendChild($doc->createElement('xmldata'));
        $xmldata->appendChild($doc->createElement('version', '13.0'));
        $xmldata->appendChild($doc->createElement('time', date("Y-m-d-H-i")));
        $dataNode = $xmldata->appendChild($doc->createElement('data'));

        foreach( $this->dataxml->getItems()  as $val){

            $this->process_simple_product($val, $dataNode, $doc);
        }

        header("Content-Type: application/xml; charset=utf-8");

        echo $doc->saveXML();

    }

    function process_simple_product(ProductFeedDataModel $_product, &$channelNode, &$doc) {

        $itemNode = $channelNode->appendChild($doc->createElement('item'));

        $itemNode->appendChild($doc->createElement('compid'))->appendChild($doc->createTextNode($_product->getIdProduct()));

        $catpath=$_product->getCategoryPath();


        $sep="/";
        $catname= explode($sep,$catpath);
       array_pop($catname);
        $catpath2=@implode($sep,$catname);
        $itemNode->appendChild($doc->createElement('catpath'))->appendChild($doc->createTextNode($catpath2));
        $itemNode->appendChild($doc->createElement('catname'))->appendChild($doc->createTextNode($_product->getCategoryName()));
        foreach($_product->getAdditionalImagesLink() as $additional_image_link )
        $itemNode->appendChild($doc->createElement('photo'))->appendChild($doc->createTextNode(htmlspecialchars($additional_image_link)));

        $itemNode->appendChild($doc->createElement('url'))->appendChild($doc->createTextNode($_product->getLink()));
        $itemNode->appendChild($doc->createElement('vendor'))->appendChild($doc->createTextNode(htmlspecialchars($_product->getBrand())));

        $itemNode->appendChild($doc->createElement('name'))->appendChild($doc->createTextNode(htmlspecialchars($_product->getName())));
        $itemNode->appendChild($doc->createElement('price'))->appendChild($doc->createTextNode($_product->getPrice().' PLN'));
        $itemNode->appendChild($doc->createElement('desclong'))->appendChild(  $doc->createTextNode( $this->addCDATA($this->utf8_for_xml($_product->getDescription())) ));

        if($_product->getQuantity())
            $itemNode->appendChild($doc->createElement('availability'))->appendChild($doc->createTextNode('24'));
        else {
            $itemNode->appendChild($doc->createElement('availability'))->appendChild($doc->createTextNode('999'));
        }

        if (strlen($_product->getEan13()) > 7) {
            $itemNode->appendChild($doc->createElement('ean'))->appendChild($doc->createTextNode($_product->getEan13()));


                                            }
        //   $itemNode->appendChild($doc->createElement('pdeliverypdelivery'))->appendChild($doc->createTextNode($_product->custom_label));
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
