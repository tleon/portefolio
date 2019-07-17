<?php

namespace App\Form;

use App\Entity\Attachments;
use App\Entity\Projects;
use App\Entity\Tools;
use App\Repository\AttachmentsRepository;
use App\Repository\ToolsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('link')
            ->add('attachment', EntityType::class, [
                'class' => Attachments::class,
                'choice_label' => 'label'
            ])
            ->add('tools', EntityType::class, [
                'class' => Tools::class,
                'choice_label' => 'label',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
