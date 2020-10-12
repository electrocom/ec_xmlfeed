<?php

namespace PrestaShop\Module\Ec_Xmlfeed\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class XmlMapFields
{
    const TITLE_MAX_LENGTH = 64;
    const CUSTOMER_NAME_MAX_LENGTH = 64;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_xml_map_fields", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var int
     *
     * @ORM\Column(name="id_xml_feeds", type="integer")
      */
    private $id_xml_feeds ;

    /**
     * @return int
     */
    public function getIdXmlFeeds(): int
    {
        return $this->id_xml_feeds;
    }

    /**
     * @param int $id_xml_feeds
     */
    public function setIdXmlFeeds(int $id_xml_feeds): void
    {
        $this->id_xml_feeds = $id_xml_feeds;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="shop_field_name" , type="string", length=255)
     */
    private $shop_field_name;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_value" , type="string", length=255)
     */
    private $custom_value;

    /**
     * @return string
     */
    public function getCustomValue()
    {
        return $this->custom_value;
    }

    /**
     * @param string $custom_value
     */
    public function setCustomValue($custom_value)
    {
        $this->custom_value = $custom_value;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="cdata" , type="integer")
     */
    private $cdata;

    /**
     * @return integer
     */
    public function getCdata()
    {
        return $this->cdata;
    }

    /**
     * @param integer $cdata
     */
    public function setCdata( $cdata): void
    {
        $this->cdata = $cdata;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getShopFieldName(): string
    {
        return $this->shop_field_name;
    }

    /**
     * @param string $shop_field_name
     */
    public function setShopFieldName(string $shop_field_name): void
    {
        $this->shop_field_name = $shop_field_name;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="xml_field_path_name" , type="string", length=254)
     */
    private $xml_field_path_name;

    /**
     * @return string
     */
    public function getXmlFieldPathName(): string
    {
        return $this->xml_field_path_name;
    }

    /**
     * @param string $xml_field_path_name
     */
    public function setXmlFieldPathName(string $xml_field_path_name): void
    {
        $this->xml_field_path_name = $xml_field_path_name;
    }



    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="active", type="integer")
     */
    private $active;

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    /**
     * @ORM\ManyToOne(targetEntity="XmlFeeds", inversedBy="fields")
     * @ORM\JoinColumn(name="id_xml_feeds", referencedColumnName="id_xml_feeds")
     */
    private $feed;

    /**
     * @return mixed
     */
    public function getFeed()
    {
        return $this->feed;
    }

    /**
     * @param mixed $feed
     */
    public function setFeed($feed): void
    {
        $this->feed = $feed;
    }
}