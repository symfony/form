<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @template T
 *
 * @implements FormTypeInterface<T>
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
abstract class AbstractType implements FormTypeInterface
{
    public function getParent(): ?string
    {
        return FormType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    /**
     * @param FormBuilderInterface<T> $builder
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    /**
     * @param FormView<T>      $form
     * @param FormInterface<T> $view
     */
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
    }

    /**
     * @param FormView<T>      $form
     * @param FormInterface<T> $view
     */
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
    }

    public function getBlockPrefix(): string
    {
        return StringUtil::fqcnToBlockPrefix(static::class) ?: '';
    }
}
