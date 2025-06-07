<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventExpense extends Model
{
    use SoftDeletes, HasUuids;

    /******************************************
     *                                        *
     *              PROPERTIES                *
     *                                        *
     ******************************************/

    public $table = 'event_expenses';
    public $primaryKey = 'uuid';

    /******************************************
     *                                        *
     *              ATTRIBUTES                *
     *                                        *
     ******************************************/

    /******************************************
     *                                        *
     *               RELATIONS                *
     *                                        *
     ******************************************/

    // public function items()
    // {
    //     return $this->hasMany(EventExpenseItem::class, 'event_expense_id', 'id');
    // }

    /******************************************
     *                                        *
     *                 SCOPES                 *
     *                                        *
     ******************************************/

    public function scopeFromEvent(Builder $query, int $internalEventId)
    {
        return $query = $query->where('event_id', $internalEventId);
    }
    /******************************************
     *                                        *
     *                METHODS                 *
     *                                        *
     ******************************************/

    // /**
    //  * Relacionamento com o usuário
    //  */
    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }

    // /**
    //  * Relacionamento com o evento
    //  */
    // public function event(): BelongsTo
    // {
    //     return $this->belongsTo(Event::class);
    // }

    // /**
    //  * Relacionamento com os itens da despesa
    //  */
    // public function items(): HasMany
    // {
    //     return $this->hasMany(EventExpenseItem::class, 'event_expense_id');
    // }

    // /**
    //  * Calcula o valor total baseado nos itens
    //  */
    // public function calculateTotalValue(): float
    // {
    //     return $this->items->sum('total_value');
    // }

    // /**
    //  * Accessor para obter o UUID como chave de identificação
    //  */
    // public function getRouteKeyName()
    // {
    //     return 'uuid';
    // }
}