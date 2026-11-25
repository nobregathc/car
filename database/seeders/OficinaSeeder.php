<?php

namespace Database\Seeders;

use App\Models\Agendamento;
use App\Models\CategoriaServico;
use App\Models\Servico;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class OficinaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Utilizadores
        $admin = User::updateOrCreate(
            ['email' => 'admin@oficina.pt'],
            [
                'name' => 'Admin AutoFix',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        $cliente = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'João Silva',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        // 2. Categorias
        $catMecanica = CategoriaServico::updateOrCreate(
            ['nome' => 'Mecânica Geral'],
            ['descricao' => 'Revisões periódicas, travagem, amortecedores, distribuição e mecânica pesada.']
        );

        $catPneus = CategoriaServico::updateOrCreate(
            ['nome' => 'Pneus e Alinhamento'],
            ['descricao' => 'Substituição e montagem de pneus, alinhamento de direção 3D e calibração de rodas.']
        );

        $catDiagnostico = CategoriaServico::updateOrCreate(
            ['nome' => 'Diagnóstico e Eletrónica'],
            ['descricao' => 'Diagnóstico avançado com máquina computorizada, teste de baterias e módulos eletrónicos.']
        );

        $catAC = CategoriaServico::updateOrCreate(
            ['nome' => 'Ar Condicionado e Climatização'],
            ['descricao' => 'Carga e manutenção de ar condicionado, desinfeção do habitáculo e troca de filtros.']
        );

        // 3. Serviços
        $s1 = Servico::updateOrCreate(
            ['nome' => 'Mudança de Óleo e Filtros'],
            [
                'categoria_servico_id' => $catMecanica->id,
                'descricao' => 'Substituição de óleo de motor 100% sintético homologado e todos os filtros (óleo, ar, combustível e habitáculo).',
                'preco' => 89.90,
                'duracao_minutos' => 60,
                'imagem_url' => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=800',
            ]
        );

        $s2 = Servico::updateOrCreate(
            ['nome' => 'Substituição de Pastilhas de Travão'],
            [
                'categoria_servico_id' => $catMecanica->id,
                'descricao' => 'Substituição de pastilhas dianteiras ou traseiras com verificação do estado dos discos e fluido de travão.',
                'preco' => 65.00,
                'duracao_minutos' => 45,
                'imagem_url' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?w=800',
            ]
        );

        $s3 = Servico::updateOrCreate(
            ['nome' => 'Alinhamento de Direção 3D'],
            [
                'categoria_servico_id' => $catPneus->id,
                'descricao' => 'Alinhamento a laser 3D aos eixos dianteiro e traseiro com relatório gráfico de cotas.',
                'preco' => 35.00,
                'duracao_minutos' => 30,
                'imagem_url' => 'https://images.unsplash.com/photo-1578844251758-2f71da64c96f?w=800',
            ]
        );

        $s4 = Servico::updateOrCreate(
            ['nome' => 'Diagnóstico Eletrónico Computorizado'],
            [
                'categoria_servico_id' => $catDiagnostico->id,
                'descricao' => 'Leitura completa de códigos de erro OBD2 em todas as centralinas (motor, ABS, airbag, etc.).',
                'preco' => 40.00,
                'duracao_minutos' => 30,
                'imagem_url' => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=800',
            ]
        );

        $s5 = Servico::updateOrCreate(
            ['nome' => 'Recarga e Higienização de Ar Condicionado'],
            [
                'categoria_servico_id' => $catAC->id,
                'descricao' => 'Recarga com gás R134a/R1234yf, vácuo ao circuito, teste de fugas e desinfeção com ozono.',
                'preco' => 59.00,
                'duracao_minutos' => 45,
                'imagem_url' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800',
            ]
        );

        // 4. Agendamentos de demonstração para o calendário
        $hoje = Carbon::today();

        Agendamento::updateOrCreate(
            ['data_hora' => $hoje->copy()->setTime(9, 30), 'user_id' => $cliente->id],
            [
                'servico_id' => $s1->id,
                'veiculo' => 'Renault Mégane 1.5 dCi (45-AB-67)',
                'estado' => 'confirmado',
                'observacoes' => 'Revisão dos 120.000 km.',
                'notas_admin' => 'Filtro específico já em stock.',
            ]
        );

        Agendamento::updateOrCreate(
            ['data_hora' => $hoje->copy()->setTime(14, 0), 'user_id' => $cliente->id],
            [
                'servico_id' => $s3->id,
                'veiculo' => 'Volkswagen Golf VII (89-CD-12)',
                'estado' => 'pendente',
                'observacoes' => 'Volante treme a 100km/h.',
            ]
        );

        Agendamento::updateOrCreate(
            ['data_hora' => $hoje->copy()->addDays(2)->setTime(11, 0), 'user_id' => $cliente->id],
            [
                'servico_id' => $s4->id,
                'veiculo' => 'BMW Série 1 116d (12-EF-34)',
                'estado' => 'confirmado',
                'observacoes' => 'Luz da injeção acesa no painel.',
            ]
        );

        Agendamento::updateOrCreate(
            ['data_hora' => $hoje->copy()->addDays(4)->setTime(16, 30), 'user_id' => $cliente->id],
            [
                'servico_id' => $s2->id,
                'veiculo' => 'Audi A4 Avant (99-GH-55)',
                'estado' => 'pendente',
                'observacoes' => 'Ruído metálico ao travar.',
            ]
        );

        Agendamento::updateOrCreate(
            ['data_hora' => $hoje->copy()->subDays(3)->setTime(10, 0), 'user_id' => $cliente->id],
            [
                'servico_id' => $s5->id,
                'veiculo' => 'Peugeot 208 (33-IJ-77)',
                'estado' => 'concluido',
                'observacoes' => 'Não faz ar frio.',
                'notas_admin' => 'Carga efetuada com sucesso sem fugas detetadas.',
            ]
        );
    }
}
