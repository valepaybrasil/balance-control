<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'persons';
    protected $fillable = ['name', 'person_uuid', 'email', 'document'];

    public $rules = [
        'person_uuid' => 'required',
        'name' => 'required|min:3|max:64',
        'email' => 'required|min:6|max:64',
        'document' => 'required|min:6|max:64',
    ];

    public function uuid($uuid)
    {
        if (\App\Services\Uuid::isValidUuid($uuid)) {
            return $this->where('person_uuid', $uuid)->first();
        }
    }
}