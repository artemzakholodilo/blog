<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
//    private $dataType;
//
//    public function __construct($dataClass)
//    {
//        $this->dataType = $dataClass;
//    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', 'text', [
                         'label' => 'Name',
                         'attr' => [
                             'class' => 'form-control col-lg-6'
                         ]
                     ])
                ->add('comments', 'textarea', [
                    'label' => 'Comment',
                    'attr' => [
                        'class' => 'form-control col-lg-6'
                    ]
                ])
                ->add('approved', 'checkbox', [
                    'label' => 'Approved'
                ])
//                ->add('created', 'date', [
//                    'label' => 'Created at: ',
//                    'attr' => [
//                        'class' => 'col-sm-6 col-sm-offset-3'
//                    ]
//                ])
//                ->add('updated', 'date', [
//                    'label' => 'Updated at: ',
//                    'attr' => [
//                        'class' => 'col-sm-6 col-sm-offset-3'
//                    ]
//                ])
//                ->add('blog')
        ;
    }

//    public function getDefaultOptions(array $options = [])
//    {
//        return ['data_class' => $this->dataType];
//    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\Comment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogger_blogbundle_comment';
    }
}
