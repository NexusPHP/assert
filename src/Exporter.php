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

final class Exporter
{
    public function exportValue(mixed $value): string
    {
        if (\is_array($value)) {
            if ([] === $value) {
                return '[]';
            }

            if (array_is_list($value)) {
                return \sprintf(
                    '[%s]',
                    implode(', ', array_map(fn(mixed $v): string => $this->exportValue($v), $value)),
                );
            }

            $items = [];

            foreach ($value as $k => $v) {
                $items[] = \sprintf('%s => %s', $this->exportValue($k), $this->exportValue($v));
            }

            return \sprintf('[%s]', implode(', ', $items));
        }

        if (\is_object($value)) {
            if ($value instanceof \DateTimeInterface) {
                return \sprintf('object(%s(%s))', $this->exportType($value), $value->format(\DateTimeInterface::ATOM));
            }

            if (enum_exists($value::class) && $value instanceof \UnitEnum) {
                return \sprintf('enum(%s::%s)', $this->exportType($value), $value->name);
            }

            return \sprintf('object(%s)', $this->exportType($value));
        }

        if (null === $value) {
            return 'null';
        }

        if (\is_scalar($value)) {
            return var_export($value, true);
        }

        return $this->exportType($value);
    }

    public function exportType(mixed $value): string
    {
        return get_debug_type($value);
    }
}
