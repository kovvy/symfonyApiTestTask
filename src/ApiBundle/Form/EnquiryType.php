<?php

namespace ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('headers');
        $builder->add('body');
        $builder->add('route');
        $builder->add('method');
        $builder->add('ip');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'ApiBundle\Entity\Request',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'request';
    }
}
