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

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $regions    = Region::All();
        $townships  = Township::All();
        $all_users  = User::leftjoin('enrol_users as enrol','enrol.user_id','=','users.id');

        if(isset($this->request->role)) {
            $all_users = $all_users->where('users.role', $role);
        }
        if(isset($this->request->course)) {
            $all_users = $all_users->where('enrol.course_id', $this->request->course);
        }

        $all_users = $all_users->select('name','email','phone','nrc','passport','second_phone','dob','gender',
        'highest_qualification','address','correspondence_address','description','guardian_name','guardian_contact_no',
        'region_id','township_id','role')->groupBy('users.id')->get();

        $users = [];
        foreach($all_users as $user) {
            $user->description = strip_tags($user->description);
            foreach($regions as $reg) {
                if($reg->id == $user->region_id) $user->region_id = $reg->name;
            }
            foreach($townships as $tsp) {
                if($tsp->id == $user->township_id) $user->township_id = $tsp->name;
            }
            
            // $user->is_active = $user->is_active ? 'No' : 'Yes';

            $users[] = $user;
        }

        return collect($users);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            // 'UserName',
            'Phone',
            'NRC',
            'Passport',
            'SecondPhone',
            'DOB',
            'Gender',
            'HighestQualification',
            'Address',
            'CorrespondenceAddress',
            'Description',
            'GuardianName',
            'GuardianContactNo',
            'Region',
            'Township',
            'Role',
            // 'SuspendedAccount',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet']
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {

        $event->sheet->styleCells(
            'A1:D100',
            [
                // 'alignment' => [
                //     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                // ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'CCCCCC']
                ]
            ],
        );
        $event->sheet->styleCells(
            'Q1:Q100',
            [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'CCCCCC']
                ]
            ],
        );
        
    }

}