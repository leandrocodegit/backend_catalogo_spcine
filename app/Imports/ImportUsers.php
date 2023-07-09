<?php

namespace App\Imports;

use App\Models\Account\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportUsers implements ToCollection
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $index =>  $row) 
        {

            if($index === 0 )
                continue;
            if (User:: where('email', $row[2]) -> orWhere('cpf', $row[1]) -> exists()) 
                continue;     
 
         User::create([                
                    'nome' => $row[0],
                    'cpf' => $row[1],
                    'email' => $row[2], 
                    'telefone' => $row[3], 
                    'email_verificado' => $row[4] === 1 ? true : false,
                    'empresa' => $row[5],
                    'password' => '9zV6WCvFEwHsP3JMkPzTP8b9dggfSjdBnNl5J8fV',
                    'active' => $row[7] !== 3 &&  $row[7] !== 4 ? false : ($row[6] === 1 ? true : false),
                    'perfil_id' => $row[7] < 3 ?  $row[7] : 4,
            ]);

        }
    }

}
