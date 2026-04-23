<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PublicVisit extends Model
{
    protected $fillable = [
        'ip_address',
        'visited_on',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'visited_on' => 'date',
        ];
    }

    public static function recordFromRequest(Request $request): void
    {
        if (! Schema::hasTable('public_visits')) {
            return;
        }

        $ip = trim((string) $request->ip());
        if ($ip === '') {
            return;
        }

        static::query()->firstOrCreate(
            [
                'ip_address' => $ip,
                'visited_on' => now()->toDateString(),
            ],
            [
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 500),
            ]
        );
    }

    public static function uniqueIpCountForDay(CarbonInterface $date): int
    {
        return static::uniqueIpCountBetween($date->copy()->startOfDay(), $date->copy()->endOfDay());
    }

    public static function uniqueIpCountForMonth(CarbonInterface $date): int
    {
        return static::uniqueIpCountBetween($date->copy()->startOfMonth(), $date->copy()->endOfMonth());
    }

    public static function uniqueIpCountForYear(CarbonInterface $date): int
    {
        return static::uniqueIpCountBetween($date->copy()->startOfYear(), $date->copy()->endOfYear());
    }

    public static function uniqueIpCountBetween(CarbonInterface $start, CarbonInterface $end): int
    {
        if (! Schema::hasTable('public_visits')) {
            return 0;
        }

        return (int) static::query()
            ->whereBetween('visited_on', [$start->toDateString(), $end->toDateString()])
            ->distinct()
            ->count('ip_address');
    }

    public static function totalUniqueIpCount(): int
    {
        if (! Schema::hasTable('public_visits')) {
            return 0;
        }

        return (int) static::query()->distinct()->count('ip_address');
    }
}
