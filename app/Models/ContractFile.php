<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'file_path',
    ];

    public function Contract(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Contract::class, 'contract_id', 'id');
    }
}
