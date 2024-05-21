<?php

namespace App\Exports;

use App\Models\Catalogo\Catalogo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCatalogos implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $ca = Catalogo::with('administrador','cordenadas','caracteristicas', 'precos', 'imagens', 'regiao', 'regras')
        ->get();
        return $ca;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Descrição',
            'Categoria',
            'Endereço',
            'Horário inicial',
            'Horário final',
            'Administrador',
            'Região',
            'Latitude',
            'Longitude',
            'Menor preço',
            'Maior preço',
            'Quantidade imagens',
            'Status',

        ];
    }

    public function map($catalogo): array
    {
        // This example will return 3 rows.
        // First row will have 2 column, the next 2 will have 1 column
        return [
            [
                $catalogo->id,
                $catalogo->nome,
                $catalogo->descricao_principal,
                $catalogo->categoria->nome,
                $catalogo->endereco,
                $catalogo->horaInicial,
                $catalogo->horaFinal,
                $catalogo->administrador->nome,
                $catalogo->regiao->nome,
                $catalogo->cordenadas->latitude,
                $catalogo->cordenadas->longitude,
                'R$ ' .$catalogo->precos->min(function ($preco) {
                    return $preco->minimo;
                }),
                'R$ ' .$catalogo->precos->max(function ($preco) {
                    return $preco->maximo;
                }),
                count($catalogo->imagens),
                $catalogo->active === 1 ? 'Ativo' : 'Inativo',
            ]
        ];
    }
}
