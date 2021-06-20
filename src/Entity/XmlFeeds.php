<?php

namespace PrestaShop\Module\Ec_Xmlfeed\Entity;

use Doctrine\Common\Collections;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OrderBy;
/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class XmlFeeds
{

 public function __construct()
 {
     $this->fields = new Collection();
 }

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
     * @var string
     *
     * @ORM\Column(name="feed_name" , type="string", length=254)
     */
    private $feed_name;

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
    /**
     * @var string
     *
     * @ORM\Column(name="format" , type="string",length=20 )
     */
    private $format;

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return XmlFeeds
     */
    public function setFormat(string $format): XmlFeeds
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="filter" , type="string",length=254 )
     */
    private $filter;

    /**
     * @return string
     */
    public function getFilter(): string
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     * @return XmlFeeds
     */
    public function setFilter(string $filter): XmlFeeds
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="XmlMapFields", mappedBy="feed")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $fields;


    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param ArrayCollection $fields
     */
    public function setFields( $fields): void
    {
        $this->fields = $fields;
    }

}