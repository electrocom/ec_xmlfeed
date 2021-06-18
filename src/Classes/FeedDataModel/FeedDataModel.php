<?php


namespace PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel;


use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\GeneralFeedDataModel;
use PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel\ProductFeedDataModel;
class FeedDataModel
{
private  $items=array();
    private $general;

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return FeedDataModel
     */
    public function setItems(array $items): FeedDataModel
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGeneral()
    {
        return $this->general;
    }

    /**
     * @param mixed $general
     * @return FeedDataModel
     */
    public function setGeneral($general)
    {
        $this->general = $general;
        return $this;
    }


public function __construct()
{
}


    public function  addItem($productFeedDataModel){

    $this->items[]=$productFeedDataModel;

    }




}