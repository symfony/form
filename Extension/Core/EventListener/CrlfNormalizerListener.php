<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Extension\Core\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Util\StringUtil;

/**
 * @author Alexandre Daubois <alex.daubois@gmail.com>
 */
class CrlfNormalizerListener implements EventSubscriberInterface
{
    public function preSubmit(FormEvent $event): void
    {
        if (!\is_string($data = $event->getData())) {
            return;
        }

        $event->setData(StringUtil::normalizeNewlines($data));
    }

    public static function getSubscribedEvents(): array
    {
        return [FormEvents::PRE_SUBMIT => 'preSubmit'];
    }
}
