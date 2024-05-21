<?php

namespace App\Http\Controllers;

use App\Imports\ImportCaracteristicas;
use App\Imports\ImportDescricao;
use App\Imports\ImportImagens;
use App\Imports\ImportPrecos;
use App\Imports\ImportResponsavel;
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
            'Exportando catalogos');
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

    public function importImagens(Request $request)
    {
        Log::channel('db')->info(
            'Importando imagens com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);
        Excel::import(new ImportImagens(), $request->file('file'));
    }

    public function importDescricoes(Request $request)
    {
        Log::channel('db')->info(
            'Importando descrições com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);
        Excel::import(new ImportDescricao(), $request->file('file'));
    }

    public function importPrecos(Request $request)
    {
        Log::channel('db')->info(
            'Importando preços com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);
        Excel::import(new ImportPrecos(), $request->file('file'));
    }

    public function importCaracteristicas(Request $request)
    {
        Log::channel('db')->info(
            'Importando caracteristicas com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);
        Excel::import(new ImportCaracteristicas(), $request->file('file'));
    }

    public function importUsuarios(Request $request)
    {
        Log::channel('db')->info(
            'Importando usuarios com usuario ' . auth()->user()->nome. ' e previlégios ' .auth()->user()->perfil->role);
        Excel::import(new ImportResponsavel(), $request->file('file'));
    }
}
