<?php
namespace PrestaShop\Module\Ec_Xmlfeed\Classes;

use Category;
use Db;
use DOMDocument;
use Manufacturer;
use PrestaShop\PrestaShop\Adapter\Shop\Context;
use Product;
use Tools;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\FeedDataModel;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\GeneralFeedDataModel;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\ProductFeedDataModel;
class FeedDataProductService{

    protected $filter_ceneo_best_prices;
    private   $feedTools;
    private   $feedData;
    private $criteria;

    public function __construct(FeedFilterCriteria $criteria)
    {

        $this->filter_ceneo_best_prices=null;
        $this->feedTools= new FeedTools();
        $this->feedData=new FeedDataModel();
        $this->criteria=$criteria;
    }

   private function getDataSql(){
       $id_shop = (int)\Context::getContext()->shop->id;
        $sql_join_ceneo ='';
        $sql_where_ceneobestprice='';
        $sql_join_cat_criteria='';
        $sql_criteria='';

        if($this->filter_ceneo_best_prices) {
            $sql_join_ceneo = 'LEFT JOIN ps_ec_ceneo_analitycs ca on   ca.id_product=ps.id_product';
            $sql_where_ceneobestprice = ' AND ca.current_price-ca.ceneo_price_with_delivery<=0'; //tylko prudykty z najlepszą cena
        }

        if( !empty($this->criteria->getIdsCategories())){
            $sql_join_cat_criteria=' INNER JOIN `ps_category_product`  cp ON cp.id_product=ps.id_product ' ;
            $sql_join_cat_criteria.= $this->MakeIn( $this->criteria->getIdsCategories(),'cp.id_category');
        }

        if($this->criteria->isOnlyavailable()){
            $sql_criteria.=' and `ps_stock_available`.`quantity` >0 ';
        }

        $sql_criteria .= $this->MakeIn( $this->criteria->getIdsManufacturers(),'id_manufacturer');

        $sql='SELECT ps.* FROM `ps_product_shop` ps 
INNER JOIN `ps_product` p ON p.id_product=ps.id_product
INNER JOIN `ps_stock_available` on `ps`.`id_product`=`ps_stock_available`.`id_product` AND ps.id_shop=ps_stock_available.id_shop
'.$sql_join_cat_criteria.'
'.$sql_join_ceneo.'
WHERE ps.`price` > 0
 AND ps.`active` = 1
 AND ps.id_shop='.$id_shop.' '.$sql_criteria.$sql_where_ceneobestprice;
//die($sql);
        $data = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS($sql);
        return $data;
    }

    public function getData(){
        $items=$this->getDataSql();
        foreach ($items as $val) {

            $productFeedModel = new ProductFeedDataModel();
            $context = \Context::getContext();
            $link = \Context::getContext()->link;
            $id_lang= \Context::getContext()->language->id;

            $product = new Product((int)$val['id_product']);
            $manufacturer = new Manufacturer((int)$product->id_manufacturer);
            $productFeedModel->setIdProduct($val['id_product']);
            $productFeedModel->setImageLink($link->getImageLink($product->link_rewrite[$id_lang], Product::getCover($val['id_product'])['id_image']));
            $productFeedModel->setName(ucfirst(mb_strtolower($product->name[$id_lang], 'UTF-8')));
            $productFeedModel->setAdditionalImagesLink($this->feedTools->getProductImagesLink($product));
            $productFeedModel->setBrand($manufacturer->name);
            $productFeedModel->setLink($product->getLink());
            $productFeedModel->setQuantity(Product::getQuantity($val['id_product']));
            $productFeedModel->setEan13($product->ean13);
            $productFeedModel->setPrice(Tools::ps_round($product->getPrice(), 2));
            $productFeedModel->setCategoryPath( $this->feedTools->getCategoryPath($product->id_category_default));
            $productFeedModel->setCategoryName( (new Category($product->id_category_default, $id_lang))->name);
            $productFeedModel->setReference($product->reference);
            $productFeedModel->setDescription($product->description[$id_lang]);

            //  $productFeedModel->setCustomLabel($this->feed_name);
            $this->feedData->addItem($productFeedModel);
        }
        $generalFeedDataModel = new GeneralFeedDataModel();
        $generalFeedDataModel->setDescription($this->feedTools->getDescription());
        $generalFeedDataModel->setTilte($this->feedTools->getTitle());
        $generalFeedDataModel->setLink($this->feedTools->getBaseUrl());
        $this->feedData->setGeneral($generalFeedDataModel);
       // print_r($this->feedData);
        return    $this->feedData;

}


    /**
     * @param mixed $filter_ceneo_best_prices
     */
    public function setFilterCeneoBestPrices($filter_ceneo_best_prices)
    {
        $this->filter_ceneo_best_prices = $filter_ceneo_best_prices;
    }


    function MakeIn($arr,$name): string{
        if(!empty($arr))
        {
            $sql = ' and '.$name.' IN(';
            foreach ($arr as  $value) {
                $sql .= $value;
                $sql .= $value === end($arr) ? '' : ',';
            }
            return $sql .= ')';
        }        else
            return '';
    }

}