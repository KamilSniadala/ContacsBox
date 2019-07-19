<?php
/**
 * Created by PhpStorm.
 * User: amazon
 * Date: 7/12/19
 * Time: 9:39 AM
 */

namespace ContactsBoxBundle\Form;


use ContactsBoxBundle\Entity\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneNumberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod("POST")
            ->add('number',TelType::class)
            ->add('save', SubmitType::class,['label'=>'Add phone number']);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>PhoneNumber::class]);
    }
}