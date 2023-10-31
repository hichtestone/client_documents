<?php

namespace App\Form;

use App\Entity\CompanyInterne;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    private $requeststrack;
    private $token;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $token)
    {
        $this->requeststrack=$requestStack;
        $this->token=$token;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $requet=$this->requeststrack->getCurrentRequest();
        $route=$requet->attributes->get('_route');
        $roles=$this->token->getToken()->getUser()->getRoles();


    //   dd( $roles);
        $choices=[];
       if(array_search("ROLE_ADMIN_IDS", $roles)!== false){
           $company=$this->token->getToken()->getUser()->getCompanyInterne()->getId();
           $query=function (EntityRepository $er) use($company) {
               return $er->createQueryBuilder('c')
                   ->where('c.id = :id')
                   ->setParameter('id',$company)
                   ->orderBy('c.name', 'ASC')
                   ;
           };
           // dd("AI");
            $choices=[

                "Utilisateur_IDS"=>"-2",

                'ADMIN_IDS' => "0",
            ];
        }

        elseif(array_search("ROLE_ADMIN_ALTRA", $roles) !== false){
            $company=$this->token->getToken()->getUser()->getCompanyInterne()->getId();
            $query=function (EntityRepository $er) use($company) {
                return $er->createQueryBuilder('c')
                    ->where('c.id = :id')
                    ->setParameter('id',$company)
                    ->orderBy('c.name', 'ASC')
                    ;
            };
          //  dd("AA");
            $choices=[
                "Utilisateur_Altra"=>"-1",

                'ADMIN_ALTRA' => "1",

            ];
        }
        else{
            $company=$this->requeststrack->getSession()->get('companyInterne');
            $query=function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC')
                    ;
            };//    dd('sa');
            $choices=[
                "Utilisateur_Altra"=>"-1",
                "Utilisateur_IDS"=>"-2",
                'ADMIN_ALTRA' => "1",
                'ADMIN_IDS' => "0",
            ];
        }
     //   dd( $choices);
        $required= $route=='user_new';
        $builder
            ->add('userName',TextType::class,[
                'label'=>'Nom Utilisateur',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>'userNAme',
                ],

            ])
            ->add('email',EmailType::class,[
                'label'=>'Adresse Email',
                'required' => true,
                'constraints'   => [
                    new Regex(
                        array(
                            'pattern' =>'/^((?!<script)[\s\S])*$/',
                            'message' => 'cette valeur n\'est pas valide ',
                        )
                    ),
                    new Regex(
                        array(
                            'pattern' =>'/^((?!<img)[\s\S])*$/',
                            'message' => 'cette valeur n\'est pas valide ')
                    ),
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('password',PasswordType::class,[
                'label'=>'Mot du passe',
                'required' => $required,
                'constraints'   => [
                    new Regex(
                        array(
                            'pattern' =>'/^((?!<script)[\s\S])*$/',
                            'message' => 'cette valeur n\'est pas valide ',
                        )
                    ),
                    new Regex(
                        array(
                            'pattern' =>'/^((?!<img)[\s\S])*$/',
                            'message' => 'cette valeur n\'est pas valide ')
                    ),
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('companyInterne',EntityType::class,[
                'label' => 'Choix du centre',
                'empty_data' => '',
                'attr'  => [
                    'class' => 'js-example-basic-single form-control',
                    'required' => false,

                ],
                'class' => CompanyInterne::class,
                'query_builder' => $query,
                'choice_label' => 'name'
            ])
            ->add('isAdmin', ChoiceType::class, [
                'label' => 'type d\'equipement',
                'attr'  => [
                    'class' => 'js-example-basic-single form-control',

                ],
                'choices' => $choices,

                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
