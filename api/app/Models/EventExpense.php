<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventExpense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'event_id',
        'proof_access_key',
        'items_total',
        'uuid',
    ];

    protected $casts = [
        'items_total' => 'decimal:2',
    ];

    /**
     * Relacionamento com o usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com o evento
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relacionamento com os itens da despesa
     */
    public function items(): HasMany
    {
        return $this->hasMany(EventExpenseItem::class, 'event_expense_id');
    }

    /**
     * Calcula o valor total baseado nos itens
     */
    public function calculateTotalValue(): float
    {
        return $this->items->sum('total_value');
    }

    /**
     * Accessor para obter o UUID como chave de identificação
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}