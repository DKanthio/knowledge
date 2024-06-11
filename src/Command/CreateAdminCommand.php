<?php

namespace App\Command;

use App\Entity\User;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';

    private $entityManager;
    private $passwordHasher;
    private $emailVerifier;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, EmailVerifier $emailVerifier)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->emailVerifier = $emailVerifier;
    }

    protected function configure()
    {
        $this->setDescription('Create an admin user and send email confirmation.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $question = new Question('Username: ');
        $username = $helper->ask($input, $output, $question);

        $question = new Question('Email: ');
        $email = $helper->ask($input, $output, $question);

        $question = new Question('Password: ');
        $password = $helper->ask($input, $output, $question);

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('diraicha25@gmail.com', 'Aicha'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->context([
                    'username' => $user->getUsername(),
                ])
        );

        $output->writeln('Admin user created and confirmation email sent.');

        return Command::SUCCESS;
    }
}
