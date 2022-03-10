<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['account_uuid','is_active', 'person_id','company_id', 'blocked_at', 'deleted_at'];

    public $rules = [
        'account_uuid' => 'required',
        'is_active' => 'number|min:1|max:1',
    ];

    public function uuid($uuid)
    {
        if (\App\Services\Uuid::isValidUuid($uuid)) {
            return $this->where('account_uuid', $uuid)->first();
        }
    }
}
