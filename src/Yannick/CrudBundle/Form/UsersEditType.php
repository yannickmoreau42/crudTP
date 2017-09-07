<?php

namespace Yannick\CrudBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UsersEditType extends AbstractType
{
     public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->remove('date');
  }

  public function getParent()
  {
    return UsersType::class;
  }


}
