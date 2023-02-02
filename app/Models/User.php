<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Interfaces\Transformable;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements Transformable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const VERIFIED_USER = true;
    const UNVERIFIED_USER = false;

    const ADMIN_USER = true;
    CONST REGULAR_USER = false;

    protected static function boot()
    {
        parent::boot();
        self::created(function(User $user) {
            retry(5, function () use($user){
                Mail::to($user)->send(new UserCreated($user));
            });
        });
        self::updated(function (User $user) {
            if($user->isDirty('email')) {
                Mail::to($user)->send(new UserMailChanged($user));
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
        'password',
        'remember_token',
        'verification_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The transformer class associated with the model
     */
    public $transformer = UserTransformer::class;

    public function getTransformer()
    {
        return $this->transformer;
    }

    public function isVerified()
    {
        return (bool)$this->verified === self::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return (bool)$this->admin === self::ADMIN_USER;
    }

    public static function generateVerficationCode()
    {
        return Str::random(40);
    }

    /**
    * ACCESSOR
    */
    public function getNameAttribute()
    {
        return ucwords($this->attributes['name']);
    }

    /**
    * MUTATORS
    */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }
}
