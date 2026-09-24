<?php

namespace App\Http\Controllers;

use App\Models\Responsavel;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Enums\PrioridadeChamado;
use App\Enums\StatusChamado;
use Illuminate\Validation\Rule;
use App\Services\DistribuidorChamados;


class ChamadoController extends Controller
{

    public function create(): Response
    {
        $responsaveis = Responsavel::all();

        return Inertia::render('Chamados/Create', [
            'responsaveis' => $responsaveis,
        ]);
    }

    public function store(
    Request $request,
    DistribuidorChamados $distribuidor
    ): RedirectResponse
    {
        $dados = $request->validate([
            'titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'descricao' => [
                'required',
                'string',
            ],

            'prioridade' => [
                'required',
                Rule::enum(PrioridadeChamado::class),
            ],

            'atribuicao' => [
                'required',
                'in:manual,automatica',
            ],

            'responsavel_id' => [
                'nullable',
                'required_if:atribuicao,manual',
                'exists:responsaveis,id',
            ],
        ]);

        if ($dados['atribuicao'] === 'automatica') {
            $responsavel = $distribuidor->escolherResponsavel();

            $dados['responsavel_id'] = $responsavel->id;
        }

        unset($dados['atribuicao']);
        Chamado::create($dados);

    return redirect()->route('chamados.index');
}
    public function index(Request $request): Response
    {
        $query = Chamado::query()
            ->with('responsavel')

            ->when(
                $request->input('busca'),
                function ($query, $busca) {
                    $query->where(
                        'titulo',
                        'like',
                        "%{$busca}%"
                    );
                }
            )

            ->when(
                $request->input('status'),
                function ($query, $status) {
                    $query->where('status', $status);
                }
            )

            ->when(
                $request->input('prioridade'),
                function ($query, $prioridade) {
                    $query->where(
                        'prioridade',
                        $prioridade
                    );
                }
            )

            ->when(
                $request->input('responsavel_id'),
                function ($query, $responsavelId) {
                    $query->where(
                        'responsavel_id',
                        $responsavelId
                    );
                }
            );

        if ($request->input('ordem') === 'antigos') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $chamados = $query->get();

        return Inertia::render('Chamados/Index', [
            'chamados' => $chamados,

            'responsaveis' => Responsavel::all(),

            'filtros' => $request->only([
                'busca',
                'status',
                'prioridade',
                'responsavel_id',
                'ordem',
            ]),
        ]);
    }

    public function show(Chamado $chamado): Response
    {
        $chamado->load('responsavel');

        return Inertia::render('Chamados/Show', [
            'chamado' => $chamado,
        ]);
    }

    public function edit(Chamado $chamado): Response 
    {
        $responsaveis = Responsavel::all();

        return Inertia::render('Chamados/Edit',[
            'chamado' => $chamado,
            'responsaveis' => $responsaveis,
        ]);
    }

    public function update(Request $request,Chamado $chamado): RedirectResponse
    {
    $dados = $request->validate([
        'titulo' => [
            'required',
            'string',
            'max:255',
        ],

        'descricao' => [
            'required',
            'string',
        ],

        'prioridade' => [
            'required',
            Rule::enum(PrioridadeChamado::class)
        ],

        'status' => [
            'required',
            Rule::enum(StatusChamado::class),
        ],

        'responsavel_id' => [
            'required',
            'exists:responsaveis,id',
        ],
    ]);

    $chamado->update($dados);

    return redirect()
        ->route('chamados.show', $chamado);
    }
}
