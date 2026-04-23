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
            'working_hours' => static::getValue('working_hours', 'Mon-Fri: 8:30AM - 6:00PM'),
            'towing_hours' => static::getValue('towing_hours', 'Mon-Fri: 8:00AM - 5:00PM, Sat: 8:00AM - 5:00PM'),
        ];
    }

    public static function businessProfile(): array
    {
        $contact = static::contactSettings();

        return [
            'name' => 'Mads Auto Repair',
            'email' => 'repairmads@gmail.com',
            'street_address' => '1206 Gallatin Pike S',
            'city' => 'Madison',
            'state' => 'TN',
            'postal_code' => '37115',
            'country' => 'US',
            'phone' => $contact['call_now_number'],
            'phone_href' => $contact['call_now_href'],
            'hours' => $contact['working_hours'],
        ];
    }

    public static function aboutUsSettings(): array
    {
        return [
            'about_mission' => static::getValue(
                'about_mission',
                'Deliver honest diagnostics and dependable repairs that keep families and travelers safe on the road.'
            ),
            'about_vision' => static::getValue(
                'about_vision',
                'Be Nashville\'s most trusted neighborhood shop for auto care, transparency, and long-term reliability.'
            ),
            'about_story' => static::getValue(
                'about_story',
                'Mads Auto Repair started with one goal: give drivers a shop they can trust without hesitation. '
                . 'Over the years, we have helped local families, commuters, and travelers get back on the road quickly and safely. '
                . 'Our technicians combine modern diagnostics with hands-on experience to solve problems the right way the first time. '
                . 'We believe clear communication matters, so we explain every repair and cost before any work begins. '
                . 'Whether it is scheduled maintenance, major mechanical work, or roadside towing support, we treat each job with urgency and care. '
                . 'That commitment to honesty and quality is why so many customers choose us and keep coming back.'
            ),
            'about_image_path' => static::getValue('about_image_path', 'assets/img/whyus.png'),
        ];
    }

    public static function seoDefaults(): array
    {
        $business = static::businessProfile();

        return [
            'title' => sprintf(
                '%s | Honest Auto Repair & Towing in %s, %s',
                $business['name'],
                $business['city'],
                $business['state']
            ),
            'description' => 'Honest auto repair, diagnostics, maintenance, and towing support for drivers in Madison and the greater Nashville area.',
            'keywords' => 'auto repair Madison TN, towing Madison TN, mechanic Madison TN, brake repair, engine diagnostics, Nashville auto shop',
            'type' => 'website',
            'image' => asset('assets/img/logo.png'),
        ];
    }

    protected static function phoneHref(?string $number): string
    {
        $digits = preg_replace('/\D+/', '', (string) $number) ?? '';

        return $digits !== '' ? 'tel:' . $digits : 'tel:';
    }
}
