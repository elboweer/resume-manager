<?php


namespace App\Form;


use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'entity.company.title',
            ])
            ->add('address', TextareaType::class, [
                'label' => 'entity.company.address',
            ])
            ->add('site', TextType::class, [
                'label' => 'entity.company.site',
            ])
            ->add('phone', TelType::class, [
                'label' => 'entity.company.phone',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Company::class,
            ]);
    }
}