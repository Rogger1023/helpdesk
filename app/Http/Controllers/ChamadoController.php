<?php

namespace App\Http\Controllers;

use App\Models\Responsavel;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ChamadoController extends Controller
{

    public function create(): Response
    {
        $responsaveis = Responsavel::all();

        return Inertia::render('Chamados/Create', [
            'responsaveis' => $responsaveis,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'prioridade' => ['required', 'in:baixa,media,alta'],
            'responsavel_id' => [
                'required',
                'exists:responsaveis,id',
            ],
        ]);

        Chamado::create($dados);

        return redirect()->route('chamados.index');
    }
    public function index(): Response
    {
        $chamados = Chamado::with('responsavel')
            ->latest()
            ->get();

        return Inertia::render('Chamados/Index', [
            'chamados' => $chamados,
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
            'in:baixa,media,alta',
        ],

        'status' => [
            'required',
            'in:aberto,em_andamento,resolvido,fechado',
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
