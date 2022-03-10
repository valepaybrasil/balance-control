<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey = 'id';
    protected $table= "companies";

    protected $fillable = ['name', 'company_uuid', 'fantasy_name', 'document', 'external_uuid', 'email', 'person_id'];

    public $rules = [
        'company_uuid' => 'required',
        'fantasy_name' => 'required',
        'name' => 'required',
        'document' => 'required',
        'external_uuid' => 'required',
        'email' => 'required',
    ];

    public function uuid($uuid)
    {
        if (\App\Services\Uuid::isValidUuid($uuid)) {
            return $this->where('company_uuid', $uuid)->first();
        }
    }
}
