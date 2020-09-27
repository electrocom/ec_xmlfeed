<?php

namespace PrestaShop\Module\Ec_Xmlfeed\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="shop_field_name" , type="string", length=254)
     */
    private $shop_field_name;



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



}