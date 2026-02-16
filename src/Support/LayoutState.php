<?php

namespace Geosem42\Filamentor\Support;

final class LayoutState
{
    public static function toJsonString(mixed $value): string
    {
        if (is_array($value)) {
            return self::encodeArray($value);
        }

        if (! is_string($value)) {
            return '[]';
        }

        $trimmed = trim($value);

        if ($trimmed === '' || $trimmed === 'null') {
            return '[]';
        }

        json_decode($trimmed, true);

        return json_last_error() === JSON_ERROR_NONE ? $trimmed : '[]';
    }

    public static function toArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode(self::toJsonString($value), true);

        return is_array($decoded) ? $decoded : [];
    }

    private static function encodeArray(array $value): string
    {
        $encoded = json_encode($value);

        return is_string($encoded) ? $encoded : '[]';
    }
}
