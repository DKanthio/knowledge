<?php

namespace App\Controller;

use App\Repository\CertificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CertificationController extends AbstractController
{
    #[Route('/certifications', name: 'user_certifications')]
    public function index(CertificationRepository $certificationRepository)
    {
        $user = $this->getUser();
        // Retrieve certifications associated with the logged-in user
        $certifications = $certificationRepository->findBy(['user' => $user]);

        // Render the certifications page with user certifications
        return $this->render('certifications/index.html.twig', [
            'certifications' => $certifications,
        ]);
    }
}
