<?php

namespace Yannick\CrudBundle\Form;

use Yannick\CrudBundle\Repository\DepartementsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $pattern = '%';
        $builder
        ->add('username', TextType::class)
        ->add('email', TextType::class)
        ->add('RefDep', EntityType::class, array(
          'class'      => 'YannickCrudBundle:Departements',
          'choice_label' => 'nom',
          'multiple' => false,
          'query_builder' => function(DepartementsRepository $repository) use ($pattern){
            return $repository->getLikeQueryBuilder($pattern);
          }
          ))
        ->add('Valider', SubmitType::class);

       $builder->addEventListener(
      FormEvents::PRE_SET_DATA,
      function(FormEvent $event) {
        $user = $event->getData();

                if(null === $user){
                    return;
                }
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yannick\CrudBundle\Entity\Users'
        ));
    }


}
