<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Certification;

class LessonController extends AbstractController
{
    #[Route('/lesson/{id}/validate', name: 'validate_lesson', methods: ['POST'])]
    public function validateLesson($id, LessonRepository $lessonRepository, EntityManagerInterface $em): Response
    {
        $lesson = $lessonRepository->find($id);
        if (!$lesson) {
            // Throw an exception if i do not find the lesson
            throw $this->createNotFoundException('Leçon non trouvée');
        }

        // Set the lesson as validated
        $lesson->setIsValidated(true);
        $em->persist($lesson);
        $em->flush();

        // Check if all lessons in the cursus are validated
        $cursus = $lesson->getCursus();
        $allLessonsValidated = true;
        foreach ($cursus->getLessons() as $cursusLesson) {
            if (!$cursusLesson->getIsValidated()) {
                $allLessonsValidated = false;
                break;
            }
        }

        if ($allLessonsValidated) {
            // Create a certification for the user if all lessons are validated
            $certification = new Certification();
            $certification->setUser($this->getUser());
            $certification->setCursus($cursus);
            $certification->setAwardedAt(new \DateTime());

            $em->persist($certification);
            $em->flush();
        }

        // Redirect to the home page after validation
        return $this->redirectToRoute('home');
    }
}
