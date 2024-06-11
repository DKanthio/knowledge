<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Purchase;
use App\Entity\User;
use App\Entity\Lesson;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Stripe;

class AcheterController extends AbstractController
{
    private $entityManager;
 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/acheter', name: 'app_acheter')]
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

        $lessonId = $request->query->get('lesson_id');
        $lesson = $this->entityManager->getRepository(Lesson::class)->find($lessonId);

        if (!$lesson) {
            // Add error message if lesson not found and redirect to lesson page
            $this->addFlash('error', 'Leçon introuvable.');
            return $this->redirectToRoute('app_lesson');
        }

        // Render the Stripe payment page with lesson details
        return $this->render('stripe/lessonstripe.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
            'lesson_id' => $lessonId,
            'lesson_price' => $lesson->getPrice()
        ]);
    }

    #[Route('/lesson/create-charge', name: 'app_lesson_charge', methods: ['POST'])]
    public function createCharge(Request $request): Response
    {
        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);

        try {
            $user = $this->getUser();
            $lessonId = $request->request->get('lesson_id');
            $lesson = $this->entityManager->getRepository(Lesson::class)->find($lessonId);

            if (!$lesson) {
                // Add error message if lesson not found and redirect to lesson page
                $this->addFlash('error', 'Leçon introuvable.');
                return $this->redirectToRoute('app_lesson');
            }

            $cursus = $lesson->getCursus();
        
            // Check if i have already purchased a course related to this cursus
            $existingCursusPurchase = $this->entityManager->getRepository(Purchase::class)->findOneBy([
                'user' => $user,
                'cursus' => $cursus,
            ]);
    
            if ($existingCursusPurchase) {
                // If i have already purchased a course related to this cursus, show appropriate message
                $this->addFlash('info', 'Vous avez déjà acheté le cursus lié à cette leçon.');
                return $this->render('includes/info.html.twig', []);
            }

            // Check if i have already purchased this specific lesson
            $existingLessonPurchase = $this->entityManager->getRepository(Purchase::class)->findOneBy([
                'user' => $user,
                'lesson' => $lesson,
            ]);
    
            if ($existingLessonPurchase) {
                // If i have already purchased this lesson, show appropriate message
                $this->addFlash('info', 'Vous avez déjà acheté cette leçon.');
                return $this->render('includes/remarque.html.twig', []);
            }

            // Create a new charge
            $amount = $lesson->getPrice() * 100;
            Stripe\Charge::create([
                "amount" => $amount,
                "currency" => "usd",
                "source" => $request->request->get('stripeToken'),
                "description" => "Binaryboxtuts Payment Test"
            ]);

            // Record the purchase in the database
            $purchase = new Purchase();
            $purchase->setUser($user);
            $purchase->setCreatedAt(new \DateTime());
            $purchase->setLesson($lesson);

            $this->entityManager->persist($purchase);
            $this->entityManager->flush();

            // Add success message
            $this->addFlash('success', 'Payment Successful!');

        } catch (\Exception $e) {
            // Add error message if payment fails
            $this->addFlash('error', 'Payment Failed: ' . $e->getMessage());
        }

        return $this->redirectToRoute('lesson', ['id' => $lessonId]);

    }
}
