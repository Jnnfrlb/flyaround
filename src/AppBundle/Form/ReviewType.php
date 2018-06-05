<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ReviewType extends AbstractType
{

    /**
     * {@inheritdoc} Including all fields from Review entity.
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class, array('attr'=>array('maxlenght'=>250, 'label'=>'Description')))
            ->add('publicationDate', DateType::class, array('data'=>new\DateTime('now')))
            ->add('note', IntegerType::class, array('attr'=>array('min'=>0, 'max'=>5, 'label'=>'note')))
            ->add('agreeTerms', CheckboxType::class, array('mapped'=>false))
            ->add('userRatedId', EntityType::class, array(
                'class'=>'AppBundle\Entity\User',
                'query_builder'=>function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.lastName','ASC');
                },
                'choice_label'=>'lastName'))
            ->add('reviewAuthorId', EntityType::class, array(
                'class'=>'AppBundle\Entity\User',
                'query_builder'=>function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.lastName','ASC');
                }));
    }

    /**
     * {@inheritdoc} Targeting Review entity
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Review',
        ]);
    }


    /**
     * {@inheritdoc} getName() is now deprecated
     */
    public function getBlockPrefix()
    {
        return 'appbundle_review';
    }

}