<?php

namespace App\Http\Controllers;

use App\Events\EventResponse;
use App\Models\Account\User;
use App\Models\Catalogo\Catalogo;
use App\Models\Catalogo\Cordenada;
use App\Models\Catalogo\Descricao;
use App\Models\Catalogo\Preco;
use App\Models\util\MapUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class CatalogoController extends Controller
{

    public function list()
    {
        return Catalogo::all();
    }

    public function listPorUser($userId)
    {
        return Catalogo::with(
            'caracteristicas',
            'cordenadas',
            'responsavel',
            'regras',
            'administrador',
            'imagens',
            'descricoes',
            'regiao',
            'icon',
            'categoria',
            'precos',
            'regras')
            ->where('user_id', $userId)
            ->paginate();
    }

    public function random(Request $request)
    {
        return Catalogo::with(
            'imagens')
            ->where('home', true)
            ->where('active', true)
            ->orderByRaw('RAND() LIMIT 14')
            ->get();

        //->unique('categoria_id')
        //->values()->toArray();

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

        $user = new User();

        $isIncludeUser = false;

        if (auth()->user()) {
            $user = User::with('perfil')->find(auth()->user()->id);
            if ($user->perfil->role == "MANAGER")
                $isIncludeUser = true;
        }

        $catalogoID = Catalogo::with(
            'caracteristicas',
            'cordenadas',
            'responsavel',
            'administrador',
            'imagens',
            'descricoes',
            'regiao',
            'icon',
            'categoria',
            'precos',
            'regras')
            ->when($isIncludeUser)
            ->where('user_id', $user->id)
            ->when($validNome)
            ->where('id', $request->nome)
            ->paginate($request->limite);

        if ($catalogoID->total() == 1)
            return $catalogoID;


        return Catalogo::with(
            'caracteristicas',
            'cordenadas',
            'responsavel',
            'administrador',
            'imagens',
            'descricoes',
            'regiao',
            'icon',
            'categoria',
            'precos',
            'regras')
            ->when($isIncludeUser)
            ->where('user_id', $user->id)
            ->when($validNome)
            ->where('like', 'LIKE', '%' . $request->nome . '%')
            ->when($request->ordem !== null)
            ->orderBy($request['ordem.nome'], $request['ordem.tipo'])
            ->paginate($request->limite);
    }

    public function filter(Request $request)
    {

        $validNome = (isset($request->nome) && strlen($request->nome) > 2);

        if ($validNome) {
            $catalogoID = Catalogo::with(
                'caracteristicas',
                'cordenadas',
                'responsavel',
                'administrador',
                'imagens',
                'descricoes',
                'regiao',
                'icon',
                'categoria',
                'precos',
                'regras')
                ->when($validNome)
                ->where('id', $request->nome)
                ->where('active', 1)
                ->paginate($request->limite);

            if ($catalogoID != null && $catalogoID->total() == 1)
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
            ->where('like', 'LIKE', '%' . $request->nome . '%')
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
            ->when($request->horario !== null)
            ->where('hora_inicial', '>=', $request['horario.inicial'])
            ->when($request->horario !== null)
            ->where('hora_final', '<=', $request['horario.final'])
            ->where('active', 1)
            ->paginate($request->limite);

    }

    public function find($id)
    {
        return Catalogo::with(
            'responsavel',
            'categoria',
            'administrador',
            'descricoes',
            'cordenadas',
            'caracteristicas',
            'precos',
            'imagens',
            'icon',
            'regiao',
            'regras')
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

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome' => 'bail|required'
        ],
            [
                'nome.required' => 'Nome é obrigatório!',
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
            'descricao_principal' => $request->descricao_principal,
            'hora_inicial' => $request->hora_inicial,
            'hora_final' => $request->hora_final,
            'home' => $request->home !== null ? $request->home : false,
            'active' => false,
            'cordenadas_id' => $cordenadas !== null ? $cordenadas->id : null,
            'categoria_id' => $request->categoria !== null ? $request->input('categoria.id') : 1,
            'regiao_id' => $request->regiao !== null ? $request->input('regiao.id') : null,
            'administrador_id' => $request->administrador !== null ? $request->input('administrador.id') : null,
            'icon_id' => ($request->icon !== null && $request->input('icon.id') != null) ? $request->input('icon.id') : 1,
            'like' => $request->nome . ' ' .
                $request->endereco . ' ',
            'user_id' => 1
        ]);

        Preco::create([
            'descricao' => 'Valores',
            'descontos' => false,
            'minimo' => 0,
            'maximo' => 0,
            'catalogo_id' => $catalogo->id
        ]);

        $catalogo->update([
            'like' => $catalogo->nome . ' ' .
                $catalogo->endereco . ' ' . $catalogo->descricao_principal
        ]);

        Log::channel('db')->info(
            'Criado catalogo ' . $request->id . ' com usuario ' . auth()->user()->nome . ' e previlégios ' . auth()->user()->perfil->role);

        return response()->json(['message' => "Catalogo criado com sucesso!", 'status' => 200], 200);
    }

    public function edit(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'bail|required',
            'nome' => 'bail|required'
        ],
            [
                'id.required' => 'Campo id é obrigatório!',
                'nome.required' => 'Nome é obrigatório!'
            ]);

        if ($validator->fails())
            return response()->json(['errors' => MapUtil::format($validator->messages()), 'status' => 400], 400);

        $catalogoDB = Catalogo::with('administrador', 'descricoes', 'cordenadas', 'caracteristicas', 'precos', 'imagens', 'regiao', 'regras')
            ->findOrFail($request->id);

        $catalogoDB->update([
            'nome' => $request->nome,
            'descricao_principal' => $request->descricao_principal,
            'endereco' => $request->endereco,
            'hora_inicial' => $request->hora_inicial,
            'hora_final' => $request->hora_final,
            'home' => $request->home,
            'active' => $request->active,
            'categoria_id' => $request->input('categoria.id'),
            'regiao_id' => $request->input('regiao.id'),
            'administrador_id' => $request->input('administrador.id'),
            'like' => $this->getLike($catalogoDB)
        ]);

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

    public function sicronizarLike()
    {
        $catalogos = Catalogo::with("descricoes")->get();

        foreach ($catalogos as $catalogo) {
            if ($catalogo->descricoes != null) {
                $descricao = $catalogo->descricoes->first();
                if ($descricao != null) {
                    if (strlen($descricao->descricao) > 50)
                        if (!(str_contains($descricao->descricao, '<li>')))
                            if (!(str_contains($descricao->descricao, '<br')))
                                if (!(str_contains($descricao->descricao, '<p>')))
                                    if (!(str_contains($descricao->descricao, '<p>'))) {
                                        $catalogo->descricao_principal = $descricao->descricao;
                                        $catalogo->save();
                                        $descricao->delete();
                                    }

                }
            }

        }
    }

    private function getLike($catalogo)
    {
        return substr(str_replace(["<br />", "<br>", "<ul>", "</ul>", "<li>", "</li>"], "", $catalogo->nome . ' ' . $catalogo->descricao_principal . ' ' . MapUtil::merge(collect($catalogo->descricoes), '', 'descricao')), 0, 2000);
    }
}

