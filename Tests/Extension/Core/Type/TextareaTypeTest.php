<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Tests\Extension\Core\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TextareaTypeTest extends BaseTypeTestCase
{
    public const TESTED_TYPE = TextareaType::class;

    public function testSubmitNull($expected = null, $norm = null, $view = null)
    {
        parent::testSubmitNull($expected, $norm, '');
    }

    public function testSubmitNormalizeCrlf()
    {
        $form = $this->factory->create(static::TESTED_TYPE);
        $form->submit("Line 1\r\nLine 2\r\nLine 3");

        $this->assertSame("Line 1\nLine 2\nLine 3", $form->getData());
    }

    public function testSubmitNormalizeCr()
    {
        $form = $this->factory->create(static::TESTED_TYPE);
        $form->submit("Line 1\rLine 2\rLine 3");

        $this->assertSame("Line 1\nLine 2\nLine 3", $form->getData());
    }

    public function testSubmitNormalizeMixedNewlines()
    {
        $form = $this->factory->create(static::TESTED_TYPE);
        $form->submit("Line 1\r\nLine 2\rLine 3\nLine 4");

        $this->assertSame("Line 1\nLine 2\nLine 3\nLine 4", $form->getData());
    }

    public function testSubmitPreserveLf()
    {
        $form = $this->factory->create(static::TESTED_TYPE);
        $form->submit("Line 1\nLine 2\nLine 3");

        $this->assertSame("Line 1\nLine 2\nLine 3", $form->getData());
    }

    public function testSubmitSingleLine()
    {
        $form = $this->factory->create(static::TESTED_TYPE);
        $form->submit('Single line text');

        $this->assertSame('Single line text', $form->getData());
    }

    public function testBuildViewDoesNotHavePattern()
    {
        $form = $this->factory->create(static::TESTED_TYPE);
        $view = $form->createView();

        $this->assertNull($view->vars['pattern']);
        $this->assertArrayNotHasKey('pattern', $view->vars['attr']);
    }

    public function testWithTrimDisabled()
    {
        $form = $this->factory->create(static::TESTED_TYPE, null, ['trim' => false]);
        $form->submit("  Line 1\r\nLine 2  ");

        $this->assertSame("  Line 1\nLine 2  ", $form->getData());
    }

    public function testWithTrimEnabled()
    {
        $form = $this->factory->create(static::TESTED_TYPE, null, ['trim' => true]);
        $form->submit("  Line 1\r\nLine 2  ");

        $this->assertSame("Line 1\nLine 2", $form->getData());
    }
}
