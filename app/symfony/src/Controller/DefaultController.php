<?php

namespace App\Controller;

use App\Form\UserRemoveType;
use App\Form\UserType;
use App\Manager\UserManager;
use App\Services\RedisService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param UserManager $userManager
     * @param Request $request
     * @return Response
     */
    public function index(UserManager $userManager, RedisService $redisService, Request $request)
    {
        $form = $this->createForm(UserType::class, null);
        $formRemove = $this->createForm(UserRemoveType::class, null);
        $form->handleRequest($request);
        $formRemove->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager->create($form->getData());

            $this->redirectToRoute('home');
        }

        if ($formRemove->isSubmitted() && $formRemove->isValid()) {
            $userManager->redis_remove($formRemove->getData());

            $this->redirectToRoute('home');
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'formRemove' => $formRemove->createView(),
            'items' => $redisService->allItems()
        ]);
    }
}
