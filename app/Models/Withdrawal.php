<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'withdrawals';
    protected $fillable = ['withdrawal_uuid', 'amount', 'type', 'account_id'];

    public $rules = [
        'withdrawal_uuid' => 'required',
        'account_id' => 'required',
        'amount' => 'required',
        'type' => 'required',
    ];

    public function uuid($uuid)
    {
        if (\App\Services\Uuid::isValidUuid($uuid)) {
            return $this->where('withdrawal_uuid', $uuid)->first();
        }
    }
}