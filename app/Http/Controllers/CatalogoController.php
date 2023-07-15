<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Descricao;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Tag;
use App\Models\Catalogo\Preco;
use Symfony\Component\HttpFoundation\Response;
use App\Events\EventResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class CatalogoController extends Controller
{
    public function random(Request $request)

    {
        return Catalogo::with('administrador', 'cordenadas', 'tags', 'precos', 'imagens', 'regiao', 'regras')
            ->where('home', true)
            ->where('active', true)
            ->orderByRaw('RAND() LIMIT 15')
            ->get();
    }

    public function search($nome)
    {
        if($nome == "all")
            return Catalogo::all();

        return Catalogo::with('descricoes')
            ->when($nome !== null)
            ->where('nome', 'LIKE', '%' . $nome . '%')
            ->orWhere('endereco', 'LIKE', '%' . $nome . '%')
            ->limit(10)
            ->get();
    }
    public function filter(Request $request)
    {

        return Catalogo::with(
            'administrador',
            'descricoes',
            'cordenadas',
            'icon',
            'tags',
            'precos',
            'imagens',
            'regiao',
            'regras')
            ->when($request->orderPrice !== null)
            ->orderBy('mediaPreco', $request->orderPrice)
            ->when($request->nome !== null)
            ->where('nome', 'LIKE', '%' . $request->nome . '%')
            ->when($request->active !== null)
            ->where('active', $request->active)
            ->when($request->administrador !== null)
            ->whereHas('administrador', function ($query) use ($request) {
                $query->whereIn('id', $request->administrador);
            })
            ->when($request->tags !== null)
            ->whereHas('tags', function ($query) use ($request) {
                $query->whereIn('id', $request->tags);
            })
            ->when($request->regras !== null)
            ->whereHas('regras', function ($query) use ($request) {
                $query->whereIn('id', $request->regras);

            })
            ->when($request->regiao !== null)
            ->whereHas('regiao', function ($query) use ($request) {
                $query->whereIn('id', $request->regioes);
            })
            ->when($request->preco !== null)
            ->whereHas('precos', function ($query) use ($request) {
                $query->where('valor', '>=', $request->preco);

            })
            ->simplePaginate(20);
    }

    public function find($id)
    {
        return Catalogo::with('administrador', 'descricoes', 'cordenadas', 'tags', 'precos', 'imagens', 'regiao', 'regras')
            ->findOrFail($id);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required',
            'endereco' => 'bail|required',
            'descricao' => 'bail|required',
            'descricao.titulo' => 'bail|required',
            'descricao.descricao' => 'bail|required'
        ],
            [
                'nome.required' => 'Nome é obrigatório!',
                'endereco.required' => 'Endereço é obrigatório!',
                'descricao' => 'Objeto descrição é obrigatório',
                'descricao.titulo' => 'Titulo é obrigatório!',
                'descricao.descricao' => 'Descrição é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        $cordenadas = null;

        if ($request->cordenadas !== null)
            $cordenadas = Cordenada::create([
                'latitude' => $request->input('cordenadas.latitude'),
                'longitude' => $request->input('cordenadas.longitude')
            ]);

        $catalogo = Catalogo::create([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'home' => $request->home !== null ? $request->home : false,
            'active' => $request->active !== null ? $request->active : false,
            'cordenadas_id' => $cordenadas !== null ? $cordenadas->id : null,
            'regiao_id' => $request->regiao !== null ? $request->input('regiao.id') : null,
            'administrador_id' => $request->administrador !== null ? $request->input('administrador.id') : null,
            'icon_id' => ($request->icon !== null && $request->input('icon.id') != null)  ? $request->input('icon.id') : 1,
        ]);

        $descricao = Descricao::create([
            'titulo' => $request->input('descricao.titulo'),
            'descricao' => $request->input('descricao.descricao'),
            'catalogo_id' => $catalogo->id
        ]);

        Log::channel('db')->info(
            'Editado imagem ' . $request->id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

        return response()->json([
            'message' => 'Catalogo cadastrado com sucesso!',
            'status' => 200], 200);
    }

    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'bail|required',
            'nome' => 'bail|required',
            'endereco' => 'bail|required'
        ],
            [
                'id.required' => 'Campo id é obrigatório!',
                'nome.required' => 'Nome é obrigatório!',
                'endereco.required' => 'Endereço é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->messages(), 'status' => 400], 400);

        Catalogo::with('administrador', 'descricoes', 'cordenadas', 'tags', 'precos', 'imagens', 'regiao', 'regras')
            ->findOrFail($request->id)
            ->update([
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'home' => $request->home,
                'active' => $request->active,
                'regiao_id' => $request->input('regiao.id'),
                'administrador_id' => $request->input('administrador.id')
            ]);

        $catalogo = $this->find($request->id);

        if ($request->cordenadas !== null) {
            try {
                $cordenadas = Cordenada::updateOrCreate(
                    ['id' => isset($request->cordenadas['id']) ? $request->cordenadas['id'] : null],
                    [
                        'latitude' => $request->cordenadas['latitude'],
                        'longitude' => $request->cordenadas['longitude']
                    ]);
                $catalogo->cordenadas()->associate($cordenadas->id);
            } catch (Exception $e) {
            }
        }

        if ($request->descricoes !== null) {
            try {
                foreach ($request->descricoes as $descricao) {
                    Descricao::updateOrCreate(
                        ['id' => isset($descricao['id']) ? $descricao['id'] : null],
                        [
                            'titulo' => $descricao['titulo'],
                            'descricao' => $descricao['descricao'],
                            'catalogo_id' => $catalogo->id,
                        ]);
                }
            } catch (Exception $e) {
            }
        }

        if ($request->precos !== null) {
            try {
                foreach ($request->precos as $preco) {
                    Preco::updateOrCreate(
                        ['id' => isset($preco['id']) ? $preco['id'] : null],
                        [
                            'valor' => $preco['valor'],
                            'descricao' => $preco['descricao'],
                            'catalogo_id' => $catalogo->id
                        ]);
                }
            } catch (Exception $e) {
            }
        }

        if ($request->tags !== null) {
            try {
                $catalogo->tags()->detach();
                $catalogo->tags()->attach(
                    collect($request->tags)
                        ->map(function ($value, $key) {
                            return $value['id'];
                        }));
            } catch (Exception $e) {
            }
        }

        if ($request->regras !== null) {
            try {
                $catalogo->regras()->detach();
                $catalogo->regras()->attach(
                    collect($request->regras)
                        ->map(function ($value, $key) {
                            return $value['id'];
                        }));
            } catch (Exception $e) {
            }
        }

        Log::channel('db')->info(
            'Editado imagem ' . $request->id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

        return $this->find($catalogo->id,);
    }
}

