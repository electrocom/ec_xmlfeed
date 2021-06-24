<?php
namespace PrestaShop\Module\Ec_Xmlfeed\Classes;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Db;
use DOMDocument;
use Manufacturer;
use PrestaShop\PrestaShop\Adapter\Shop\Context;
use Product;
use Tools;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\FeedDataModel;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataProductService;
use PrestaShop\Module\Ec_Xmlfeed\Entity\XmlFeeds;
class FeedGenerator {
    protected $format;

    protected $feed_name;
    protected $context;
    private  $feedDataProductService;
    private  $feed;
    private  $serializer;


    public function __construct(XmlFeeds $FeedData )
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $filter=$this->serializer->deserialize($FeedData->getFilter(),FeedFilterCriteria::class, 'json');
        $this->format=$FeedData->getFormat();
        $this->feedDataProductService=new FeedDataProductService($filter);

    }


    public function getXml(){
        $data_xml=$this->feedDataProductService->getData();


        switch ($this->format){
            case 'facebook':
                $this->feed = new FacebookFeed($data_xml);

                break;

            case 'ceneo':
                $this->feed = new FeedCeneo($data_xml);

                break;

            case 'smallxml':
                $this->feed = new FeedSmall($data_xml);

                break;


            case 'skapiec':
                $this->feed = new SkapiecFeed($data_xml);

                break;


            default:

                $this->feed = new FacebookFeed($data_xml);
                break;
        }

      $this->feed->generateXML();
        die();
    }




}