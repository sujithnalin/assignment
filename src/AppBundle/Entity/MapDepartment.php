<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MapDepartment
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MapDepartmentRepository")
 * @ORM\Table(name="map_department", indexes={@ORM\Index(name="fk_map_department_sub_department1_idx", columns={"sub_department_id"}), @ORM\Index(name="fk_map_department_departments1_idx", columns={"departments_id"})})
 * @ORM\Entity
 */
class MapDepartment
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="date", nullable=false)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Departments
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departments_id", referencedColumnName="id")
     * })
     */
    private $departments;

    /**
     * @var \AppBundle\Entity\SubDepartment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SubDepartment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sub_department_id", referencedColumnName="id")
     * })
     */
    private $subDepartment;



    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return MapDepartment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MapDepartment
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

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
     * Set departments
     *
     * @param \AppBundle\Entity\Departments $departments
     *
     * @return MapDepartment
     */
    public function setDepartments(\AppBundle\Entity\Departments $departments = null)
    {
        $this->departments = $departments;

        return $this;
    }

    /**
     * Get departments
     *
     * @return \AppBundle\Entity\Departments
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    /**
     * Set subDepartment
     *
     * @param \AppBundle\Entity\SubDepartment $subDepartment
     *
     * @return MapDepartment
     */
    public function setSubDepartment(\AppBundle\Entity\SubDepartment $subDepartment = null)
    {
        $this->subDepartment = $subDepartment;

        return $this;
    }

    /**
     * Get subDepartment
     *
     * @return \AppBundle\Entity\SubDepartment
     */
    public function getSubDepartment()
    {
        return $this->subDepartment;
    }
}
