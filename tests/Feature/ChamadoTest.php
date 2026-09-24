<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Responsavel;
use App\Models\Chamado;

class ChamadoTest extends TestCase
{
    use RefreshDatabase;
    public function test_pode_criar_chamado_manualmente(): void
    {
        $responsavel = Responsavel::create([
            'nome' => 'Carlos Lima',
            'email' => 'carlos@empresa.com',
        ]);

        $response = $this->post('/chamados', [
            'titulo' => 'Impressora não funciona',
            'descricao' => 'A impressora do financeiro parou.',
            'prioridade' => 'alta',
            'atribuicao' => 'manual',
            'responsavel_id' => $responsavel->id,
        ]);

        $response->assertRedirect('/chamados');

        $this->assertDatabaseHas('chamados', [
            'titulo' => 'Impressora não funciona',
            'prioridade' => 'alta',
            'responsavel_id' => $responsavel->id,
        ]);
    }

    public function test_titulo_e_obrigatorio(): void{
        $responsavel = Responsavel::create([
            'nome' => 'Ana Silva',
            'email' => 'ana@empresa.com',
        ]);

        $response = $this->post('/chamados',[
            'titulo'=>'',
            'descricao'=>'Descrição de teste',
            'prioridade'=>'media',
            'atribuicao'=>'manual',
            'responsavel_id'=>$responsavel->id,
        ]);

        $response->assertSessionHasErrors([
            'titulo',
        ]);
    }

    public function test_nao_permite_responsavel_inexistente(): void{
        $response = $this->post('/chamados',[
            'titulo'=>'Problema de rede',
            'descricao'=>'Computador sem internet',
            'prioridade'=>'alta',
            'atribuicao'=>'manual',
            'responsavel_id'=>999,
        ]);

        $response->assertSessionHasErrors([
            'responsavel_id',
        ]);
    }

    public function test_chamado_novo_comeca_aberto(): void {
        $responsavel = Responsavel::create([
            'nome' => 'João Souza',
            'email' => 'joao@empresa.com',
        ]);

    
        $response = $this->post('/chamados', [
            'titulo' => 'mouse ruim',
            'descricao' => 'mouse parou.',
            'prioridade' => 'alta',
            'atribuicao' => 'manual',
            'responsavel_id' => $responsavel->id,
        ]);
        $this->assertDatabaseHas('chamados', [
        'titulo' => 'mouse ruim',
        'status' => 'aberto',
        'responsavel_id' => $responsavel->id,
        ]);
    }
    public function test_atribuicao_automatica_escolhe_responsavel_com_menos_chamados_ativos(): void
    {
        
        $ana = Responsavel::create([
            'nome' => 'Ana Silva',
            'email' => 'ana@empresa.com',
        ]);

        $carlos = Responsavel::create([
            'nome' => 'Carlos Lima',
            'email' => 'carlos@empresa.com',
        ]);

        Chamado::create([
            'titulo' => 'Chamado Ana 1',
            'descricao' => 'Teste',
            'prioridade' => 'baixa',
            'status' => 'aberto',
            'responsavel_id' => $ana->id,
        ]);

        Chamado::create([
            'titulo' => 'Chamado Ana 2',
            'descricao' => 'Teste',
            'prioridade' => 'baixa',
            'status' => 'em_andamento',
            'responsavel_id' => $ana->id,
        ]);

        Chamado::create([
            'titulo' => 'Chamado Carlos 1',
            'descricao' => 'Teste',
            'prioridade' => 'baixa',
            'status' => 'aberto',
            'responsavel_id' => $carlos->id,
        ]);

        
        $response = $this->post('/chamados', [
            'titulo' => 'Novo chamado automático',
            'descricao' => 'Teste de distribuição automática.',
            'prioridade' => 'alta',
            'atribuicao' => 'automatica',
        ]);

        
        $response->assertRedirect('/chamados');

        $this->assertDatabaseHas('chamados', [
            'titulo' => 'Novo chamado automático',
            'responsavel_id' => $carlos->id,
        ]);
    }
    public function test_chamados_concluidos_nao_entram_na_distribuicao(): void
    {
        $ana = Responsavel::create([
            'nome' => 'Ana Silva',
            'email' => 'ana@empresa.com',
        ]);

        $carlos = Responsavel::create([
            'nome' => 'Carlos Lima',
            'email' => 'carlos@empresa.com',
        ]);

        Chamado::create([
            'titulo' => 'Chamado Ana 1',
            'descricao' => 'Teste',
            'prioridade' => 'baixa',
            'status' => 'aberto',
            'responsavel_id' => $ana->id,
        ]);

        Chamado::create([
            'titulo' => 'Chamado Ana 2',
            'descricao' => 'Teste',
            'prioridade' => 'baixa',
            'status' => 'resolvido',
            'responsavel_id' => $ana->id,
        ]);

        Chamado::create([
            'titulo' => 'Chamado carlos 1',
            'descricao' => 'Teste',
            'prioridade' => 'baixa',
            'status' => 'aberto',
            'responsavel_id' => $carlos->id,
        ]);

        Chamado::create([
            'titulo' => 'Chamado Carlos 2',
            'descricao' => 'Teste',
            'prioridade' => 'baixa',
            'status' => 'em_andamento',
            'responsavel_id' => $carlos->id,
        ]);

        $response = $this->post('/chamados', [
            'titulo' => 'Novo chamado automático',
            'descricao' => 'Teste de distribuição automática.',
            'prioridade' => 'alta',
            'atribuicao' => 'automatica',
        ]);

        
        $response->assertRedirect('/chamados');

        $this->assertDatabaseHas('chamados', [
            'titulo' => 'Novo chamado automático',
            'responsavel_id' => $ana->id,
        ]);

    }
}
