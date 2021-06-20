<?php


namespace PrestaShop\Module\Ec_Xmlfeed\Classes;


class FeedFilterCriteria
{

    public $idsCategories=array();

    /**
     * @return array
     */
    public function getIdsManufacturers(): array
    {
        return $this->idsManufacturers;
    }

    /**
     * @param array $idsManufacturers
     * @return FeedFilterCriteria
     */
    public function setIdsManufacturers(array $idsManufacturers): FeedFilterCriteria
    {
        $this->idsManufacturers = $idsManufacturers;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOnlyavailable(): bool
    {
        return $this->onlyavailable;
    }

    /**
     * @param bool $onlyavailable
     * @return FeedFilterCriteria
     */
    public function setOnlyavailable(bool $onlyavailable): FeedFilterCriteria
    {
        $this->onlyavailable = $onlyavailable;
        return $this;
    }
    public $idsManufacturers=array();

    /**
     * @return array
     */
    public function getIdsCategories(): array
    {
        return $this->idsCategories;
    }

    /**
     * @param array $idsCategories
     * @return FeedFilterCriteria
     */
    public function setIdsCategories(array $idsCategories): FeedFilterCriteria
    {
        $this->idsCategories = $idsCategories;
        return $this;
    }
    public $onlyavailable=false;

public function __construct()
{


}


}