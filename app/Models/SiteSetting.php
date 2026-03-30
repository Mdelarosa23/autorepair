<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, ?string $default = null): ?string
    {
        if (! Schema::hasTable('site_settings')) {
            return $default;
        }

        return static::query()->where('key', $key)->value('value') ?? $default;
    }

    public static function setValue(string $key, string $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function themeSettings(): array
    {
        return [
            'light_accent' => static::getValue('light_accent', '#fdb819'),
            'light_background' => static::getValue('light_background', '#ffffff'),
            'light_text' => static::getValue('light_text', '#000000'),
            'dark_accent' => static::getValue('dark_accent', '#fdb819'),
            'dark_background' => static::getValue('dark_background', '#1d1d1d'),
            'dark_text' => static::getValue('dark_text', '#ffffff'),
        ];
    }
}
