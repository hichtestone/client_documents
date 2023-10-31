<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Document;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('licenceFile', FileType::class, [
                'data_class' => null,
                'attr' => [
                    'class'     =>'file-upload-input',
                    'data-file' => '',
                    'onchange'  => 'readURL(this);',
                ],
                'constraints'  => [
                    new File([
                        'maxSize'   => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'text/plain'

                        ],
                        'mimeTypesMessage' => 'Merci de choisir un type correspond a l\'image',
                    ])
                ],
            ])
            ->add('configurationFile', FileType::class, [
                'data_class' => null,
                'attr'       => [
                    'class'     =>'file-upload-input',
                    'data-file' => '',
                    'onchange'  => 'readURL(this);',


                ],
                'constraints' => [
                    new File([
                        'maxSize'   => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/png',
                            'image/jpeg',
                            'image/svg',
                        ],
                        'mimeTypesMessage' => 'Merci de choisir un type correspond a l\'image',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
