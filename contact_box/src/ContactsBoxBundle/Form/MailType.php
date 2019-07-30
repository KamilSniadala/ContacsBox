<?php
/**
 * Created by PhpStorm.
 * User: amazon
 * Date: 7/12/19
 * Time: 9:09 AM
 */

namespace ContactsBoxBundle\Form;


use ContactsBoxBundle\Entity\Mail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('name', EmailType::class)
            ->add('save', SubmitType::class,
                ['label' => 'Add email']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['dataclass' => Mail::class]);
    }
}