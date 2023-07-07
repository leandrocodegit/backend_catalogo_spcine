<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExportCatalogos;
use Maatwebsite\Excel\Facades\Excel;

class RelatorioController extends Controller
{
    public function catalogosXLS() 
    {
        return Excel::download(new ExportCatalogos, 'catalogos.xls');
    }
}
