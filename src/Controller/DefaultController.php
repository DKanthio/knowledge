<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Theme;

class DefaultController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/discover-cursus/{id}', name: 'discover_cursus')]
    public function discoverCursus(int $id): Response
    {
        // Get the theme associated with the given ID
        $theme = $this->entityManager->getRepository(Theme::class)->find($id);

        // Render the discover cursus page with theme details
        return $this->render('default/discover_cursus.html.twig', [
            'theme' => $theme,
        ]);
    }
}
