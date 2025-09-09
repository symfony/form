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

use Symfony\Contracts\EventDispatcher\Event;

/**
 * @template T
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class FormEvent extends Event
{
    /**
     * @param FormInterface<T> $form The form at the source of the event
     * @param T                $data The data associated with this event
     */
    public function __construct(
        private FormInterface $form,
        protected mixed $data,
    ) {
    }

    /**
     * Returns the form at the source of the event.
     *
     * @return FormInterface<T>
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }

    /**
     * Returns the data associated with this event.
     *
     * @return T
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Allows updating with some filtered data.
     *
     * @param T $data The data associated with this event
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
}
