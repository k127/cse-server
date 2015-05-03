<?php
/**
 * Created by PhpStorm.
 * User: k127
 * Date: 02.05.15
 * Time: 22:57
 */

namespace Classes\Models;

use Classes\Serializable;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Exception;

/**
 * Class Point
 * @package Classes\Models
 * @Entity
 * @Table(name="points")
 */
class Point extends Serializable
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Track", inversedBy="points")
     * @Column(nullable=false)
     * @var Track
     */
    protected $track;
    /**
     * @Column(type="float", nullable=false)
     * @var float
     */
    protected $latitude;
    /**
     * @Column(type="float", nullable=false)
     * @var float
     */
    protected $longitude;
    /**
     * @Column(type="float", nullable=false)
     * @var float
     */
    protected $elevation;
    /**
     * @Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $created_at;

    /**
     * @return Point
     */
    function __construct()
    {
        return $this;
    }

    /**
     * @return Track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * @param Track $track
     * @return Point
     */
    public function setTrack($track)
    {
        $this->track = $track;
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
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return Point
     * @throws
     */
    public function setLatitude($latitude)
    {
        if ($latitude < -90 || $latitude > 90) {
            throw new Exception('out of bounds');
        }
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return Point
     * @throws Exception
     */
    public function setLongitude($longitude)
    {
        if ($longitude < -180 || $longitude > 180) {
            throw new Exception('out of bounds');
        }
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getElevation()
    {
        return $this->elevation;
    }

    /**
     * @param float $elevation
     * @return Point
     * @throws Exception
     */
    public function setElevation($elevation)
    {
        if ($elevation < -5000 || $elevation > 10000) {
            throw new Exception('out of bounds');
        }
        $this->elevation = $elevation;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param int $created_at
     * @return Point
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStoredAt()
    {
        return $this->stored_at;
    }

    /**
     * @param mixed $stored_at
     * @return Point
     */
    public function setStoredAt($stored_at)
    {
        $this->stored_at = $stored_at;
        return $this;
    }

    /**
     * @Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $stored_at;

    /**
     * @PrePersist
     */
    public function timestamp()
    {
        if (is_null($this->getStoredAt())) {
            $this->setStoredAt(new DateTime());
        }
        return $this;
    }
}
