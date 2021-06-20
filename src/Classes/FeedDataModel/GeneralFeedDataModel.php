<?php


namespace PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel;


class GeneralFeedDataModel
{
private $tilte;

    /**
     * @return mixed
     */
    public function getTilte()
    {
        return $this->tilte;
    }

    /**
     * @param mixed $tilte
     * @return GeneralFeedDataModel
     */
    public function setTilte($tilte)
    {
        $this->tilte = $tilte;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return GeneralFeedDataModel
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     * @return GeneralFeedDataModel
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }
    private $description;
    private $link;
    private $new_products=0;

    /**
     * @return int
     */
    public function getNewProducts(): int
    {
        return $this->new_products;
    }

    /**
     * @param int $new_products
     * @return GeneralFeedDataModel
     */
    public function setNewProducts(int $new_products): GeneralFeedDataModel
    {
        $this->new_products = $new_products;
        return $this;
    }

    public function __construct()
    {
    }

}