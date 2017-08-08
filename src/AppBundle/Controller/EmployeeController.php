<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use \AppBundle\Entity\AuditTrail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\AuditTrailService;

/**
 * Employee controller.
 *
 * @Route("employee")
 */
class EmployeeController extends Controller {

    private $oldValues;
    /**
     * Lists all employee entities.
     *
     * @Route("/", name="employee_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $employees = $em->getRepository(Employee::class)
                ->findByMapDepartment();
        // var_dump($employees);die();
        return $this->render('employee/index.html.twig', array(
                    'employees' => $employees,
        ));
    }

    /**
     * Creates a new employee entity.
     *
     * @Route("/new", name="employee_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $employee = new Employee();


        if ($request->getMethod() == 'POST') {
            try {

                $employee->setEmployeeName($request->get('employeeName'));
                $employee->setEmail($request->get('email'));
                $employee->setAddress($request->get('address'));
                $employee->setTpNumber($request->get('tpNumber'));
                $employee->setSubDepartment($request->get('subDepartment'));
                $employee->setCreatedAt(new \DateTime("now"));
                $employee->setUpdatedAt(new \DateTime("now"));

                $department = $em->getRepository('AppBundle:MapDepartment')->findBy(array('departments' => $request->get('mapDepartment')));

                $employee->setMapDepartment($department[0]);

                $em = $this->getDoctrine()->getManager();
                $em->persist($employee);
                $em->flush();

                /* Audit Trial */
                $auditTrail = new AuditTrail();
                $auditTrail->setRecordId($employee->getId());
                $auditTrail->setOldValue(json_encode($request->request->all()));
                $auditTrail->setNewValue(json_encode($request->request->all()));
                $auditTrail->setTableName('Employee');
                $auditTrail->setCreatedAt(new \DateTime("now"));
                $auditTrail->setUpdatedAt(new \DateTime("now"));
                $em->persist($auditTrail);
                $em->flush();
                /* End */

                $this->addFlash('notice', 'Your changes were saved!');
                return $this->redirectToRoute('employee_index', array('id' => $employee->getId()));
            } catch (Exception $e) {
                $this->addFlash('error', 'Your changes were saved!');
                return $this->redirectToRoute('departments_new');
            }
        }
        return $this->render('employee/new.html.twig', array(
                    'departments' => $em->getRepository('AppBundle:Departments')->findAll(),
                    'sudDepartments' => $em->getRepository('AppBundle:SubDepartment')->findAll(),
                        //'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a employee entity.
     *
     * @Route("/{id}", name="employee_show")
     * @Method("GET")
     */
    public function showAction(Employee $employee) {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($employee);

        return $this->render('employee/show.html.twig', array(
                    'employee' => $employee,
                    'delete_form' => $deleteForm->createView(),
                    'departments' => $em->getRepository('AppBundle:Departments')->findAll(),
                    'sudDepartments' => $em->getRepository('AppBundle:SubDepartment')->findAll(),
        ));
    }

    /**
     * Displays a form to edit an existing employee entity.
     *
     * @Route("/{id}/edit", name="employee_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Employee $employee) {
        $em = $this->getDoctrine()->getManager();
        $oldValues = json_encode(array(
                'id' => $employee->getId(),
                'employeeName' => $employee->getEmployeeName(),
                'email' => $employee->getEmail(),
                'address' => $employee->getAddress(),
                'tpNumber' => $employee->getTpNumber(),
                'createAt' => $employee->getCreatedAt(),
                'updatedAt' => $employee->getUpdatedAt(),
                'mapDepartment' => $employee->getMapDepartment(),
                'subDepartment' => $employee->getSubDepartment()));
        
        
        if ($request->getMethod() == 'POST') {
            $employee->setEmployeeName($request->get('employeeName'));
            $employee->setEmail($request->get('email'));
            $employee->setAddress($request->get('address'));
            $employee->setTpNumber($request->get('tpNumber'));
            $employee->setUpdatedAt(new \DateTime("now"));

            $department = $em->getRepository('AppBundle:MapDepartment')->findBy(array('departments' => $request->get('mapDepartment'), 'subDepartment' => $request->get('subDepartment')));
            $employee->setMapDepartment($department[0]);
            $this->getDoctrine()->getManager()->flush();
            /* Audit Trial */
            $emAt = $this->getDoctrine()->getManager();
            $auditTrail = new AuditTrail();
            $auditTrail->setRecordId($employee->getId());
            $auditTrail->setOldValue($oldValues);
            $auditTrail->setNewValue(json_encode($request->request->all()));
            $auditTrail->setTableName('Employee');
            $auditTrail->setCreatedAt(new \DateTime("now"));
            $auditTrail->setUpdatedAt(new \DateTime("now"));
            $emAt->persist($auditTrail);
            $emAt->flush();
            /* End */
            
            $this->addFlash('notice', 'Your changes were updated!');
            return $this->redirectToRoute('employee_edit', array('id' => $employee->getId()));
        }
        
        return $this->render('employee/edit.html.twig', array(
                    'employee' => $employee,
                    'departments' => $em->getRepository('AppBundle:Departments')->findAll(),
                    'sudDepartments' => $em->getRepository('AppBundle:SubDepartment')->findAll(),
        ));
    }

    /**
     * Deletes a employee entity.
     *
     * @Route("/{id}", name="employee_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Employee $employee) {
        $form = $this->createDeleteForm($employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($employee);
            $em->flush();
        }

        return $this->redirectToRoute('employee_index');
    }

    /**
     * Creates a form to delete a employee entity.
     *
     * @param Employee $employee The employee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Employee $employee) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('employee_delete', array('id' => $employee->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
