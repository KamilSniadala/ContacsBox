<?php
/**
 * Created by PhpStorm.
 * User: amazon
 * Date: 7/12/19
 * Time: 1:17 PM
 */

namespace ContactsBoxBundle\Form;


use ContactsBoxBundle\Entity\Groups;
use ContactsBoxBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersAndGroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod("POST")
            ->add('groups', EntityType::class,
                [
                    'class' => Groups::class,
                    'choice_label' => 'name',
                    'expanded' => true,
                    'multiple' => true
                ])
            ->add('save', SubmitType::class,
                [
                    'label' => 'Save'
                ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class
            ]);
    }
}