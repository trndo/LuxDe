<?php


namespace App\Form;


use App\Entity\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('phone')
            ->add('email')
            ->add('date')
            ->add('address')
            ->add('instagram')
            ->add('facebook')
            ->add('telegram');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => Settings::class
        ]);
    }


}