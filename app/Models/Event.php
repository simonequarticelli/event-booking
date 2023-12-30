<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    use HasFactory;

    protected $appends = ['tickets_available'];

    public function scopeGreaterThanToday($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function getTicketsAvailableAttribute()
    {
        $reservedTickets = $this->tickets()->with('state', function ($query) {
            $query->whereIn('slug', [TicketState::PENDING, TicketState::APPROVED]);
        })->count();

        return ($this->seats - $reservedTickets);
    }

    public function price(): hasOne
    {
        return $this->hasOne(EventPrice::class);
    }

    public function option(): hasOne
    {
        return $this->hasOne(EventOption::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
