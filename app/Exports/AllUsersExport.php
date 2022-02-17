<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Region;
use App\Models\Township;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;

class AllUsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'email',
            'active_status',
            'dark_mode',
            'messenger_color',
            'avatar',
            'email_verified_at',
            // 'password',
            // 'remember_token',
            'username',
            'phone',
            'address',
            'description',
            'photo',
            'user_type',
            'role',
            'is_active',
            'created_at',
            'updated_at',
            'password_change',
            'guardian_name',
            'guardian_contact_no',
            'gender',
            'dob',
            'nrc',
            'passport',
            'second_phone',
            'correspondence_address',
            'highest_qualification',
            'citizenship_card',
            'passport_photo',
            'qualification_photo',
            'transcript_photo',
            'lang_certificate_photo',
            'region_id',
            'township_id',
            'switch_role',
            'last_online_at',
            'mobile_id',
            'web_id',
            'platform_web',
            'device_name_web',
            'profile',
        ];
    }
}
