<?php

namespace App\Imports;

use App\Models\Catalogo\Caracteristica;
use App\Models\Catalogo\Catalogo;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportCaracteristicas implements ToCollection
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row) {

            if ($index === 0)
                continue;
            if ($row[0] === 'INS' && $row[1] === 'INS') {

                $nomes = Str::of($row[4])->explode(',');

                foreach ($nomes as $index => $nome) {

                    if (!Caracteristica::where('categoria_id', $row[3])->where('nome', $nome)->exists()) {
                      $caracteristica =  Caracteristica::updateOrCreate([
                            'categoria_id' => $row[3],
                            'nome' => $nome
                        ]);

                       Catalogo::firstWhere('id', $row[5])->caracteristicas()->attach($caracteristica->id);

                    }
                }
            }
        }
    }

}
