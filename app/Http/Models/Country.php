<?php


namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Country extends Model
{
    protected $fillable = ['name'];

    public function stats(): HasOne
    {
        return $this->HasOne(CovidStat::class);
    }
}
