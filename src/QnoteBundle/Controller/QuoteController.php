<?php

namespace QnoteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use QnoteBundle\Entity\Quote;
use QnoteBundle\Form\QuoteType;

/**
 * Quote controller.
 *
 * @Route("/quote")
 */
class QuoteController extends Controller
{

    /**
     * Lists all Quote entities.
     *
     * @Route("/", name="quote")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('QnoteBundle:Quote')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Quote entity.
     *
     * @Route("/{id}/new", name="quote_create")
     * @Method("POST")
     * @Template("QnoteBundle:Quote:new.html.twig")
     */
    public function createAction(Request $request, $id)
    {
        $repo = $this->getDoctrine()->getRepository('QnoteBundle:User');
        $user = $repo->find($id);

        $entity = new Quote();
        $form = $this->createCreateForm($entity, $this->generateUrl('quote_new', ['id' => $id]));
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();

            $entity->setUserId($user);
            $user->addQuote($entity);

            $em->persist($entity);
            $em->flush();
        }


        return $this->redirectToRoute('quote_show', ['id' => $entity->getId()]);
    }

    /**
     * Creates a form to create a Quote entity.
     *
     */
    private function createCreateForm($entity, $action)
    {
        $form = $this->createFormBuilder($entity);
        $form->add('quoteBody', 'text');
        $form->add('quoteAuthor', 'text');
        $form->add('add quote', 'submit', ['label' => 'add new quote']);
        $form->setAction($action);

        $entityForm = $form->getForm();

        return $entityForm;
    }

    /**
     * Displays a form to create a new Quote entity.
     *
     * @Route("/{id}/new", name="quote_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new Quote();
        $entityForm   = $this->createCreateForm($entity, $this->generateUrl('quote_new', ['id' => $id]));

        $repo = $this->getDoctrine()->getRepository('QnoteBundle:User');
        $user = $repo->find($id);

        return ['form' => $entityForm->createView(), 'user' => $user];
    }

    /**
     * Finds and displays a Quote entity.
     *
     * @Route("/{id}", name="quote_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QnoteBundle:Quote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     * @Route("/{id}/edit", name="quote_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QnoteBundle:Quote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quote entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Quote entity.
    *
    * @param Quote $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Quote $entity)
    {
        $form = $this->createForm(new QuoteType(), $entity, array(
            'action' => $this->generateUrl('quote_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Quote entity.
     *
     * @Route("/{id}", name="quote_update")
     * @Method("PUT")
     * @Template("QnoteBundle:Quote:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('QnoteBundle:Quote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('quote_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Quote entity.
     *
     * @Route("/{id}", name="quote_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('QnoteBundle:Quote')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Quote entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('quote'));
    }

    /**
     * Creates a form to delete a Quote entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('quote_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
