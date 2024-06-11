<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Theme;
use App\Entity\Lesson;
use App\Entity\Purchase;
use App\Entity\Cursus;

class ActivationController extends AbstractController
{
    private $entityManager;
 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/curcus/{id}', name: 'curcus')]
    public function curcusPage(int $id, EntityManagerInterface $entityManager): Response
    {
        $cursus = $entityManager->getRepository(Cursus::class)->find($id);

        if (!$cursus) {
            // Throw exception if cursus not found
            throw $this->createNotFoundException('Le cursus n\'existe pas');
        }
    
        // Get the theme associated with the cursus
        $theme = $cursus->getTheme();
    
        if (!$theme) {
            // Throw exception if theme not found
            throw $this->createNotFoundException('Le thème n\'existe pas');
        }
    
        // Render the cursus page with theme and cursus details
        return $this->render('default/curcus.html.twig', [
            'theme' => $theme,
            'cursus' => $cursus,
        ]);
    }
    
    #[Route('/lesson/{id}', name: 'lesson')]
    public function lessonPage(int $id, EntityManagerInterface $entityManager): Response
    {
        $lesson = $entityManager->getRepository(lesson::class)->find($id);
      
        if (!$lesson) {
            // Throw exception if lesson not found
            throw $this->createNotFoundException('La leçon n\'existe pas');
        }

        // Get the cursus associated with the lesson 
        $cursus = $lesson->getCursus();
    
        if (!$cursus) {
            // Throw exception if cursus not found
            throw $this->createNotFoundException('Le cursus n\'existe pas');
        }
    
        // Render the lesson page with lesson and cursus details
        return $this->render('default/lesson.html.twig', [
            'lesson' => $lesson,
            'cursus' => $cursus,
        ]);

    }

    #[Route('/activation-compte', name: 'activation_page')]
    public function activationPage(): Response
    {
        // Render the account activation page
        return $this->render('activation/activation_page.html.twig');
    }

    #[Route('/option', name: 'option_connexion')]
    public function optionPage(): Response
    {
        // Render the login option page
        return $this->render('activation/option.html.twig');
    }
}
