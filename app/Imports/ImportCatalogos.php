<?php

namespace App\Imports;

use App\Models\util\MapUtil;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Descricao;
use App\Models\Catalogo\Catalogo;

class ImportCatalogos implements ToCollection
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $index =>  $row)
        {

            if($index === 0 )
              continue;
          if( $row[0] === 'INS' && $row[1] === 'INS'){

          $cordenadas = Cordenada::create(
                [
                    'latitude' => $row[10],
                    'longitude' => $row[11]
                ]);

           $catalogo = Catalogo::updateOrCreate([
                    'id' => $row[2],
                    'nome' => $row[3],
                    'like' => $row[3],
                    'endereco' => $row[4],
                    'home' => $row[5] === 1 ? true : false,
                    'active' => $row[6] === 1 ? true : false,
                    'regiao_id' => $row[9],
                    'cordenadas_id' => $cordenadas->id,
                    'administrador_id' => ($row->count() >= 13) ? $row[12] : 1,
                    'icon_id' => ($row->count() >= 14) ? $row[13] : 1,
                    'categoria_id' => ($row->count() >= 15) ? $row[14] : 1,
                    'user_id' => ($row->count() >= 16) ? $row[15] : 1,
                    'like_langue' => ($row->count() >= 17) ? $row[16] : "l",

            ]);

            $descricao = Descricao::create(
                [
                    'titulo' => $row[7],
                    'descricao' => $row[8],
                    'catalogo_id' => $catalogo->id
                ]);

            $catalogo->update([
                'like' => $catalogo->nome . ' ' .
                    $catalogo->endereco . ' ' .
                    MapUtil::merge(collect([$descricao]), 'titulo', 'descricao') . ' ' .
                    $catalogo->nome
            ]);

            }
            else if( $row[0] === 'UPD' && $row[1] === 'UPD'){

                $catalogo = Catalogo::with('cordenadas', 'descricoes', 'administrador')
                ->firstWhere('id', $row[2]);

                $catalogo->nome = $row[3];
                $catalogo->endereco = $row[4];
                $catalogo->home = $row[5] === 1 ? true : false;
                $catalogo->active = $row[6] === 1 ? true : false;
                $catalogo->regiao_id = $row[9];
                $catalogo->administrador_id = $row[12];
                $catalogo->save();

                $cordenadas = $catalogo->cordenadas;
                $cordenadas->latitude = $row[10];
                $cordenadas->longitude = $row[11];
                $cordenadas->save();

                $descricao = $catalogo->descricoes->first();
                $descricao->titulo = $row[7];
                $descricao->descricao = $row[8];
                $descricao->save();
            }
            else if( $row[0] === 'DEL' && $row[1] === 'DEL'){

                if(Catalogo::where('id', $row[2])->exists()){
                $catalogo = Catalogo::with('cordenadas', 'descricoes', 'administrador')
                ->firstWhere('id', $row[2]);
                $cordenadas =  $catalogo->cordenadas;

                foreach ($catalogo->descricoes as $index =>  $descricao)
                    $descricao->delete();

                $catalogo->delete();
                $cordenadas->delete();

                }
            }
        }
    }

}
