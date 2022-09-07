<?php

namespace App\Models;

use App\Models\Scopes\AncientScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'amount',
        'description',
        'transaction_date',
        'user_id',
    ];

    protected $dates = ['transaction_date'];


    public function category(){
        return $this->belongsTo(Category::class);
    }

    // mutators
    public function setAmountAttribute($value){

        $this->attributes['amount'] = $value * 100;

    }

    public function setTransactionDateAttribute($value){

        $this->attributes['transaction_date'] = Carbon::createFromFormat('m/d/Y', $value)->format('Y-m-d');

    }

     /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        if(auth()->check()){
            static::addGlobalScope(new AncientScope);
        }
    }

}
