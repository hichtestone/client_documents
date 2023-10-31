<?php

namespace App\Form;

use App\Entity\Infrastructure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;


class InfrastructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', TextType::class, [
                'label'         => 'Site',
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
            ->add('nomSvr', TextType::class, [
                'label'         => 'Nom de serveur',
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
            ->add('OS', TextType::class, [
                'label'         => 'OS',
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
            ->add('CPU_PROC', TextType::class, [
                'label'         => 'CPU',
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
            ->add('RAM', TextType::class, [
                'label'         => 'RAM',
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
            ->add('totalDisque', TextType::class, [
                'label'         => 'Toal Disque',
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
            ->add('DisqueUsed', TextType::class, [
                'label'         => 'Disque utilisé',
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
            ->add('IP', TextType::class, [
                'label'         => 'IP',
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
            ->add('HYPERV',ChoiceType::class,[
                'label'         => 'HyperV',
                'required'      => false,
                'attr'          => [
                    'class'     => 'form-control'
                ],
                'choices' => [
                    'VM' => ['VM' => 'Machine Virtuel'],
                    'HYPERV' => ['HYPERV' => 'Hyperviseur'],
                ],
            ])
            ->add('nominal', TextType::class, [
                'label'         => 'Nominal',
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

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Infrastructure::class,
        ]);
    }
}
