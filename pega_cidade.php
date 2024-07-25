<?php
include('connection.php');


if(isset($_POST['id'])) {

    $idEstado = $_POST['id'];

    $sql_code_cidade = "SELECT * FROM tb_cidade WHERE fk_id_estado = '$idEstado' ORDER BY 'nm_cidade'";
    $sql_query_cidade = $mysqli->query($sql_code_cidade) or die($mysqli->error);


    if($sql_query_cidade->num_rows > 0) {

        while ($cidades = $sql_query_cidade->fetch_assoc()) {
            echo '<option value="' . $cidades['id_cidade'] . '">' . $cidades['nm_cidade'] . '</option>';

        }
    } else {
        echo '<option value="">Nenhuma cidade encontrada</option>';
    }
}
?>
