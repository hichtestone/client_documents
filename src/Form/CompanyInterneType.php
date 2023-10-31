<?php

namespace App\Form;

use App\Entity\CompanyInterne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyInterneType extends AbstractType
{
    private $requeststrack;
    public  function __construct(RequestStack $requestStack)
    {
        $this->requeststrack=$requestStack;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $requet=$this->requeststrack->getCurrentRequest();
        $route=$requet->attributes->get('_route');
        $required= $route!='company_interne_edit';
        $builder
            ->add('name')
            ->add('email')

            ->add('adresse')
            ->add('country')
            ->add('city')
            ->add('zipcode')
           // ->add('logo')
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
            'data_class' => CompanyInterne::class,
        ]);
    }
}
