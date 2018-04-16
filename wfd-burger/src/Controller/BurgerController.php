<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Form\BurgerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/burger", name="burger_con_")
 */
class BurgerController extends Controller
{
    /**
     * @Route("/", name="index")
     *
     * @return Response
     */
    public function index()
    {
        $burgers = $this->getDoctrine()
            ->getRepository(Burger::class)
            ->findAll();

        return $this->render('burger_con/index.html.twig', ['burgers' => $burgers]);
    }

    /**
     * @Route("/new", name="new")
     * @Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $burger = new Burger();
        $form = $this->createForm(BurgerType::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($burger);
            $em->flush();

            return $this->redirectToRoute('burger_con_edit', ['id' => $burger->getId()]);
        }

        return $this->render('burger_con/new.html.twig', [
            'burger' => $burger,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show")
     * @Method("GET")
     */
    public function show(Burger $burger)
    {
        return $this->render('burger_con/show.html.twig', [
            'burger' => $burger,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Burger $burger)
    {
        $form = $this->createForm(BurgerType::class, $burger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('burger_con_edit', ['id' => $burger->getId()]);
        }

        return $this->render('burger_con/edit.html.twig', [
            'burger' => $burger,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete")
     * @Method("DELETE")
     */
    public function delete(Request $request, Burger $burger)
    {
        if (!$this->isCsrfTokenValid('delete'.$burger->getId(), $request->request->get('_token'))) {
            return $this->redirectToRoute('burger_con_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($burger);
        $em->flush();

        return $this->redirectToRoute('burger_con_index');
    }
}
