<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasDateTimeFormatter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'avatar',
        'name',
        'phone',
        'nike_name',
        'language',
        'province',
        'country',
        'city',
        'gender',
        'openid',
        'session_key',
        'unionid',
    ];


    const GENDER_LIST = [
        0 => '未知',
        1 => '男',
        2 => '女',
    ];

    public function getRealNameAttribute() {
        return $this->name ?: $this->nike_name;
    }

    public static function toOptions() {
        return static::query()
            ->select(['enable' , 'id' , 'nike_name','name'])
            ->where('enable' ,1)->get()->pluck('real_name' , 'id');
    }
}
