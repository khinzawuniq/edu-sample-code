<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Cache;
use App\Notifications\ResetPasswordNotification;
use App\Models\Region;
use App\Models\Township;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $table = "users";
    protected $appends = ['profile'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'phone', 'address','description', 'photo', 'user_type', 'role', 'is_active', 'password_change',
        'guardian_name', 'guardian_contact_no', 'gender', 'dob', 'nrc','passport', 'second_phone', 'correspondence_address', 'highest_qualification',
        'citizenship_card', 'passport_photo', 'qualification_photo', 'transcript_photo', 'lang_certificate_photo', 'region_id', 'township_id','switch_role','mobile_id','web_id',
        'platform_web','device_name_web','device_ip_web','active_status','dark_mode','browser','location','last_seen','mobile_device','avatar','verify_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        "last_online_at"    => "datetime",
    ];

    public function isOnline() {
		return Cache::has('user-is-online-'.$this->id);
    }
    
    public function login_activities()
    {
        return $this->hasMany(LoginActivity::class, 'user_id', 'id');
    }
    
    public function additional_users()
    {
        return $this->hasMany(AdditionalUser::class, 'user_id', 'id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id')->withDefault([
            'name' => null,
        ]);
    }
    public function township()
    {
        return $this->belongsTo(Township::class, 'township_id', 'id')->withDefault([
            'name' => null,
        ]);
    }

    public function getProfileAttribute()
    {
       return $this->photo ? 'uploads/'.$this->photo : null ;
    }
}