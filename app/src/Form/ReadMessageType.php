<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ReadMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('identifier', TextType::class, [
                'attr' => [
                    'style' => 'width: 300px; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;',
                ],
            ])
            ->add('decryption_key', TextType::class, [
                'attr' => [
                    'style' => 'width: 300px; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;',
                ],
            ]);
    }
}
