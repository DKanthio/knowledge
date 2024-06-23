<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Purchase;
use App\Entity\User;
use App\Entity\Cursus;
use App\Entity\Lesson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Stripe;

class CurcusController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/curcus', name: 'app_curcus')]
    public function index(Request $request): Response
    {
        if (!$this->getUser()) {
            // Redirect to login option page if i am not logged in
            return $this->redirectToRoute('option_connexion');
        }

        if (!$this->getUser()->isVerified()) {
            // Redirect to account activation page if my account is not verified
            $this->addFlash('warning', 'Votre compte doit être activé pour effectuer des achats.');
            return $this->redirectToRoute('activation_page');
        }

        $cursusId = $request->query->get('cursus_id');
        $cursus = $this->entityManager->getRepository(Cursus::class)->find($cursusId);

        if (!$cursus) {
            // Add error message if cursus not found and redirect to cursus page
            $this->addFlash('error', 'Cursus introuvable.');
            return $this->redirectToRoute('app_curcus');
        }

        // Render the Stripe payment page with cursus details
        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
            'cursus_id' => $cursusId,
            'cursus_price' => $cursus->getPrice()
        ]);
    }

    #[Route('/cursus/create-charge', name: 'app_cursus_charge', methods: ['POST'])]
    public function createCharge(Request $request): Response
    {
        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);

        try {
            $user = $this->getUser();
            $cursusId = $request->request->get('cursus_id');
            $cursus = $this->entityManager->getRepository(Cursus::class)->find($cursusId);

            if (!$cursus) {
                // Add error message if cursus not found and redirect to cursus page
                $this->addFlash('error', 'Cursus introuvable.');
                return $this->redirectToRoute('app_curcus');
            }

            // Check if i have already purchased this cursus
            $existingPurchase = $this->entityManager->getRepository(Purchase::class)->findOneBy([
                'user' => $user,
                'cursus' => $cursus,
            ]);

            if ($existingPurchase) {
                // If i have already purchased this cursus, show appropriate message
                return $this->render('includes/alerte.html.twig', []);
            }

            // Create a new charge
            $amount = $cursus->getPrice() * 100;
            Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "eur",
                "source" => $request->request->get('stripeToken'),
                "description" => "Binaryboxtuts Payment Test"
            ]);

            // Record the purchase in the database
            $purchase = new Purchase();
            $purchase->setUser($user);
            $purchase->setCreatedAt(new \DateTime());
            $purchase->setCursus($cursus);

            $this->entityManager->persist($purchase);
            $this->entityManager->flush();

            // Add success message
            $this->addFlash('success', 'Payment Successful!');

        } catch (\Exception $e) {
            // Add error message if payment fails
            $this->addFlash('error', 'Payment Failed: ' . $e->getMessage());
        }

        return $this->redirectToRoute('curcus', ['id' => $cursusId]);
    }
}
