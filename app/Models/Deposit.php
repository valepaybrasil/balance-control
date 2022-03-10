<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'deposits';
    protected $fillable = ['deposit_uuid', 'amount', 'is_settled', 'account_id', 'transfer_date', 'settled_date'];

    public $rules = [
        'deposit_uuid' => 'required',
        'account_id' => 'required',
        'amount' => 'required',
        'transfer_date' => 'required|date_format:Y-m-d',
    ];

    public function uuid($uuid)
    {
        if (\App\Services\Uuid::isValidUuid($uuid)) {
            return $this->where('deposit_uuid', $uuid)->first();
        }
    }
}