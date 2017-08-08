<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AuditTrail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Audittrail controller.
 *
 * @Route("audittrail")
 */
class AuditTrailController extends Controller
{
    /**
     * Lists all auditTrail entities.
     *
     * @Route("/", name="audittrail_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $auditTrails = $em->getRepository('AppBundle:AuditTrail')->findAll();

        return $this->render('audittrail/index.html.twig', array(
            'auditTrails' => $auditTrails,
        ));
    }

    /**
     * Creates a new auditTrail entity.
     *
     * @Route("/new", name="audittrail_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $auditTrail = new Audittrail();
        $form = $this->createForm('AppBundle\Form\AuditTrailType', $auditTrail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($auditTrail);
            $em->flush();

            return $this->redirectToRoute('audittrail_index', array('id' => $auditTrail->getId()));
        }

        return $this->render('audittrail/new.html.twig', array(
            'auditTrail' => $auditTrail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a auditTrail entity.
     *
     * @Route("/{id}", name="audittrail_show")
     * @Method("GET")
     */
    public function showAction(AuditTrail $auditTrail)
    {
        $deleteForm = $this->createDeleteForm($auditTrail);

        return $this->render('audittrail/show.html.twig', array(
            'auditTrail' => $auditTrail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing auditTrail entity.
     *
     * @Route("/{id}/edit", name="audittrail_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AuditTrail $auditTrail)
    {
        $deleteForm = $this->createDeleteForm($auditTrail);
        $editForm = $this->createForm('AppBundle\Form\AuditTrailType', $auditTrail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('audittrail_edit', array('id' => $auditTrail->getId()));
        }

        return $this->render('audittrail/edit.html.twig', array(
            'auditTrail' => $auditTrail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a auditTrail entity.
     *
     * @Route("/{id}", name="audittrail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AuditTrail $auditTrail)
    {
        $form = $this->createDeleteForm($auditTrail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($auditTrail);
            $em->flush();
        }

        return $this->redirectToRoute('audittrail_index');
    }

    /**
     * Creates a form to delete a auditTrail entity.
     *
     * @param AuditTrail $auditTrail The auditTrail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AuditTrail $auditTrail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('audittrail_delete', array('id' => $auditTrail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    /**
     * Displays a form to edit an existing auditTrail entity.
     *
     * @Route("/{id}/view", name="audittrail_view")
     * @Method({"GET", "POST"})
     */
    public function viewAction($id){
        $em = $this->getDoctrine()->getManager();
        $auditTrails =  $em->getRepository('AppBundle:AuditTrail')
                ->findBy(array('recordId'=>$id));
        $data=null;
        foreach ($auditTrails as $auditTrail){
            $data[]=array(
                'createdAt'=>$auditTrail->getCreatedAt(),
                'oldValue'=> json_decode($auditTrail->getOldValue()),
                'newValue'=> json_decode($auditTrail->getNewValue())
            );
        }
        return $this->render('audittrail/view.html.twig', array(
            'auditTrails' => $data,
        ));
    }
}
