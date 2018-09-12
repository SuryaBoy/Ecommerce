<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guard_name = 'admin';

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password', 'job_title',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

	public function sendPasswordResetNotification($token)
	{
	    $this->notify(new AdminResetPasswordNotification($token));
	}

    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function orderNotifications()
    {
        return $this->morphMany('App\OrderNotification', 'notifiable');
    }

}
