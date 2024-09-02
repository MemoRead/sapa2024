<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    use Importable;
    public function model(array $row)
    {
        return new User([
            'name' => $row[0],
            'username' => $row[1],
            'password' => bcrypt($row[2]),
            'role' => $row[3],
            'teacher_id' => $row[4],
            'student_id' => $row[5],
        ]);
    }
}
