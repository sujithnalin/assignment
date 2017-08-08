<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MapDepartmentType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('createdAt')
                ->add('updatedAt')
                ->add('departments', EntityType::class, array('attr' => array(
                        'class' => 'form-control'
                    ),
                    'class' => 'AppBundle:Departments',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('d')
                                ->orderBy('d.departmentName', 'ASC');
                    },
                    'choice_label' => 'Department Name',
                ))
                ->add('subDepartment', EntityType::class, array('attr' => array(
                        'class' => 'form-control'
                    ),
                    'class' => 'AppBundle:SubDepartment',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('d')
                                ->orderBy('d.subDepartmentName', 'ASC');
                    },
                    'choice_label' => 'Sub Department Name',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\MapDepartment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_mapdepartment';
    }

}
