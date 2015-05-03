<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 13.03.15
 * Time: 15:05
 */

namespace Classes\Models;

use Classes\Serializable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


/**
 * Class Track
 * @package Classes\Models
 * @Entity
 * @Table(name="tracks")
 */
class Track extends Serializable
{
    /**
     * @return Track
     */
    public function __construct()
    {
        $this->points = new ArrayCollection();
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param ArrayCollection $points
     * @return Track
     */
    public function setPoints($points)
    {
        $this->points = $points;
        return $this;
    }

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ One ToMany(targetEntity="Point", mappedBy="track", cascade={"persist"})
     * @Column(type="array", nullable=false)
     * @ManyToOne(targetEntity="Point")
     * @JoinColumn(name="point_id", referencedColumnName="id")
     * @var ArrayCollection
     */
    protected $points;
}
