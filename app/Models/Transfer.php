<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'transfers';
    protected $fillable = ['transfer_uuid', 'amount', 'account_origin_id', 'account_destination_id', 'date'];

    public $rules = [
        'transfer_uuid' => 'required',
        'amount' => 'required',
        'account_origin_id' => 'required',
        'account_destination_id' => 'required',
        'date' => 'required',
    ];

    public function uuid($uuid)
    {
        if (\App\Services\Uuid::isValidUuid($uuid)) {
            return $this->where('transfer_uuid', $uuid)->first();
        }
    }
}