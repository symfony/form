<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Flow\DataStorage;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Yonel Ceruto <open@yceruto.dev>
 */
class SessionDataStorage implements DataStorageInterface
{
    public function __construct(
        private readonly string $key,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function save(object|array $data): void
    {
        $this->requestStack->getSession()->set($this->key, unserialize(serialize($data)));
    }

    public function load(object|array|null $default = null): object|array|null
    {
        if (null === $data = $this->requestStack->getSession()->get($this->key)) {
            return $default;
        }

        // Deep clone to decouple the returned data from the session's internal storage
        return unserialize(serialize($data));
    }

    public function clear(): void
    {
        $this->requestStack->getSession()->remove($this->key);
    }
}
