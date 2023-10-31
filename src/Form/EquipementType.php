<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Equipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class EquipementType extends AbstractType
{
    private $requeststack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requeststack=$requestStack;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $request  = $this->requeststack->getCurrentRequest();
        $route    = $request->attributes->get('_route');
        $required = $route == 'equipement_new' ;
        $builder

            ->add('TYPE', ChoiceType::class, [
                'label' => 'type d\'equipement',
                'choices' => [
                    Equipement::TYPE[Equipement::TYPE_RESEAU]=>Equipement::TYPE_RESEAU,
                    Equipement::TYPE[Equipement::TYPE_PERIPH]=>Equipement::TYPE_PERIPH,
                    Equipement::TYPE[Equipement::TYPE_WEB]=>Equipement::TYPE_WEB,

                ],
                'required' => true,
            ])
            ->add('name',TextType::class,[
                'label'         => 'Nom d\'équipement',
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
                ],
                'required' => true,
            ]);

           $builder ->add('password',PasswordType::class, [
               'label'         => 'Mot de passe',
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
           ]);






        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipement::class,
        ]);
    }
}
