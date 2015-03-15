<?php
/**
 * Created by PhpStorm.
 * User: klaushartl
 * Date: 13.03.15
 * Time: 15:05
 */

namespace Classes\Models;


/**
 * Class Track
 * @package Classes\Models
 * @Entity
 * @Table(name="tracks")
 */
class Track
{

    /**
     * @Id
     * @Column(type="integer")
     * @var int
     */
    protected $id;

}
