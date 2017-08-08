<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 * @ORM\Table(name="employee", indexes={@ORM\Index(name="fk_employee_map_department1_idx", columns={"map_department_id"})})
 * @ORM\Entity
 */
class Employee
{
    /**
     * @var string
     *
     * @ORM\Column(name="employee_name", type="string", length=150, nullable=false)
     */
    private $employeeName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=45, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var integer
     *
     * @ORM\Column(name="tp_number", type="integer", nullable=false)
     */
    private $tpNumber;

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
     * @var integer
     *
     * @ORM\Column(name="sub_department", type="integer")
     */
    private $subDepartment;

    /**
     * @var \AppBundle\Entity\MapDepartment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\MapDepartment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="map_department_id", referencedColumnName="id")
     * })
     */
    private $mapDepartment;



    /**
     * Set employeeName
     *
     * @param string $employeeName
     *
     * @return Employee
     */
    public function setEmployeeName($employeeName)
    {
        $this->employeeName = $employeeName;

        return $this;
    }

    /**
     * Get employeeName
     *
     * @return string
     */
    public function getEmployeeName()
    {
        return $this->employeeName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Employee
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Employee
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

 
    /**
     * Set tpNumber
     *
     * @param integer $tpNumber
     *
     * @return Employee
     */
    public function setTpNumber($tpNumber)
    {
        $this->tpNumber = $tpNumber;

        return $this;
    }

    /**
     * Get tpNumber
     *
     * @return integer
     */
    public function getTpNumber()
    {
        return $this->tpNumber;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Employee
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
     * @return Employee
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
     * Set subDepartment
     *
     * @param integer $subDepartment
     *
     * @return Employee
     */
    public function setSubDepartment($subDepartment)
    {
        $this->subDepartment = $subDepartment;

        return $this;
    }

    /**
     * Get subDepartment
     *
     * @return integer
     */
    public function getSubDepartment()
    {
        return $this->subDepartment;
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
     * Set mapDepartment
     *
     * @param \AppBundle\Entity\MapDepartment $mapDepartment
     *
     * @return Employee
     */
    public function setMapDepartment(\AppBundle\Entity\MapDepartment $mapDepartment = null)
    {
        $this->mapDepartment = $mapDepartment;

        return $this;
    }

    /**
     * Get mapDepartment
     *
     * @return \AppBundle\Entity\MapDepartment
     */
    public function getMapDepartment()
    {
        return $this->mapDepartment;
    }
}
