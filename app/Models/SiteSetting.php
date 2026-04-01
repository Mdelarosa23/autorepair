<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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

    public static function contactSettings(): array
    {
        $callNowNumber = static::getValue('call_now_number', '615-705-0737');
        $towingServiceNumber = static::getValue('towing_service_number', '615-767-4200');

        return [
            'call_now_number' => $callNowNumber,
            'call_now_href' => static::phoneHref($callNowNumber),
            'request_tow_url' => static::getValue('request_tow_url', 'https://public.towbook.com/PO3A'),
            'request_tow_label' => static::getValue('request_tow_label', 'REQUEST A TOW'),
            'towing_service_number' => $towingServiceNumber,
            'towing_service_href' => static::phoneHref($towingServiceNumber),
            'working_hours' => static::getValue('working_hours', 'Mon-Sat: 8AM - 6PM'),
        ];
    }

    protected static function phoneHref(?string $number): string
    {
        $digits = preg_replace('/\D+/', '', (string) $number) ?? '';

        return $digits !== '' ? 'tel:' . $digits : 'tel:';
    }
}
