<?php
/**
 * Created by PhpStorm.
 * User: amazon
 * Date: 7/12/19
 * Time: 11:37 AM
 */

namespace ContactsBoxBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('save', SubmitType::class,['label' => 'Add new group']);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver ->setDefaults(['data_class' => 'ContactsBoxBundle\Entity\Groups']);
    }
}