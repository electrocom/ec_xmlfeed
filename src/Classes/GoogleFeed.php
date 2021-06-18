<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GoogleFeed
{
    private $filter_id_categories;
    private $filter_id_manufacturers;
    private $filter_ceneo_best_prices;
    private $feed_name;
    public function __construct()
    {
         $this->filter_id_categories=null;
         $this->filter_id_manufacturers=null;
        $this->filter_ceneo_best_prices=null;
    }

    /**
     * @param mixed $feed_name
     */
    public function setFeedName($feed_name)
    {
        $this->feed_name = $feed_name;
    }
    /**
     * @param mixed $filter_ceneo_best_prices
     */
    public function setFilterCeneoBestPrices($filter_ceneo_best_prices)
    {
        $this->filter_ceneo_best_prices = $filter_ceneo_best_prices;
    }
    /**
     * @param null $filter_id_manufacturers
     */
    public function setFilterIdManufacturers($filter_id_manufacturers)
    {
        $this->filter_id_manufacturers = $filter_id_manufacturers;
    }

    /**
     * @param null $filter_id_categories
     */
    public function setFilterIdCategories($filter_id_categories)
    {
        $this->filter_id_categories = $filter_id_categories;
    }

    function generateXML($tofile=false){

        if (isset(Context::getContext()->controller)) {
            $controller = Context::getContext()->controller;
        } else {

            $controller = new FrontController();

            $controller->init();

        }

        function CheckIsLogged()
        {
            if (Context::getContext()->customer->isLogged()) {
                Context::getContext()->customer->logout();
                die ('Błąd użytkownik zalogowany');


            }
        }

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

            $merchant=array(
                'id_product' => $val['id_product'],
                'image_link' =>    $link->getImageLink($product->link_rewrite[1], Product::getCover( $val['id_product'] )['id_image']) ,
                'name' =>ucfirst(strtolower($product->name['1'])),
                'additional_images_link' =>$images_link,
                'description' =>  html_entity_decode( strip_tags( $product->description['1'] ) ) ,
                'brand'=> $manufacturer->name,
                'link' =>$product->getLink(),
                'quantity'=>Product::getQuantity($val['id_product']),
                'ean13' =>$product->ean13,
                'price' =>   Tools::ps_round($product->getPrice(), 2),
                'custom_label' =>$this->feed_name
            );

            //print_r($merchant);
            $this->process_simple_product($merchant, $channelNode, $doc);
        }


        if($tofile){
            echo  $file=_PS_ROOT_DIR_.'/'.$tofile.CrudTools::getToken().'.xml';

            file_put_contents($file,   $doc->saveXML());
        }
        else{
            header("Content-Type: application/xml; charset=utf-8");
            echo $doc->saveXML();
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

    function getData(){
        $sql_criteria='';
        if($this->filter_ceneo_best_prices) {
            $sql_join_ceneo = 'LEFT JOIN ps_ec_ceneo_analitycs ca on   ca.id_product=ps.id_product';
            $sql_where_ceneobestprice = ' AND ca.current_price-ca.ceneo_price_with_delivery<0'; //tylko prudykty z najlepszą cena
        }

        $sql_criteria = $this->MakeIn( $this->filter_id_manufacturers,'id_manufacturer');
        $sql_criteria .= $this->MakeIn( $this->filter_id_categories,'id_category');
        $sql='SELECT ps.* FROM `ps_product_shop` ps inner join `ps_category_product` on `ps_category_product`.`id_product`=ps.id_product
INNER JOIN `ps_product` p ON p.id_product=ps.id_product
INNER JOIN `ps_stock_available` on `ps`.`id_product`=`ps_stock_available`.`id_product` AND ps.id_shop=ps_stock_available.id_shop
'.$sql_join_ceneo.'
WHERE
 ps.`price` > 0
 AND ps.`active` = 1
 AND ps.id_shop=1 '.$sql_criteria.$sql_where_ceneobestprice;
        $data = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
        return $data;
    }

    function MakeIn($arr,$name): string{
        if(!empty($arr))
        {
            $sql = ' AND '.$name.' IN(';
            foreach ($arr as  $value) {
                $sql .= $value;
                $sql .= $value === end($arr) ? '' : ',';
            }
            return $sql .= ')';
        }        else
            return '';
    }
}
