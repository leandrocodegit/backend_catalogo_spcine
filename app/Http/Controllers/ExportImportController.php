<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ExportCatalogos;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportCatalogos;
use App\Imports\ImportUsers;
use App\Models\Logs\LogMessage;
use Illuminate\Support\Facades\Log;

class ExportImportController extends Controller
{
    public function catalogosXLS() 
    {
        Log::channel('db')->info(
            'Exportando catalogos com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);  
        return Excel::download(new ExportCatalogos, 'catalogos.xls');
    }

    public function importCatalogo(Request $request) 
{
    Log::channel('db')->info(
        'Importando catalogos com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role); 
    Excel::import(new ImportCatalogos, $request->file('file'));
}

public function importUsers(Request $request) 
{
    Log::channel('db')->info(
        'Importando usuários com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role); 
     Excel::import(new ImportUsers, $request->file('file'));
}
}
