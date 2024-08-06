<?php
class Aluno {
    public $nome;
    public $notas = array();
    public $media = 0;
    public $total = 0;
    public $status = '';

    function __construct($nome) {
        $this->nome = $nome;
    }

    function atribuirNotas($notas) {
        if (count($notas) == 4 && $this->validarNotas($notas)) {
            $this->notas = $notas;
            $this->calcularTotalEMedia();
            $this->atribuirStatus();
        } else {
            echo "Notas inválidas. Certifique-se de que são 4 notas entre 0 e 10.\n";
        }
    }

    function validarNotas($notas) {
        foreach ($notas as $nota) {
            if ($nota < 0 || $nota > 10) {
                return false;
            }
        }
        return true;
    }

    function calcularTotalEMedia() {
        $this->total = array_sum($this->notas);
        $this->media = $this->total / 4;
    }

    function atribuirStatus() {
        if ($this->media < 4) {
            $this->status = 'Reprovado';
        } elseif ($this->media <= 6) {
            $this->status = 'Recuperação';
        } else {
            $this->status = 'Aprovado';
        }
    }

    function editarNotas($notas) {
        $this->atribuirNotas($notas);
    }

    function exibirResultado() {
        echo "Nome: " . $this->nome . "\n";
        echo "Notas: " . implode(", ", $this->notas) . "\n";
        echo "Total: " . $this->total . "\n";
        echo "Média: " . $this->media . "\n";
        echo "Status: " . $this->status . "\n";
    }
}

$alunos = array();

function menu() {
    echo "\nSistema de Gestão de Notas de Alunos\n";
    echo "1. Cadastrar Aluno\n";
    echo "2. Atribuir Notas\n";
    echo "3. Exibir Resultados\n";
    echo "4. Editar Notas\n";
    echo "5. Sair\n";
    echo "Escolha uma opção: ";
}

function cadastrarAluno(&$alunos) {
    if (count($alunos) < 5) {
        echo "Digite o nome do aluno: ";
        $nome = trim(fgets(STDIN));
        $alunos[] = new Aluno($nome);
        echo "Aluno cadastrado com sucesso!\n";
    } else {
        echo "Limite de alunos atingido.\n";
    }
}

function atribuirNotas(&$alunos) {
    echo "Digite o nome do aluno para atribuir notas: ";
    $nome = trim(fgets(STDIN));
    foreach ($alunos as $aluno) {
        if ($aluno->nome == $nome) {
            echo "Digite 4 notas separadas por espaço: ";
            $notas = explode(" ", trim(fgets(STDIN)));
            $aluno->atribuirNotas(array_map('floatval', $notas));
            echo "Notas atribuídas com sucesso!\n";
            return;
        }
    }
    echo "Aluno não encontrado.\n";
}

function exibirResultados($alunos) {
    foreach ($alunos as $aluno) {
        $aluno->exibirResultado();
        echo "--------------------\n";
    }
}

function editarNotas(&$alunos) {
    echo "Digite o nome do aluno para editar notas: ";
    $nome = trim(fgets(STDIN));
    foreach ($alunos as $aluno) {
        if ($aluno->nome == $nome) {
            echo "Digite 4 novas notas separadas por espaço: ";
            $notas = explode(" ", trim(fgets(STDIN)));
            $aluno->editarNotas(array_map('floatval', $notas));
            echo "Notas editadas com sucesso!\n";
            return;
        }
    }
    echo "Aluno não encontrado.\n";
}

do {
    menu();
    $opcao = trim(fgets(STDIN));
    switch ($opcao) {
        case 1:
            cadastrarAluno($alunos);
            break;
        case 2:
            atribuirNotas($alunos);
            break;
        case 3:
            exibirResultados($alunos);
            break;
        case 4:
            editarNotas($alunos);
            break;
        case 5:
            echo "Saindo do sistema...\n";
            break;
        default:
            echo "Opção inválida. Tente novamente.\n";
    }
} while ($opcao != 5);
?>
