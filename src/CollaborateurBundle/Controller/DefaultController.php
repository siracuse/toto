<?php

namespace CollaborateurBundle\Controller;

use CollaborateurBundle\Entity\Collab;
use CollaborateurBundle\Form\CollabType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collab")
 */
class DefaultController extends Controller
{
    /**
     * @Route(name="index-collab")
     */
    public function indexCollab()
    {
        $collabs = $this->getDoctrine()->getManager()->getRepository('CollaborateurBundle:Collab')->findAll();
        return $this->render('indexCollab.html.twig', [
            'collabs' => $collabs
        ]);
    }
    /**
     * @Route ("/new", name="new-collab")
     */
    public function newCollab(Request $request)
    {
        $collab = new Collab();
        $collabForm = $this->createForm(CollabType::class, $collab);

        if ($request->isMethod('POST') && $collabForm->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($collab);
            $em->flush();
        }
        return $this->render('newcollab.html.twig', [
            'form' => $collabForm->createView()
        ]);
    }
    /**
     * @Route("/edit/{id}", name="edit-collab")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editCollab($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $collab = $em->getRepository('CollaborateurBundle:Collab')->find($id);
        $collabForm = $this->createForm(CollabType::class, $collab);

        if ($request->isMethod('POST') && $collabForm->handleRequest($request)->isValid()) {
            $em->flush();
            return $this->redirectToRoute('index-collab');
        }

        return $this->render('edit.html.twig', [
            'form' => $collabForm->createView()
        ]);
    }
    /**
     * @Route ("/delete/{id}", name="delete-collab")
     */
    public function deleteCollab($id)
    {
        $em = $this->getDoctrine()->getManager();
        $collab = $em->getRepository('CollaborateurBundle:Collab')->find($id);
        $em->remove($collab);
        $em->flush();

        return $this->redirectToRoute('index-collab');
    }
}
