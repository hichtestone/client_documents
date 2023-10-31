<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyInterne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request): Response
    {
  //  dd($this->getUser()->getCompanyInterne()->getId());
        $roles=$this->getUser()->getRoles();
        if(array_search("ROLE_SUPER_ADMIN", $roles) !== false ){
            $compnaies=$this->getDoctrine()->getRepository(CompanyInterne::class)->findAll();
            return $this->render('home/index.html.twig', [
                'compnaies' => $compnaies,
            ]);
        }
      else {

          $session = $request->getSession();
          $session->set('companyInterne', $this->getUser()->getCompanyInterne()->getId());
          return $this->redirectToRoute("client");
      }


    }

    /**
     * @Route("/{id}/client_with_company", name="clients_with_company")
     * @param CompanyInterne $companyInterne
     */
    public function clients_liste(CompanyInterne $companyInterne, Request $request )
    {
        $session = $request->getSession();
        $session->set('companyInterne', $companyInterne->getId());
        //dd($session->get('companyInterne'));
        return $this->redirectToRoute("client");
    }

    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('rannoumtaallah@gmail.com')
            ->to('rannoumtaallah@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        // ...
    }
}
