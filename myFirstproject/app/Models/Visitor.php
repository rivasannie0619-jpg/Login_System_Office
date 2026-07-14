<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'person_to_visit',
        'purpose',
        'visit_date',
        'time_in',
        'time_out',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
    ];

    public function scopeCurrentlyIn(Builder $query): Builder
    {
        return $query->whereNull('time_out');
    }

    public function scopeCheckedOut(Builder $query): Builder
    {
        return $query->whereNotNull('time_out');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('person_to_visit', 'like', "%{$term}%")
                ->orWhere('address', 'like', "%{$term}%")
                ->orWhere('purpose', 'like', "%{$term}%");
        });
    }

    public function scopeDateRange(Builder $query, ?string $range): Builder
    {
        $today = Carbon::today();

        return match ($range) {
            'today' => $query->whereDate('visit_date', $today),
            'week' => $query->whereBetween('visit_date', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]),
            'month' => $query->whereMonth('visit_date', $today->month)->whereYear('visit_date', $today->year),
            default => $query,
        };
    }

    public function getDurationAttribute(): ?string
    {
        if (! $this->time_out) {
            return null;
        }

        return $this->time_in->diffForHumans($this->time_out, true);
    }
}