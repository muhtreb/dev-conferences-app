<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\Type\LoginLinkFormType;
use App\Notifier\CustomLoginLinkNotification;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'security_login')]
    public function __invoke(
        UserRepository $userRepository,
        Request $request,
        LoginLinkHandlerInterface $loginLinkHandler,
        NotifierInterface $notifier,
        TranslatorInterface $translator
    ): Response {
        $form = $this->createForm(LoginLinkFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()['email'];
            $user = $userRepository->findOneBy(['email' => $email]);

            if (null === $user) {
                $user = (new User())
                    ->setEmail($email)
                    ->setRoles(['ROLE_USER']);

                $userRepository->save($user);
            }

            $loginLinkDetails = $loginLinkHandler->createLoginLink($user);

            $notification = new CustomLoginLinkNotification(
                $loginLinkDetails,
                $translator->trans('login_link_email.subject')
            );

            $recipient = new Recipient($user->getEmail());

            $notifier->send($notification, $recipient);

            $request->getSession()->set('login_link_email', $email);

            return $this->redirectToRoute('security_login_link_sent');
        }

        return $this->render('security/login.html.twig', [
            'form' => $form,
        ]);
    }
}
