<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Department
 *
 * @ORM\Table(name="department", indexes={@ORM\Index(name="department_manager_fk_idx", columns={"manager_id"})})
 * @ORM\Entity
 */
class Department
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="department_name", type="string", length=45, nullable=false)
     */
    private $departmentName;

    /**
     * @var integer
     *
     * @ORM\Column(name="department_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $departmentId;

    /**
     * @var \AppBundle\Entity\Employee
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="manager_id", referencedColumnName="employee_id")
     * })
     */
    private $manager;


    public function getDepartmentName()
    {
        return $this->departmentName;
    }

    public function setDepartmentName($departmentName)
    {
        $this->departmentName = $departmentName;
    }


    public function getDepartmentId()
    {
        return $this->departmentId;
    }


    public function getManager()
    {
        return $this->manager;
    }

    public function setManager($manager)
    {
        $this->manager = $manager;
    }
}

