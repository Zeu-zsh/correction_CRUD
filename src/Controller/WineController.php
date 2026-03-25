<?php

namespace App\Controller;

use App\Entity\Wine;
use App\Form\WineType;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WineController extends AbstractController
{
    #[Route('/wine', name: 'app_wine_index')]
    public function index(WineRepository $wineRepository): Response
    {
        return $this->render('wine/index.html.twig', [
            'wines' => $wineRepository->findAll(),
        ]);
    }

    #[Route('/wine/new', name: 'app_wine_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $wine = new Wine();
        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // dump($wine);
            $em->persist($wine);
            $em->flush();
            // dump($wine);
        }

        return $this->render('wine/new.html.twig', [
            'wine_form' => $form,
        ]);
    }

    #[Route('/wine/edit/{id}', name: 'app_wine_edit')]
    public function edit(Wine $wine, Request $request, EntityManagerInterface $em): Response
    {
        // $wine = $wineRepository->find($id);
        $form = $this->createForm(WineType::class, $wine);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            // dump($wine);
            $em->persist($wine);
            $em->flush();
            // dump($wine);
        }
        return $this->render('wine/new.html.twig', [
            'wine_form' => $form,
        ]);
    }

    #[Route('/wine/delete/{id}', name: 'app_wine_delete')]
    public function delete(Wine $wine, EntityManagerInterface $em): Response
    {
        $em->remove($wine);
        $em->flush();
        return $this->redirectToRoute("app_wine_index");
    }
}
