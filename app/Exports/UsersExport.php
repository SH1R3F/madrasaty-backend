<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{

    private $users;
    private $row = 0;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function headings(): array
    {
        return [
            '#',
            __('User'),
            __('Role'),
            __('Email'),
            __('Status'),
        ];
    }

    public function map($user): array
    {
        return [
            ++$this->row,
            $user->name,
            $user->roles->first()?->name ?? '',
            $user->email,
            $user->status ? __('Active') : __('Inactive'),
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->users;
    }
}
