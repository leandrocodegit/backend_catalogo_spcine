<?php

namespace App\Imports;

use App\Models\Account\User;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Preco;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Catalogo\Catalogo;

class ImportResponsavel implements ToCollection
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row) {

            if ($index === 0)
                continue;
            if ($row[0] === 'INS' && $row[1] === 'INS') {

                if (User:: where('email', $row[7])->exists()){
                    Catalogo::firstWhere('id', $row[3])->update([
                        'user_id' => User::firstWhere('email', $row[7])->id
                    ]);
                    continue;
                }


                $user = User::updateOrCreate([
                    'nome' => $row[4],
                    'telefone' => $row[5],
                    'celular' => $row[6],
                    'email' => $row[7],
                    'documento' => $row[8],
                    'perfil_id' => $row[9],
                    'email_verificado' => false,
                    'active' => false,
                    'password' => '9zV6WCvFEwHsP3JMkPzTP8b9dggfSjdBnNl5J8fV'
                ]);
            }

            $output = new \Symfony\Component\Console\Output\ConsoleOutput();
            $output->write($user->id);

            Catalogo::firstWhere('id', $row[3])->update([
                'user_id' => $user->id
            ]);

        }
    }

}
