<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsersExport implements FromCollection, WithMapping, WithColumnFormatting, WithColumnWidths
{
    public function collection()
    {
        return User::all();
    }

    /**
     * @var User $user
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            Date::dateTimeToExcel($user->created_at),
        ];
    }

    public function columnFormats(): array
    {
        $customDateTimeFormat = 'dd/mm/yyyy "às" hh:mm:ss';

        return [
            'C' => $customDateTimeFormat,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 25
        ];
    }
}
