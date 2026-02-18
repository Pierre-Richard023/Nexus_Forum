<?php

namespace App\Controller;

use App\Form\ChangePasswordProfileType;
use App\Form\ProfileType;
use App\Form\UserSettingsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/users/profile')]
final class ProfileController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em, private readonly UserPasswordHasherInterface $passwordHasher) {}


    #[Route('/', name: 'profile')]
    public function index(Request $request): Response
    {


        $user = $this->getUser();
        $userSettings = $user->getUserSettings();

        $profileForm = $this->createForm(ProfileType::class, $user);
        $profileForm->handleRequest($request);
        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
            $user->setImageFile(null);

            return $this->redirectToRoute('profile');
        }

        $changePasswordForm = $this->createForm(ChangePasswordProfileType::class);
        $changePasswordForm->handleRequest($request);
        if ($changePasswordForm->isSubmitted() && $changePasswordForm->isValid()) {
            $currentPassword = $changePasswordForm->get('currentPassword')->getData();
            if (!$this->passwordHasher->isPasswordValid($user, $currentPassword)) {
                $changePasswordForm->get('currentPassword')->addError(new FormError('Le mot de passe actuel est incorrect ...'));
            } else {
                $newPassword = $changePasswordForm->get('newPassword')->getData();
                $hashedNewPassword = $this->passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedNewPassword);
                $this->em->persist($user);
                $this->em->flush();
                $this->addFlash('modify_password_success', 'Votre mot de passe a bien été modifier');
                return $this->redirectToRoute('profile');
            }
        }

        $userSettingsForm = $this->createForm(UserSettingsType::class, $userSettings);
        $userSettingsForm->handleRequest($request);
        if ($userSettingsForm->isSubmitted() && $userSettingsForm->isValid()) {
            $this->em->persist($userSettings);
            $this->em->flush();
            return $this->redirectToRoute('profile');
        }


        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'profileForm' => $profileForm,
            'changePasswordForm' => $changePasswordForm,
            'userSettingsForm' => $userSettingsForm,
        ]);
    }

    
    #[Route('/delete', name: 'profile_delete', methods: ['POST'])]
    public function deleteUser(Request $request, TokenStorageInterface $tokenStorage): Response
    {

        $user = $this->getUser();
        if (!$this->isCsrfTokenValid('delete-user', $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $password = $request->request->get('plainpassword');
        if (!$this->passwordHasher->isPasswordValid($user, $password)) {
            $this->addFlash('delete_account_error', 'Mot de passe incorrect impossible de supprimer le compte');
            return $this->redirectToRoute('profile');
        }
        $this->em->remove($user);
        $this->em->flush();

        $tokenStorage->setToken(null);

        $request->getSession()->invalidate();
        return $this->redirectToRoute('home');
    }
}
