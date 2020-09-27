<?php

namespace PrestaShop\Module\Ec_Xmlfeed\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class XmlFeeds
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_xml_feeds", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
    public function getFeedName(): string
    {
        return $this->feed_name;
    }

    /**
     * @param string $feed_name
     */
    public function setFeedName(string $feed_name): void
    {
        $this->feed_name = $feed_name;
    }

    /**
     * @return string
     */
    public function getXmlInjectPath(): string
    {
        return $this->xml_inject_path;
    }

    /**
     * @param string $xml_inject_path
     */
    public function setXmlInjectPath(string $xml_inject_path): void
    {
        $this->xml_inject_path = $xml_inject_path;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="xml_inject_path" , type="string", length=254)
     */
    private $xml_inject_path;

    /**
     * @var string
     *
     * @ORM\Column(name="active" , type="integer")
     */
    private $active;

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }

    /**
     * @param string $active
     */
    public function setActive(string $active): void
    {
        $this->active = $active;
    }


}