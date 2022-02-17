<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class EnrolUser extends Model
{
    use SoftDeletes;
    protected $table = "enrol_users";

    protected $fillable = [
        "user_id",
        "course_id",
        "batch_group_id",
        "serial_no",
        "start_date",
        "end_date",
        "duration",
        "start_activity",
        "last_activity",
        "status",
        "charges",
        'slip',
        'payment_status',
        'time_limit',
        'time_type',
        'pay_status',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    
    public function batch_group()
    {
        return $this->belongsTo(BatchGroup::class, 'batch_group_id', 'id')->withDefault([
            'group_name' => null,
        ]);
    }

    public function getLearningDuration($course_id, $user_id)
    {
        $learning_durations = StudentLessonDuration::where('course_id', $course_id)
        ->where('user_id', $user_id)
        ->orderBy('id','DESC')->groupBy('created_at')->get();

        $total_duration = $learning_durations->sum('playtime_seconds');

        $H = floor($total_duration / 3600);
        $i = ($total_duration / 60) % 60;
        $s = $total_duration % 60;
        $total_hour = sprintf("%02d:%02d:%02d", $H, $i, $s);

        return $total_hour;
    }
}