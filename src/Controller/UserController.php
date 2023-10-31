<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @Route("/user")

 */
class UserController extends AbstractController
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;

    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $roles=$this->getUser()->getRoles();
        if(array_search("ROLE_SUPER_ADMIN", $roles)!== false){
            $users=$userRepository->findAll();
        }else{
            $users=$userRepository->findBy(['companyInterne'=>$this->getUser()->getCompanyInterne()->getId()]);
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $encodedPassword = $this->encoder->hashPassword($user, $form->get("password")->getData());
            $role=$form->get("isAdmin")->getData();
            $user->setPassword($encodedPassword);
               if($role==-1){
                   $user->setRoles(["ROLE_USER_ALTRA"]);
                   $user->setIsAdmin(0);
               }
               elseif ($role==-2){
                   $user->setRoles(["ROLE_USER_IDS"]);
                   $user->setIsAdmin(0);

               }
               elseif ($role==0){
                   $user->setRoles(["ROLE_ADMIN_IDS"]);
                   $user->setIsAdmin(1);

               }
               else{
                   $user->setRoles(["ROLE_ADMIN_ALTRA"]);
                   $user->setIsAdmin(1);

               }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route ("/{id}/archive", name="user_archive", methods={"GET","POST"})
     */
    public function archive(User $user)
    {
        $user->setDeletedAt(new \DateTime());
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route ("/{id}/desarchive", name="user_desarchive", methods={"GET","POST"})
     */
    public function desarchive(User $user)
    {
        $user->setDeletedAt(null);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route ("/activation/{token}", name="activation")
     */
    public function activation($token, UserRepository $repository)
    {
        $user=$repository->findOneBy(['activationToken'=>$token]);

        if(!$user){
            throw $this->createNotFoundException("cet user n\'existe pas");
        }
    }
}
