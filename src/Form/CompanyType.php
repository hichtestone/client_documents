<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class CompanyType extends AbstractType
{
    private  $requeststrack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requeststrack=$requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $requet=$this->requeststrack->getCurrentRequest();
        $route=$requet->attributes->get('_route');
        $required= $route=='company_new';
        $builder
            ->add('name',TextType::class,[
                'label'     =>'Nom de l\'entreprise',
                'required'  => true,
                'attr'      => [
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


            ->add('adresse', TextType::class, [
                'label'         => 'Adresse',
                'required'      => false,
                'attr'          => [
                    'class'     => 'form-control'
                ],
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
                ]
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'FR' => ['France'    => 'La France'],
                    'TN' => ['Tunisie'   => 'La Tunisie'],
                    'BE' => ['Belgique'  => 'La Belgique'],
                    'CA' => ['Cananda'   => 'Le Cananda'],
                    'EE' => ['Estonie'   => 'L\'Estonie'],
                    'DE' => ['Allemagne' => 'L\'Allemagne'],
                    'IE' => ['Irlande'   => 'L\'Irlande'],
                    'IL' => ['Israël'    => 'Israël'],
                    'IT' => ['Italie'    => 'L\'Italie'],
                    'MC' => ['Monaco'    => 'Monaco'],
                    'PT' => ['Portugal'  => 'Le Portugal'],
                    'RO' => ['Roumanie'  => 'La Roumanie'],
                    'SK' => ['Slovaquie' => 'La Slovaquie'],
                    'ES' => ['Espagne'   => 'L\'Espagne'],
                    'SE' => ['Suède'     => 'La Suède'],
                    'CH' => ['Suisse'    => 'La Suisse'],
                    'UK' => ['United Kingdom of Great Britain and Northern Ireland (the)' => 'Royaume-Uni de Grande-Bretagne et d\'Irlande du Nord (le)'],
                    'US' => ['United States of America (the)' => 'Les États-Unis d\'Amérique '],
                ],
                'label'      => 'Pays',
                'required'   => false,
                'attr'       => [
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
            ->add('zipcode', NumberType::class, [
                'label' => 'Code',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('phone', TextType::class, [
                'label'         => 'NUméro du téléphone',
                'required'      => false,
                'attr'          => [
                    'class' => 'form-control'
                ],
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
                ]
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => false,
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
            ->add('city',TextType::class,[
                'label' => 'Ville',
                'required' => false,
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
            ->add('imageFile', FileType::class, [
                'data_class' => null,
                'required' => $required,
                'attr' => [
                    'class' =>'file-upload-input',
                    'data-file' => '',
                    'onchange'=> 'readURL(this);',


                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
