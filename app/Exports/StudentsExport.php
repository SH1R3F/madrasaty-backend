<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class StudentsExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{

    private $students;
    private $row = 0;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function headings(): array
    {
        return [
            '#',
            __('Student'),
            __('Classroom'),
        ];
    }

    public function map($student): array
    {
        return [
            ++$this->row,
            $student->name,
            $student->classroom->name,
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
        return $this->students;
    }
}
