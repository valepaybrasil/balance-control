<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountBalance extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['account_id', 'free_amount', 'blocked_amount', 'debit_amount'];

    public $rules = [
        'account_id' => 'required',
    ];

    public function account($account_id)
    {
        return $this->where('account_id',$account_id)->first();
    }

}