<?php

namespace App\Controller;

use App\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        // Get all themes from the database
        $themes = $this->entityManager->getRepository(Theme::class)->findAll();

        // Render the home page with themes
        return $this->render('home/index.html.twig', [
            'themes' => $themes,
        ]);
    }
}
