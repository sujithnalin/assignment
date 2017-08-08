<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\MapDepartment;

class EmployeeRepository extends EntityRepository {

    public function findByMapDepartment() {

        $em = $this->getEntityManager();
        /* get all sub department by Main Department */
        /* get All Main Department */
        $mainDepartments = $em->getRepository('AppBundle:Departments')->findAll();
        $mapDepartments = array();
        foreach ($mainDepartments as $mainDepartment) {
            $subDepartments = $em->getRepository('AppBundle:MapDepartment')
                    ->findBy(array('departments' => $mainDepartment->getId()));
            if (isset($subDepartments) && !is_null($subDepartments)) {
                $mapDepartments[$mainDepartment->getId()] = $subDepartments;
            }
        }
        
        $details = null;
        $mainDepartment = null;
        foreach ($mapDepartments as $mapDepartment) {
            $employeeDetails = array();
            foreach ($mapDepartment as $department) {
                $employees = $em->getRepository('AppBundle:Employee')
                        ->findBy(array('mapDepartment' => $department->getId()));                

                foreach ($employees as $employee) {
                    $mainDepartment = $employee->getMapDepartment()->getDepartments()->GetDepartmentName();

                    $employeeDetails[] = array(
                        'id' => $employee->getId(),
                        'employeeName' => $employee->getEmployeeName(),
                        'address' => $employee->getAddress(),
                        'email' => $employee->getEmail(),
                        'tpNumber' => $employee->getTpNumber(),
                        'sunDepartment' => $employee->getMapDepartment()->getSubDepartment()->GetSubDepartmentName()
                    );
                }
            }
            if (isset($employeeDetails) && !empty($employeeDetails)) {
                $details[$mainDepartment] = $employeeDetails;
            }
        }
        return $details;
    }

}
