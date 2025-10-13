<?php

declare(strict_types=1);

/**
 * This file is part of the Nexus Assert library.
 *
 * (c) 2025 John Paul E. Balandan, CPA <paulbalandan@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Nexus\Assert;

final class ExpectationFailedException extends \InvalidArgumentException
{
    /**
     * @param non-empty-string      $template
     * @param array<string, string> $context
     */
    public function __construct(
        private readonly string $template,
        private readonly array $context = [],
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($this->interpolatedMessage(), $code, $previous);
    }

    /**
     * @return non-empty-string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @return array<string, string>
     */
    public function getContext(): array
    {
        return $this->context;
    }

    private function interpolatedMessage(): string
    {
        $message = $this->template;
        $context = [];

        foreach ($this->context as $key => $value) {
            $context[\sprintf('{%s}', $key)] = $value;
        }

        return strtr($message, $context);
    }
}
