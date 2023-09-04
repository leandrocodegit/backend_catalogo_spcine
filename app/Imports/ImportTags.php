<?php

namespace App\Imports;

use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Preco;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Catalogo\Catalogo;

class ImportTags implements ToCollection
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $index =>  $row)
        {

            if($index === 0 )
              continue;
          if( $row[0] === 'INS' && $row[1] === 'INS'){


         Preco::updateOrCreate([
                'catalogo_id' => $row[3],
                'descricao' => $row[4],
               'minimo' => $row[5],
               'maximo' => $row[6],
               'descontos' => $row[7] === 1 ? true : false,
               'tabela_descontos' => $row[8]
            ]);
            }
        }
    }

}
