<?php
ob_start();
include('connection.php');

$wizard = "ASB V.23/wizard.png"; 
use Dompdf\Dompdf;
use Dompdf\Options;

require_once 'dompdf-2.0.8/dompdf/autoload.inc.php';


if (isset($_GET['id'])) {
    // Recuperar o ID do empréstimo da solicitação
    $id = $_GET['id'];

    // Consultar o banco de dados para obter os dados do empréstimo

    $sql_emprestimo = "SELECT e.*, c.*, u.*, l.*, a.*, ed.*, 
       DATE_FORMAT(e.dt_devolucao, '%d/%m/%Y') AS dt_devolucao,
       DATE_FORMAT(e.dt_emprestimo, '%d/%m/%Y') AS dt_emprestimo
        FROM tb_emprestimo e
        INNER JOIN tb_cliente c ON e.fk_id_cliente = c.id_cliente
        INNER JOIN tb_livro l ON e.fk_id_livro = l.id_livro
        INNER JOIN tb_usuario u ON e.fk_id_usuario = u.id_usuario
        INNER JOIN tb_autor a ON l.fk_id_autor = a.id_autor
        INNER JOIN tb_editora ed ON l.fk_id_editora = ed.id_editora
        WHERE e.id_emprestimo = $id";



    $result = $mysqli->query($sql_emprestimo);


    // Verificar se o empréstimo foi encontrado
    if ($result && $result->num_rows > 0) {
        // Extrair os dados do empréstimo
        $emprestimo = $result->fetch_assoc();

        // Gerar o PDF
        // Inicializar as opções do Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        // Instanciar o Dompdf com as opções
        $dompdf = new Dompdf($options);

        // Conteúdo HTML do PDF
        $html = '
        <!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Comprovante de Empréstimo</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap");

        body {
            font-family: "Poppins", sans-serif;
        }

        .container {
            border: 2px solid #1d283c;
            padding: 15px;
            position: relative;
            font-size: 12px;
        }

        .container h2{
            margin-top: -5px;
            margin-bottom: 0px;
        }

        .container p {
            margin: 3px;
        }

        .container-border {
            border: 2px solid #6291fd;
        }

        .logo {
            position: absolute;
            right: 20px;
            bottom: 45px;
        }

        .termo {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .termo h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .assinatura,
        .local-data {
            margin-top: 30px;
            text-align: center;
        }

        .assinatura {
            margin-bottom: 50px;
        }

        .assinatura-line,
        .local-data-line {
            display: inline-block;
            width: 60%;
            border-bottom: 1px solid #000;
            margin-top: 50px;
        }
        .destacar{
            margin-top: 50px;
            border-bottom: 4px dotted #000; 
        }
    </style>
</head>

<body>
    <div class="container-border">
        <div class="container">
            <h2>Comprovante de empréstimo</h2>
            <p>Nome: ' . $emprestimo['nm_cliente'] . ' </p>
            <p>Cód. do Empréstimo: ' . $emprestimo['id_emprestimo'] . ' </p>
            <p>Livro: ' . $emprestimo['nm_livro'] . ' </p>
            <p>Data de Empréstimo: ' . $emprestimo['dt_emprestimo'] . ' </p>
            <p>Data de Devolução: ' . $emprestimo['dt_devolucao'] . ' </p>
            <p>Preço de Empréstimo: R$ ' . $emprestimo['preco_emprestimo'] . ' </p>
            <p style="font-size: 12px;">Este não é um documento fiscal</p>
            <img src="'.$wizard.'" class="logo" width="120">
            
        </div>
    </div>
    <div class="destacar"></div>
    <div class="termo">
        <h2>Declaração de Empréstimo de Livro</h2>
        <p>Eu, <strong>' . $emprestimo['nm_cliente'] . '</strong>, portador(a) do CPF nº <strong>' . $emprestimo['cpf'] .
            '</strong>, residente à <strong>' . $emprestimo['end_rua'] . ' , ' . $emprestimo['end_nro'] . ' , '
            . $emprestimo['end_bairro'] . '</strong>, declaro para os devidos fins que recebi em empréstimo o livro
            abaixo especificado de:</p>

        <p><strong>Dados do Livro:</strong></p>

        <p><strong>Título do Livro:</strong> ' . $emprestimo['nm_livro'] . '</p>
        <p><strong>Autor do Livro:</strong> ' . $emprestimo['autor'] . '</p>
        <p><strong>Editora:</strong> ' . $emprestimo['editora'] . '</p>
        <p><strong>ISBN:</strong> ' . $emprestimo['isbn'] . '</p>

        <p><strong>Data de Empréstimo:</strong> ' . $emprestimo['dt_emprestimo'] . '</p>
        <p><strong>Data de Devolução:</strong> ' . $emprestimo['dt_devolucao'] . '</p>

        <p>Comprometo-me a devolver o livro em perfeitas condições de uso na data acordada acima. Em caso de perda ou
            danos ao livro, comprometo-me a repor um exemplar idêntico ou ressarcir o valor do mesmo.</p>

        <div class="assinatura">
            <div class="local-data-line"></div><br>
            Assinatura
        </div>

        <div class="local-data">
            Local e Data:
            <div class="local-data-line"></div>
        </div>
    </div>
</body>

</html>
        ';

        // Carregar o conteúdo HTML no Dompdf
        $dompdf->loadHtml($html);

        // Renderizar o PDF
        $dompdf->render();

        // Saída do PDF (nome do arquivo)
        $dompdf->stream('informacoes_emprestimo.pdf', ['Attachment' => false]);
    } else {
        echo "Empréstimo não encontrado.";
    }
} else {
    echo "ID do empréstimo não especificado.";
}
