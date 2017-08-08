<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EmployeeType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('employeeName', TextType::class, array('attr' => array(
                        'placeholder' => 'Enter Employee Name',
                        'class' => 'form-control'),
                    'constraints' => array(
                        new NotBlank(array("message" => "Please provide a valid Employee Name")),
                    )
                ))
                ->add('email', TextType::class, array('attr' => array(
                        'placeholder' => 'Enter Employee Name',
                        'class' => 'form-control'),
                    'constraints' => array(
                        new NotBlank(array("message" => "Please provide a valid Employee Name")),
                    )
                ))
                ->add('address', TextType::class, array('attr' => array(
                        'placeholder' => 'Enter Employee Name',
                        'class' => 'form-control'),
                    'constraints' => array(
                        new NotBlank(array("message" => "Please provide a valid Employee Name")),
                    )
                ))
                ->add('createdAt')
                ->add('updatedAt')
                ->add('mapDepartment', EntityType::class, array('attr' => array(
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
            'data_class' => 'AppBundle\Entity\Employee'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_employee';
    }

}
