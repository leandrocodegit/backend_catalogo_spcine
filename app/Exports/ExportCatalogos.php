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
            'Média de preço',
            'Latitude',
            'Longitude',
            'Status',
            'Administrador'
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
                $catalogo->endereco,
                $catalogo->mediaPreco,
                $catalogo->cordenadas->latitude,
                $catalogo->cordenadas->longitute,
                $catalogo->active === 1 ? 'Ativo' : 'Inativo',
                $catalogo->administrador->nome,
            ]
        ];
    }
}
