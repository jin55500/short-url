<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Url extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected  $guarded  = ['id'];
    public static function generateCode($length = 6)
    {
        do {
            $code = Str::random($length);
        } while (static::where([['code', $code],['deleted_at',null]])->exists());

        return $code;
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                if(Auth::check()) {
                    $model->created_by = Auth::id();
                }
            }
        });

        self::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                if(Auth::check()) {
                    $model->updated_by = Auth::id();
                }
            }
        });

        self::deleted(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                $user = Auth::user();
                if ($user) {
                  $model->deleted_by = Auth::id();
                  $model->save();
                }
              }
        });
    }
    public function userCreate()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
