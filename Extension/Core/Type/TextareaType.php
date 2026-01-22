<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Core\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Util\StringUtil;

class TextareaType extends AbstractType implements DataTransformerInterface
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer($this);
    }

    /**
     * @return void
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['pattern'] = null;
        unset($view->vars['attr']['pattern']);
    }

    public function getParent(): ?string
    {
        return TextType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'textarea';
    }

    public function transform(mixed $value): mixed
    {
        if (null === $value) {
            return '';
        }

        return $value;
    }

    public function reverseTransform(mixed $value): mixed
    {
        if (!\is_string($value)) {
            return $value;
        }

        if ('' === $value) {
            return null;
        }

        return StringUtil::normalizeNewlines($value);
    }
}
