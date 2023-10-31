<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\CompanyInterne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Regex;

class ClientType extends AbstractType
{
    private $requeststrack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requeststrack=$requestStack;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $requet=$this->requeststrack->getCurrentRequest();
        $route=$requet->attributes->get('_route');
        $required= $route=='client_new';
        $builder
            ->add('firstName',TextType::class,[
                'label'=>'Nom Client',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>'Nom',
                ],
                'constraints' => [
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
                ]

            ])
            ->add('lastName',TextType::class,[
                'label'=>'prenom client',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>'prenom',
                ],
                'constraints' => [
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
                ]

            ])
            ->add('Adresse',TextType::class,[
                'label'=>'Adresse',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>'adresse',
                ],
                'constraints' => [
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
                ]

            ])
            ->add('phone')
            //->add('password')
            ->add('city',TextType::class,[
                'label'=>'pays',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>'pays',
                ],
                'constraints' => [
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
                ]

            ])
            ->add('country',TextType::class,[
                'label'=>'ville',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder'=>'ville',
                ],
                'constraints' => [
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
                ]
            ])
            ->add('zipcode')
            ->add('email',EmailType::class,[
                'label'=>'Adresse Email',
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
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
                ]
            ])
            ->add('contrat')


            ->add('companies',EntityType::class,[
                'class'=>Company::class,
                'choice_label' => 'name'
            ]
                )
            ->add('companyInterne',EntityType::class,[
                'class'=>CompanyInterne::class,
                'choice_label' => 'name'
            ])
        ;
        if($required){
            $builder
            ->add('password',PasswordType::class,[
                'label'=>'Mot du passe',
                'required' => $required,
                'attr' => [
                    'class' => 'form-control'
                ],
            ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
