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

        return redirect()->route('chamados.create');
    }
}
