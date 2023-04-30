<?php

namespace App\Form;

use App\Entity\Traza;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrazaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('timestamp')
            ->add('timeproxy')
            ->add('ip')
            ->add('resultCacheCode')
            ->add('lenghtContent')
            ->add('method')
            ->add('url')
            ->add('username')
            ->add('proxyHierarcheRoute')
            ->add('contentType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Traza::class,
        ]);
    }
}
