<?php

namespace Edgar\EzUIContentsByType\Form\Type;

use EzSystems\EzPlatformAdminUi\Form\Type\ContentType\ContentTypeChoiceType;
use EzSystems\EzPlatformAdminUi\Form\Type\UniversalDiscoveryWidget\UniversalDiscoveryWidgetType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add(
                'locations',
                UniversalDiscoveryWidgetType::class,
                [
                    'label' => 'edgarez_filtercontentstype.locations',
                    'multiple' => true,
                    'required' => false,
                    'title' => 'edgarez.filtercontentstype.locations',
                ]
            )
            ->add(
                'onlyVisible',
                CheckboxType::class,
                [
                    'required' => false,
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
