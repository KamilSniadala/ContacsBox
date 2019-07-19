<?php
/**
 * Created by PhpStorm.
 * User: amazon
 * Date: 7/5/19
 * Time: 1:00 PM
 */

namespace ContactsBoxBundle\Form;


use ContactsBoxBundle\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('Street', TextType::class)
            ->add('Number', TextType::class)
            ->add('zip_code', TextType::class)
            ->add('country', CountryType::class,
                ['placeholder' => 'Choose an option',])
            ->add('Save', SubmitType::class,[
                'label' => 'Create address'
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class'=>Address::class]
        );
    }
}