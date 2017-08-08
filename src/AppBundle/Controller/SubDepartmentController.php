<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SubDepartment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Subdepartment controller.
 *
 * @Route("subdepartment")
 */
class SubDepartmentController extends Controller {

    /**
     * Lists all subDepartment entities.
     *
     * @Route("/", name="subdepartment_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $subDepartments = $em->getRepository('AppBundle:SubDepartment')->findAll();

        return $this->render('subdepartment/index.html.twig', array(
                    'subDepartments' => $subDepartments,
        ));
    }

    /**
     * Creates a new subDepartment entity.
     *
     * @Route("/new", name="subdepartment_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $subDepartment = new Subdepartment();
        $form = $this->createForm('AppBundle\Form\SubDepartmentType', $subDepartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->persist($subDepartment);
                $em->flush();
                $this->addFlash('notice', 'Your changes were saved!');
                return $this->redirectToRoute('subdepartment_index', array('id' => $subDepartment->getId()));
            } catch (Exception $e) {
                $this->addFlash('error', 'Error occured!');
                return $this->redirectToRoute('subdepartment_new');
            }
        }

        return $this->render('subdepartment/new.html.twig', array(
                    'subDepartment' => $subDepartment,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subDepartment entity.
     *
     * @Route("/{id}", name="subdepartment_show")
     * @Method("GET")
     */
    public function showAction(SubDepartment $subDepartment) {
        $deleteForm = $this->createDeleteForm($subDepartment);

        return $this->render('subdepartment/show.html.twig', array(
                    'subDepartment' => $subDepartment,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing subDepartment entity.
     *
     * @Route("/{id}/edit", name="subdepartment_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SubDepartment $subDepartment) {
        $deleteForm = $this->createDeleteForm($subDepartment);
        $editForm = $this->createForm('AppBundle\Form\SubDepartmentType', $subDepartment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('notice', 'Your changes were saved!');
                return $this->redirectToRoute('subdepartment_edit', array('id' => $subDepartment->getId()));
            } catch (Exception $e) {
                $this->addFlash('notice', 'Error occured!');
                return $this->redirectToRoute('subdepartment_edit');
            }
        }

        return $this->render('subdepartment/edit.html.twig', array(
                    'subDepartment' => $subDepartment,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subDepartment entity.
     *
     * @Route("/{id}", name="subdepartment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SubDepartment $subDepartment) {
        $form = $this->createDeleteForm($subDepartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subDepartment);
            $em->flush();
        }

        return $this->redirectToRoute('subdepartment_index');
    }

    /**
     * Creates a form to delete a subDepartment entity.
     *
     * @param SubDepartment $subDepartment The subDepartment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SubDepartment $subDepartment) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('subdepartment_delete', array('id' => $subDepartment->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
