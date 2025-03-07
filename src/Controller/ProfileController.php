<?php

namespace App\Controller;

use App\Dto\PasswordUpdateDto;
use App\Entity\User;
use App\Form\PasswordUpdateType;
use App\Form\UserSelfEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
#[Route('/profile')]
final class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $entityManager, Security $security, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $security->getUser();

        $passwordUpdateDto = new PasswordUpdateDto();
		
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdateDto);
        $form->handleRequest($request);
		
        if ($form->isSubmitted() && $form->isValid()) {
            if (!password_verify($passwordUpdateDto->oldPassword, $user->getPassword())) {
                $this->addFlash('error', 'Ancien mot de passe incorrect.');
                dump('Ancien mot de passe incorrect.');
            } elseif ($passwordUpdateDto->newPassword !== $passwordUpdateDto->confirmPassword) {
                $this->addFlash('error', 'Les nouveaux mots de passe ne correspondent pas.');
                dump('Les nouveaux mots de passe ne correspondent pas.');
            } else {
                dump('Mot de passe mis à jour avec succès.');
                $hashedPassword = $passwordHasher->hashPassword($user, $passwordUpdateDto->newPassword);
                $user->setPassword($hashedPassword);
                $entityManager->flush();
				
                $this->addFlash('success', 'Mot de passe mis à jour avec succès.');
                // return $this->redirectToRoute('app_profile');
            }
        }		

        return $this->render('profile/index.html.twig', [
                'form' => $form->createView(),
        ]);
    }
    
    #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $security->getUser();
        
        $form = $this->createForm(UserSelfEditType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('profile/edit.html.twig', [
                'user' => $user,
                'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_profile_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
