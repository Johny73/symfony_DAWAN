<?php

namespace App\Form;

use App\Entity\BoardGame;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Nom'])
            ->add('description', null, ['label' => 'Description'])
            ->add('releasedAt', DateType::class, [
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Date de sortie',
                'attr'=> ['max' =>date('Y-m-d')],
            ])
            ->add('ageGroup', IntegerType::class, [
                'label' => 'A partir de ',
                'attr'=> ['min'=>0,]
                ])
            ->add('classifiedIn', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'label' => 'Catégories',
                'required' => false,
    ])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BoardGame::class,
        ]);
    }
}
