<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentation extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'movimentations';
    protected $fillable = ['amount', 'deposit_id', 'withdrawal_id', 'transfer_id', 'account_id', 'type'];

    public $rules = [
        'account_id' => 'required',
        'ammount' => 'required',
        'type' => 'required',
    ];

    public function account_id($id)
    {
        return $this->where('account_id',$id)->first();
    }
}