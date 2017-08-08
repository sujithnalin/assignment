<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * SubDepartment
 *
 * @ORM\Table(name="sub_department")
 * @ORM\Entity
 */
class SubDepartment
{
    /**
     * @var string
     * @Assert\Regex("/^[a-zA-Z0-9_.-]*$/")
     * @ORM\Column(name="sub_department_name", type="string", length=150, nullable=false)
     */
    private $subDepartmentName;

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
     * Set subDepartmentName
     *
     * @param string $subDepartmentName
     *
     * @return SubDepartment
     */
    public function setSubDepartmentName($subDepartmentName)
    {
        $this->subDepartmentName = $subDepartmentName;

        return $this;
    }

    /**
     * Get subDepartmentName
     *
     * @return string
     */
    public function getSubDepartmentName()
    {
        return $this->subDepartmentName;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return SubDepartment
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
     * @return SubDepartment
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
}
