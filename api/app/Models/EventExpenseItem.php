<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventExpenseItem extends Model
{

    use SoftDeletes;

    public $table = 'event_expense_items';
    public $primaryKey = 'id';
    // protected $fillable = [
    //     'event_expense_id',
    //     'description',
    //     'unit_value',
    //     'quantity',
    //     'discount',
    //     'total_value',
    //     'uuid',
    // ];

    // protected $casts = [
    //     'unit_value' => 'decimal:2',
    //     'quantity' => 'decimal:2',
    //     'discount' => 'decimal:2',
    //     'total_value' => 'decimal:2',
    // ];

    // /**
    //  * Relacionamento com a despesa
    //  */
    // public function expense(): BelongsTo
    // {
    //     return $this->belongsTo(EventExpense::class, 'event_expense_id');
    // }

    // /**
    //  * Accessor para calcular o valor total do item
    //  * (já existe na tabela, mas pode ser usado para validação)
    //  */
    // public function getCalculatedTotalAttribute(): float
    // {
    //     return ($this->unit_value * $this->quantity) - $this->discount;
    // }

    // /**
    //  * Accessor para obter o UUID como chave de identificação
    //  */
    // public function getRouteKeyName()
    // {
    //     return 'uuid';
    // }
}