<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class StudentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable;
    public function model(array $row)
    {
        return new Student([
            'name' => $row[0],
            'class' => $row[1],
            'skill_id' => $row[2],
            'group' => $row[3],
        ]);
    }
}
