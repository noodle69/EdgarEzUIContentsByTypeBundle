<?php

namespace Edgar\EzUIContentsByType\Form\Factory;

use Edgar\EzUIContentsByType\Form\Data\FilterContentData;
use Edgar\EzUIContentsByType\Form\Type\FilterContentType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormFactory
{
    /** @var FormFactoryInterface $formFactory */
    protected $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function filterContent(
        FilterContentData $data,
        ?string $name = null
    ): ?FormInterface {
        return $this->formFactory->createNamed(
            $name,
            FilterContentType::class,
            $data,
            [
                'method' => Request::METHOD_GET,
                'csrf_protection' => false,
            ]
        );
    }
}
