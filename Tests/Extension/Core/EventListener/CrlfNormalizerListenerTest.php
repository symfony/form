<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Tests\Extension\Core\EventListener;

use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\Extension\Core\EventListener\CrlfNormalizerListener;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormConfigBuilder;
use Symfony\Component\Form\FormEvent;

class CrlfNormalizerListenerTest extends TestCase
{
    public function testNormalizeCrlf()
    {
        $form = new Form(new FormConfigBuilder('name', null, new EventDispatcher()));
        $event = new FormEvent($form, "Line 1\r\nLine 2\r\nLine 3");

        $listener = new CrlfNormalizerListener();
        $listener->preSubmit($event);

        $this->assertSame("Line 1\nLine 2\nLine 3", $event->getData());
    }

    public function testNormalizeCr()
    {
        $form = new Form(new FormConfigBuilder('name', null, new EventDispatcher()));
        $event = new FormEvent($form, "Line 1\rLine 2\rLine 3");

        $listener = new CrlfNormalizerListener();
        $listener->preSubmit($event);

        $this->assertSame("Line 1\nLine 2\nLine 3", $event->getData());
    }

    public function testNormalizeMixedNewlines()
    {
        $form = new Form(new FormConfigBuilder('name', null, new EventDispatcher()));
        $event = new FormEvent($form, "Line 1\r\nLine 2\rLine 3\nLine 4");

        $listener = new CrlfNormalizerListener();
        $listener->preSubmit($event);

        $this->assertSame("Line 1\nLine 2\nLine 3\nLine 4", $event->getData());
    }

    public function testPreserveLf()
    {
        $form = new Form(new FormConfigBuilder('name', null, new EventDispatcher()));
        $event = new FormEvent($form, "Line 1\nLine 2\nLine 3");

        $listener = new CrlfNormalizerListener();
        $listener->preSubmit($event);

        $this->assertSame("Line 1\nLine 2\nLine 3", $event->getData());
    }

    public function testSkipNonStrings()
    {
        $form = new Form(new FormConfigBuilder('name', null, new EventDispatcher()));
        $event = new FormEvent($form, 1234);

        $listener = new CrlfNormalizerListener();
        $listener->preSubmit($event);

        $this->assertSame(1234, $event->getData());
    }

    public function testEmptyString()
    {
        $form = new Form(new FormConfigBuilder('name', null, new EventDispatcher()));
        $event = new FormEvent($form, '');

        $listener = new CrlfNormalizerListener();
        $listener->preSubmit($event);

        $this->assertSame('', $event->getData());
    }

    public function testNoNewlines()
    {
        $data = 'Single line text';
        $form = new Form(new FormConfigBuilder('name', null, new EventDispatcher()));
        $event = new FormEvent($form, $data);

        $listener = new CrlfNormalizerListener();
        $listener->preSubmit($event);

        $this->assertSame('Single line text', $event->getData());
    }

    public function testMultipleConsecutiveNewlines()
    {
        $data = "Line 1\r\n\r\n\r\nLine 2";
        $form = new Form(new FormConfigBuilder('name', null, new EventDispatcher()));
        $event = new FormEvent($form, $data);

        $listener = new CrlfNormalizerListener();
        $listener->preSubmit($event);

        $this->assertSame("Line 1\n\n\nLine 2", $event->getData());
    }
}
