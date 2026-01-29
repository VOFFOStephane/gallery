<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ProfileEdtType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class, [
                'label' => 'Votre prénom',
                'attr'  => [
                    "placeholder" => 'Votre prénom'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Votre nom',
                'attr'  => [
                    "placeholder" => 'Votre nom'
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'attr'  => [
                    "placeholder" => 'Votre email'
                ]
            ])
            ->add('imageFile', VichFileType::class,[
                'required' => false,
                'allow_delete' => true,
                'download_uri' => false,
                'asset_helper' => true,
                'label' => 'Image',
            ])
            ;


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
