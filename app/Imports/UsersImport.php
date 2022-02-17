<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Carbon\Carbon;
use App\Models\Region;
use App\Models\Township;
use Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
        
        
    // }

    public function collection(Collection $rows)
    {
        $total_import = 0;
        foreach($rows as $row) {
            $region = Region::where('name', $row['region'])->first();
            $township = Township::where('name', $row['township'])->first();
            $region_id = (empty($region))? null : $region->id;
            $township_id = empty($township)? null : $township->id;
            $dob = (!empty($row['dob']))? Carbon::parse($row['dob'])->format('Y-m-d') : null;
    
            if(!empty($row['fullname']) && !empty($row['email']) && !empty($row['phone']) && !empty($row['nrc'])) {
                $user = User::where('phone', $row['phone'])->orWhere('email', $row['email'])->first();
                // $user = User::where('username', $row['username'])->orWhere('email', $row['email'])->first();
        
                if(empty($user)) {
                    $total_import = $total_import + 1;
                    $user = User::create([
                        'name'          => $row['fullname'], 
                        'email'         => $row['email'], 
                        'password'      => Hash::make('PsmLms123$'),
                        // 'username'      => $row['username'], 
                        'phone'         => $row['phone'],
                        'nrc'           => $row['nrc'],
                        'passport'      => $row['passport'],
                        'second_phone'  => $row['secondphone'],
                        'dob'           => $dob,
                        'gender'        => $row['gender'],
                        'highest_qualification'     => $row['highestqualification'],
                        'address'                   => $row['address'],
                        'correspondence_address'    => $row['correspondenceaddress'],
                        'description'               => $row['description'],
                        'guardian_name'             => $row['guardianname'],
                        'guardian_contact_no'       => $row['guardiancontactno'],
                        'region_id'                 => $region_id,
                        'township_id'               => $township_id,
                        'role'                      => 'Student',
                        'is_active'                 => 1,
                        'password_change'           => 1,
                    ]);
    
                    $user->assignRole('Student');
                }
            }else {
                flash('Please input required field FullName, Email, Phone, NRC!')->error()->important();
                return redirect()->back();
            }
        }
        flash('Users Import '.$total_import.' members successful!')->success()->important();
    }

    public function sheets(): array
    {
        return [
            0 => new UsersImport(),
        ];
    }
}
