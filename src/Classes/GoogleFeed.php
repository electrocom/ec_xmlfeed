<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GoogleFeed
{


    public function __construct()
    {

    }



    function generateXML(){


        $link = Context::getContext()->link;
        $nsUrl = 'http://base.google.com/ns/1.0';
        $doc = new DOMDocument('1.0', 'UTF-8');

        $rootNode = $doc->appendChild($doc->createElement('rss'));
        $rootNode->setAttribute('version', '2.0');
        $rootNode->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', $nsUrl);
        $channelNode = $rootNode->appendChild($doc->createElement('channel'));
        $channelNode->appendChild($doc->createElement('title', 'b2b.tomax.pl'));
        $channelNode->appendChild($doc->createElement('description', 'Katalog produktów b2b.tomax.pl'));
        $channelNode->appendChild($doc->createElement('link', 'https://b2b.tomax.pl'));


        $data = $this->getData();

        foreach( $data as $val){

            $product = new Product((int)  $val['id_product']);
            $manufacturer = new Manufacturer((int)  $product->id_manufacturer);
            $allimg=$product->getWsImages();
            $images_link=array();
            $img_cunter=0;
            foreach($allimg as $img) {
                if($img_cunter>5)
                    break;
                $images_link[] = $link->getImageLink($product->link_rewrite[1], $img['id'], 'large_default');
                $img_cunter++;
            }


            //print_r($merchant);
            $this->process_simple_product($merchant, $channelNode, $doc);
        }



    }

    function process_simple_product($_product, &$channelNode, &$doc) {
        $_product=(object)$_product;
        $itemNode = $channelNode->appendChild($doc->createElement('item'));

        $itemNode->appendChild($doc->createElement('g:id'))->appendChild($doc->createTextNode($_product->id_product));
        $itemNode->appendChild($doc->createElement('g:title'))->appendChild($doc->createTextNode(htmlspecialchars($_product->name)));
        $itemNode->appendChild($doc->createElement('g:description'))->appendChild(  $doc->createTextNode( $_product->description) );
        $itemNode->appendChild($doc->createElement('g:image_link'))->appendChild($doc->createTextNode(htmlspecialchars($_product->image_link)));

        foreach($_product->additional_images_link as $additional_image_link )
            $itemNode->appendChild($doc->createElement('g:additional_image_link'))->appendChild($doc->createTextNode(htmlspecialchars($additional_image_link)));

        $itemNode->appendChild($doc->createElement('g:brand'))->appendChild($doc->createTextNode(htmlspecialchars($_product->brand)));
        $itemNode->appendChild($doc->createElement('g:link'))->appendChild($doc->createTextNode($_product->link));



        if (strlen($_product->ean13) > 7) {
            $itemNode->appendChild($doc->createElement('g:gtin'))->appendChild($doc->createTextNode($_product->ean13));
        }

        $itemNode->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode($_product->price.' PLN'));
        //$itemNode->appendChild($doc->createElement('g:sale_price'))->appendChild($doc->createTextNode($_product->wholesale_price));

        if($_product->quantity)
            $itemNode->appendChild($doc->createElement('g:availability'))->appendChild($doc->createTextNode('in stock'));
        else {
            $itemNode->appendChild($doc->createElement('g:availability'))->appendChild($doc->createTextNode('out of stock'));
        }

        $itemNode->appendChild($doc->createElement('g:custom_label_0'))->appendChild($doc->createTextNode($_product->custom_label));
          $itemNode->appendChild($doc->createElement('g:condition'))->appendChild($doc->createTextNode('new'));
        $itemNode->appendChild($doc->createElement('g:identifier_exists'))->appendChild($doc->createTextNode('TRUE'));


    }

}
