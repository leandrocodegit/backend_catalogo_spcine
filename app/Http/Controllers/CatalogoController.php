<?php

namespace App\Http\Controllers;

use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use Exception;
use App\Models\Catalogo\Imagem;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Descricao;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Regiao;
use App\Models\Catalogo\Administrador;
use App\Models\Catalogo\Caracteristica;
use App\Models\Catalogo\Preco;
use Illuminate\Support\Facades\Storage;
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
        return Catalogo::with('administrador', 'cordenadas', 'caracteristicas', 'precos', 'imagens', 'regiao', 'regras')
            ->where('home', true)
            ->where('active', true)
            ->orderByRaw('RAND() LIMIT 15')
            ->get();
    }

    public function searchID($id)
    {
        return Catalogo::with('caracteristicas', 'cordenadas', 'responsavel', 'regras', 'administrador', 'imagens', 'descricoes', 'regiao', 'icon', 'categoria', 'precos')
            ->firstWhere('id', $id)
            ->paginate(1);
    }

    public function search(Request $request)
    {
        $validNome = (isset($request->nome) && strlen($request->nome) > 2);

        if ($request->nome == null || $request->nome == "all")
            return Catalogo::with('caracteristicas', 'cordenadas', 'responsavel', 'regras', 'administrador', 'imagens', 'descricoes', 'regiao', 'icon', 'categoria', 'precos')
                ->when($request->ordem !== null)
                ->orderBy($request['ordem.nome'], $request['ordem.tipo'])
                ->paginate($request->limite);

        if ($validNome) {
            $catalogoID = Catalogo::with('caracteristicas', 'cordenadas', 'responsavel', 'administrador', 'imagens', 'descricoes', 'regiao', 'icon', 'categoria', 'precos')
                ->when($validNome)
                ->where('id', $request->nome)
                ->paginate($request->limite);

            if($catalogoID->total() == 1)
                return $catalogoID;
        }

        return Catalogo::with('caracteristicas', 'cordenadas', 'responsavel', 'administrador', 'imagens', 'descricoes', 'regiao', 'icon', 'categoria', 'precos')
            ->when($validNome)
            ->where('like', 'LIKE', '%' . $request->nome . '%')
            ->orWhere('like_langue', 'LIKE', '%' . $request->nome . '%')
            ->when($request->ordem !== null)
            ->orderBy($request['ordem.nome'], $request['ordem.tipo'])
            ->paginate($request->limite);
    }

    public function filter(Request $request)
    {

        $validNome = (isset($request->nome) && strlen($request->nome) > 2);

        if ($validNome && $request->nome == "all") {
            return Catalogo::with(
                'responsavel',
                'categoria',
                'administrador',
                'descricoes',
                'cordenadas',
                'icon',
                'caracteristicas',
                'precos',
                'imagens',
                'regiao',
                'regras')
                ->when($request->ordem !== null)
                ->orderBy($request['ordem.nome'], $request['ordem.tipo'])
                ->paginate($request->limite);
        }

        if ($validNome) {
          $catalogoID = Catalogo::with('caracteristicas', 'cordenadas', 'responsavel', 'administrador', 'imagens', 'descricoes', 'regiao', 'icon', 'categoria', 'precos')
                ->when($validNome)
                ->where('id', $request->nome)
                ->paginate($request->limite);

          if($catalogoID->total() == 1)
              return $catalogoID;
        }

        return Catalogo::with(
            'responsavel',
            'categoria',
            'administrador',
            'descricoes',
            'cordenadas',
            'icon',
            'caracteristicas',
            'precos',
            'imagens',
            'regiao',
            'regras')
            ->when($request->ordem !== null)
            ->orderBy($request['ordem.nome'], $request['ordem.tipo'])

            //Aplica filtro por seu nome
            ->when($validNome)
            ->where('nome', 'LIKE', '%' . $request->nome . '%')
            //Aplica filtro por catalogos ativos ou inativos
            ->when($request->active !== null)
            ->where('active', $request->active)
            //Aplica filtro por administração
            ->when($request->administrador !== null && count($request->administrador) > 0)
            ->whereHas('administrador', function ($query) use ($request) {
                $query->whereIn('id', $request->administrador);
            })
            //Aplica filtro por categoria
            ->when($request->categorias !== null && count($request->categorias) > 0)
            ->whereHas('categoria', function ($query) use ($request) {
                $query->whereIn('id', $request->categorias);
            })
            //Aplica filtro por caracteristicas descritivas
            ->when($request->caracteristicas !== null && count($request->caracteristicas) > 0)
            ->whereHas('caracteristicas', function ($query) use ($request) {
                $query->whereIn('id', $request->caracteristicas);
            })
            //Aplica filtro por região
            ->when($request->regioes !== null && count($request->regioes) > 0)
            ->whereHas('regiao', function ($query) use ($request) {
                $query->whereIn('id', $request->regioes);
            })
            //Aplica filtro por regras
            ->when($request->regras !== null && count($request->regras) > 0)
            ->whereHas('regras', function ($query) use ($request) {
                $query->whereIn('id', $request->regras);
            })
            //Aplica filtro por preço maior menor
            ->when($request->preco !== null && $request->preco > 0)
            ->whereHas('precos', function ($query) use ($request) {
                $query->where('maximo', '<=', $request->preco);
            })
            //Aplica filtro por horario
            ->when(isset($request['horario.final']) && isset($request['horario.inicial']))
            ->where('hora_inicial', '>=', $request['horario.inicial'])
            ->where('hora_final', '<=', $request['horario.final'])
            ->paginate($request->limite);

    }

    public function find($id)
    {
        return Catalogo::with('responsavel', 'categoria', 'administrador', 'descricoes', 'cordenadas', 'caracteristicas', 'precos', 'imagens', 'icon', 'regiao', 'regras')
            ->findOrFail($id);
    }

    public function update(Request $request)
    {
        Cordenada::firstWhere('id', $request['id'])->update([
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude']
        ]);
    }

    public function alterarResponsavel(Request $request)
    {
        Catalogo::firstWhere('id', $request['catalogo_id'])->update([
            'user_id' => $request['user_id']
        ]);

        return response()->json(['message' => "Responsável alterado com sucesso!", 'status' => 200], 200);

    }

    public function alterarRegiao(Request $request)
    {
        Catalogo::firstWhere('id', $request['catalogo_id'])->update([
            'regiao_id' => $request['regiao_id']
        ]);

        return response()->json(['message' => "Região alterado com sucesso!", 'status' => 200], 200);

    }

    public function editDescricao(Request $request)
    {
        if (Descricao::where('id', $request->id)->exists())
            Descricao::firstWhere('id', $request->id)->update([
                'titulo' => $request->titulo,
                'descricao' => $request->descricao
            ]);
    }

    public function deleteDescricao($id)
    {
        if (Descricao::where('id', $id)->exists())
            Descricao::firstWhere('id', $id)->delete();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required',
            'endereco' => 'bail|required',
            'descricao.descricao' => 'bail|required'
        ],
            [
                'nome.required' => 'Nome é obrigatório!',
                'endereco.required' => 'Endereço é obrigatório!',
                'descricao.descricao' => 'Descrição é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        $cordenadas = null;

        if ($request->cordenadas !== null)
            $cordenadas = Cordenada::create([
                'latitude' => $request->input('cordenadas.latitude'),
                'longitude' => $request->input('cordenadas.longitude')
            ]);

        $catalogo = Catalogo::create([
            'nome' => $request->nome,
            'endereco' => $request->endereco,
            'hora_inicial' => $request->hora_inicial,
            'hora_final' => $request->hora_final,
            'home' => $request->home !== null ? $request->home : false,
            'active' => $request->active !== null ? $request->active : false,
            'cordenadas_id' => $cordenadas !== null ? $cordenadas->id : null,
            'categoria_id' => $request->categoria !== null ? $request->input('categoria.id') : 1,
            'regiao_id' => $request->regiao !== null ? $request->input('regiao.id') : null,
            'administrador_id' => $request->administrador !== null ? $request->input('administrador.id') : null,
            'icon_id' => ($request->icon !== null && $request->input('icon.id') != null) ? $request->input('icon.id') : 1,
            'like' => $request->nome . ' ' .
                $request->endereco . ' ',
            'like_langue' => '',
            'user_id' => 1
        ]);

        $descricao = Descricao::create([
            'titulo' => $request->input('descricao.titulo'),
            'descricao' => $request->input('descricao.descricao'),
            'catalogo_id' => $catalogo->id
        ]);

        $catalogo->update([
            'like' => $catalogo->nome . ' ' .
                $catalogo->endereco . ' ' .
                MapUtil::merge(collect([$descricao]), 'titulo', 'descricao') . ' ' .
                $catalogo->nome
        ]);

        Log::channel('db')->info(
            'Criado catalogo ' . $request->id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

        return response()->json(['message' => "Catalogo criado com sucesso!", 'status' => 200], 200);
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
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        Catalogo::with('administrador', 'descricoes', 'cordenadas', 'caracteristicas', 'precos', 'imagens', 'regiao', 'regras')
            ->findOrFail($request->id)
            ->update([
                'nome' => $request->nome,
                'endereco' => $request->endereco,
                'hora_inicial' => $request->hora_inicial,
                'hora_final' => $request->hora_final,
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
                            'minimo' => $preco->minimo,
                            'maximo' => $preco->maximo,
                            'descontos' => $preco->descontos,
                            'tabela_descontos' => $preco->tabela_descontos,
                            'descricao' => $preco->descricao,
                            'catalogo_id' => $preco->catalogo_id,
                        ]);
                }
            } catch (Exception $e) {
            }
        }

        if ($request->caracteristicas !== null) {
            try {
                $catalogo->caracteristicas()->detach();
                $catalogo->caracteristicas()->attach(
                    collect($request->caracteristicas)
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

        return response()->json(['message' => "Catalogo atualizado com sucesso!", 'status' => 200], 200);
    }

    public function active($id)
    {
        $active = $this->find($id)->active ? false : true;

        Catalogo::findOrFail($id)
            ->update([
                'active' => $active
            ]);

        Log::channel('db')->info(
            'Alterado status de catalogo ' . $active . ' ' . $id . ' com usuario ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);

        return response()->json(['message' => $active ? "Catalogo ativado!" : "Catalogo foi desativado!", 'status' => 200], 200);
    }

    public function destroy($id)
    {
        $catalogo = Catalogo::findOrFail($id);

        $catalogo->caracteristicas()->detach();
        $catalogo->regras()->detach();

        $catalogo->descricoes()->delete();
        $catalogo->precos()->delete();

        if ($catalogo->imagens()->count() > 0)
            return response()->json([
                'message' => 'Primeiro remova as imagens!',
                'status' => 400], 400);


        $catalogo->delete();
        $catalogo->cordenadas()->delete();

        Log::channel('db')->info(
            'Removido ' . $id . ' com usuario ' . \auth()->user()->nome . ' e previlégios ' . \auth()->user()->perfil->nome);
        return response()->json([
            'message' => 'Catalogo removido com sucesso!',
            'status' => 200], 200);
    }
}

