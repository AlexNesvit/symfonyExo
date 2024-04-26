<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{   
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $profile = $user->getProfile();
       if($user->isVerified() == false){
            $this->addFlash('warning', 'Merci de confirmer votre adresse e-mail pour réaliser votre première connexion 🔥💀💀.');
            return $this->redirectToRoute('app_home');
        }elseif($profile == null){
            $profile = new Profile();
            $profile->setIdUser($user);
            $profile->setCreatedAt(new \DateTimeImmutable());
            $profile->setIsActive(true);
        }
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($profile);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_profile');
        }
        return $this->render('profile/index.html.twig', [
            'profile' => $profile,
            'form' => $form->createView()
        ]);
    }
}
