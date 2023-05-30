<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\Classroom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $row = array_values($row);
        $classroom = Classroom::firstOrCreate(['name' => $row[2]]);
        return new Student([
            'name' => $row[1],
            'classroom_id' => $classroom->id
        ]);
    }
}
