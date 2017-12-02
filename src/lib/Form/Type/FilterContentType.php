<?php

namespace Edgar\EzUIContentsByType\Form\Type;

use EzSystems\EzPlatformAdminUi\Form\Type\ContentType\ContentTypeChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content_type',
                ContentTypeChoiceType::class,
                [
                    'label' => false,
                    'multiple' => false,
                    'expanded' => false,
                ]
            )
            ->add('page', HiddenType::class)
            ->add('limit', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
            ]);
    }
}
