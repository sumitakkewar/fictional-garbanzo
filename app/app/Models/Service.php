<?php

namespace App\Models;

use App\Constants\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function providers(){
        return $this->belongsToMany(User::class)->using(ServiceUser::class)->where('type', App::PROVIDER)->withPivot('id');
    }

    public function subscribers(){
        return $this->belongsToMany(User::class)->using(ServiceUser::class)->where('type', App::SUBSCRIBER)->withPivot('id');
    }
}
