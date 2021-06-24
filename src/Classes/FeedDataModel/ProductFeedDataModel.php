<?php
namespace PrestaShop\Module\Ec_Xmlfeed\Classes\FeedDataModel;

class ProductFeedDataModel
{

    private $id_product;

    /**
     * @return mixed
     */
    public function getIdProduct()
    {
        return $this->id_product;
    }

    /**
     * @param mixed $id_product
     */
    public function setIdProduct($id_product): void
    {
        $this->id_product = $id_product;
    }

    /**
     * @return mixed
     */
    public function getImageLink()
    {
        return $this->image_link;
    }

    /**
     * @param mixed $image_link
     */
    public function setImageLink($image_link): void
    {
        $this->image_link = $image_link;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAdditionalImagesLink()
    {
        return $this->additional_images_link;
    }

    /**
     * @param mixed $additional_images_link
     */
    public function setAdditionalImagesLink($additional_images_link): void
    {
        $this->additional_images_link = $additional_images_link;
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
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand): void
    {
        $this->brand = $brand;
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
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getEan13()
    {
        return $this->ean13;
    }

    /**
     * @param mixed $ean13
     */
    public function setEan13($ean13): void
    {
        $this->ean13 = $ean13;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }
    private $image_link;
    private $name;
    private $additional_images_link;
    private $description;
    private $brand;
    private $link;
    private $quantity;
    private $ean13;
    private $price;
    private $custom_label;
    private $category_path;
    private $reference;

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     * @return ProductFeedDataModel
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategoryPath()
    {
        return $this->category_path;
    }

    /**
     * @param mixed $category_path
     * @return ProductFeedDataModel
     */

  private  $category_name;

    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }

    /**
     * @param mixed $category_name
     * @return ProductFeedDataModel
     */
    public function setCategoryName($category_name)
    {
        $this->category_name = $category_name;
        return $this;
    }

    public function setCategoryPath($category_path)
    {
        $this->category_path = $category_path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomLabel()
    {
        return $this->custom_label;
    }

    /**
     * @param mixed $custom_label
     * @return ProductFeedDataModel
     */
    public function setCustomLabel($custom_label)
    {
        $this->custom_label = $custom_label;
        return $this;
    }





}

