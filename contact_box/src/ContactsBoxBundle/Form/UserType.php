<?php
namespace ContactsBoxBundle\Form;

use ContactsBoxBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('age',IntegerType::class, array(
                'attr' => array('min' => 1, 'max' => 100)
            ))
            ->add('sex',ChoiceType::class,['choices'=>
                [
                    'male' => 1,
                    'female' => 0
                ]])
            ->add('portrait', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create post']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => User::class]
        );
    }
}