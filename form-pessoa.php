<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Form Pessoa</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
    <?php
include 'conectar.php';
$id = $nome = $email = $cpf = "";
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (array_key_exists('id',$_GET)){
        $id = $_GET['id'];
        $pessoa = buscar($id);
        $nome = $pessoa['nome'];
        $email = $pessoa['email'];
    }
    if (array_key_exists('apagar',$_GET)){
        $apagar = $_GET['apagar'];
        $msg = apagar($apagar);
    }
}
?>
    <section class="left">
        <form action="form-pessoa.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <h1>Formulário de Pessoa</h1>
            <label for="">Nome:</label>
            <input type="text" name="nome" value="<?php echo $nome; ?>"><br>
            <label for="">E-mail:</label>
            <input type="text" name="email" value="<?php echo $email; ?>"><br>
            <label for="">CPF:</label>
            <input type="text" name="cpf" value="<?php echo $cpf; ?>">
            <input type="submit" value="Gravar" class="btn_submit">
        </form>
        <?php
//  onclick="window.location.replace('form-pessoa.php');"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];

    $id = $_POST['id'];
    if($id == ''){
        $msg = incluir($nome, $email, $cpf);
    } else {
        $msg = alterar($id, $nome, $email, $cpf);
    }
}

?>
    </section>
    <section class="right">
        <table>
            <tr class="title">
                <td>Id</td>
                <td>Nome</td>
                <td>Email</td>
                <td colspan=4>CPF</td>
            </tr>
            <?php
        $dados = listar();
        while ($linha = $dados->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$linha['id']."</td>";
            echo "<td>".$linha['nome']."</td>";
            echo "<td>".$linha['email']."</td>";
            echo "<td>".$linha['cpf']."</td>";
            echo "<td><a href='form-pessoa.php?id=".$linha['id']."'>Editar</a></td>";
            echo "<td><a href='form-pessoa.php?apagar=".$linha['id']."'>Apagar</a></td>";
            echo "</tr>";
        }
        ?>
        </table>
    </section>
</body>

</html>