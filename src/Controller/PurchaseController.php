<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Purchase;
use App\Entity\Cursus;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PurchaseRepository;

class PurchaseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/purchase', name: 'afficher_purchase')]
    public function show(PurchaseRepository $purchaseRepository, Request $request): Response
    {
        // Get the currently logged-in user
        $user = $this->getUser();

        // Find purchases by the user
        $purchases = $purchaseRepository->findBy(['user' => $user]);

        // Render the purchase page with user's purchases
        return $this->render('purchase/show.html.twig', [
            'purchases' => $purchases,
        ]);
    }
}
