<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MapDepartmentRepository extends EntityRepository {

    public function findByDepartments() {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
                        'SELECT distinct(md.departments) as departments
                            FROM AppBundle:MapDepartment md'
                );

        return $query->getResult();
    }

}
