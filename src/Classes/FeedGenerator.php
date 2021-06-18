<?php
namespace PrestaShop\Module\Ec_Xmlfeed\Classes;

use Db;
use DOMDocument;
use Manufacturer;
use PrestaShop\PrestaShop\Adapter\Shop\Context;
use Product;
use Tools;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\FeedDataModel;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataProductService;

class FeedGenerator {
    protected $format;

    protected $feed_name;
    protected $context;
    private  $feedDataProductService;
    private  $feed;



    public function __construct($format='facebook')
    {
        $this->format=$format;
        $this->feedDataProductService=new FeedDataProductService();

    }


    public function getXml(){
        $data_xml=$this->feedDataProductService->getData();


        switch ($this->format){
            case 'facebook':
                $this->feed = new FacebookFeed($data_xml);

                break;

            case 'Ceneo':
                $this->feed = new FeedCeneo($data_xml);

                break;

            case 'smallxml':
                $this->feed = new FeedSmall($data_xml);

                break;


            default:

                $this->feed = new FacebookFeed($data_xml);
                break;
        }

      $this->feed->generateXML();
        die();
    }




}