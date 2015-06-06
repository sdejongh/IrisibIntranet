<?php

namespace Irisib\IntranetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Department")
 * @ORM\Entity(repositoryClass="DepRepository");
 */

class Dep {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    protected $shortname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $fullname;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set shortname
     *
     * @param string $shortname
     * @return Department
     */
    public function setShortname($shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * Get shortname
     *
     * @return string 
     */
    public function getShortname()
    {
        return $this->shortname;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     * @return Department
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string 
     */
    public function getFullname()
    {
        return $this->fullname;
    }
}
