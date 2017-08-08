<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MapDepartment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mapdepartment controller.
 *
 * @Route("mapdepartment")
 */
class MapDepartmentController extends Controller {

    /**
     * Lists all mapDepartment entities.
     *
     * @Route("/", name="mapdepartment_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $mapDepartments = $em->getRepository('AppBundle:MapDepartment')->findAll();

        return $this->render('mapdepartment/index.html.twig', array(
                    'mapDepartments' => $mapDepartments,
        ));
    }

    /**
     * Creates a new mapDepartment entity.
     *
     * @Route("/new", name="mapdepartment_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $mapDepartment = new Mapdepartment();
        $form = $this->createForm('AppBundle\Form\MapDepartmentType', $mapDepartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $parm=$request->request->all();
            $duplicateEntity = $em->getRepository('AppBundle:MapDepartment')
                    ->findBy(array(
                'departments' => $parm['appbundle_mapdepartment']['departments'],
                'subDepartment' => $parm['appbundle_mapdepartment']['subDepartment']));
            
            if ($duplicateEntity) {
                $this->addFlash('danger', 'This department already created!');
                return $this->redirectToRoute('mapdepartment_new');
            }
           
            $em->persist($mapDepartment);
            $em->flush();
            $this->addFlash('notice', 'Your changes were saved!');
            return $this->redirectToRoute('mapdepartment_index', array('id' => $mapDepartment->getId()));
        }

        return $this->render('mapdepartment/new.html.twig', array(
                    'mapDepartment' => $mapDepartment,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mapDepartment entity.
     *
     * @Route("/{id}", name="mapdepartment_show")
     * @Method("GET")
     */
    public function showAction(MapDepartment $mapDepartment) {
        $deleteForm = $this->createDeleteForm($mapDepartment);

        return $this->render('mapdepartment/show.html.twig', array(
                    'mapDepartment' => $mapDepartment,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mapDepartment entity.
     *
     * @Route("/{id}/edit", name="mapdepartment_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MapDepartment $mapDepartment) {
        $deleteForm = $this->createDeleteForm($mapDepartment);
        $editForm = $this->createForm('AppBundle\Form\MapDepartmentType', $mapDepartment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mapdepartment_edit', array('id' => $mapDepartment->getId()));
        }

        return $this->render('mapdepartment/edit.html.twig', array(
                    'mapDepartment' => $mapDepartment,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mapDepartment entity.
     *
     * @Route("/{id}", name="mapdepartment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MapDepartment $mapDepartment) {
        $form = $this->createDeleteForm($mapDepartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mapDepartment);
            $em->flush();
        }

        return $this->redirectToRoute('mapdepartment_index');
    }

    /**
     * Creates a form to delete a mapDepartment entity.
     *
     * @param MapDepartment $mapDepartment The mapDepartment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MapDepartment $mapDepartment) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('mapdepartment_delete', array('id' => $mapDepartment->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    public function sub_departmentAction(Request $request) {
        try {
            $departmentId = $request->get('dpt');

            $em = $this->getDoctrine()->getManager();
            $mapDepartments = $em->getRepository('AppBundle:MapDepartment')->findBy(array('departments' => $departmentId));
            //$subDepartments = $mapDepartments[0]->getSubDepartment();
            // var_dump($subDepartments->getSubDepartmentName());die();
            $result = array();
            foreach ($mapDepartments as $mapDepartment) {
                $data = array(
                    'id' => $mapDepartment->getSubDepartment()->getId(),
                    'subDepartmentName' => $mapDepartment->getSubDepartment()->getSubDepartmentName()
                );
                array_push($result, $data);
            }
            echo json_encode($result);
            die();
        } catch (Exception $e) {
            json_encode($e);
        }
    }

}
