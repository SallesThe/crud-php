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
        include 'cpf_validation.php';
        $msgCpf = $id = $nome = $email = $cpf = $genero = $escolaridade = "";
        if($_SERVER["REQUEST_METHOD"] == "GET"){
            if (array_key_exists('id',$_GET)){
                $id = $_GET['id'];
                $pessoa = buscar($id);
                $nome = $pessoa['nome'];
                $email = $pessoa['email'];
                $cpf = $pessoa['cpf'];
                $genero = $pessoa['genero'];
                $escolaridade = $pessoa['escolaridade'];
            }
            if (array_key_exists('apagar',$_GET)){
                $apagar = $_GET['apagar'];
                $msg = apagar($apagar);
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $msg = "";
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $cpf = $_POST['cpf'];
            $genero = $_POST['genero'];
            $escolaridade = $_POST['escolaridade'];
            $id = $_POST['id'];
        
            $cpf = str_replace(".","",$cpf);
            $cpf = str_replace("-","",$cpf);
        
            if(validarCpf($cpf)){
                if($id == ''){
                    $senha = $_POST['senha'];
                    $confirmar_senha = $_POST['confirmar'];
                    if ($senha == $confirmar_senha) {
                        $msg = incluir($nome, $email, $cpf, $genero, $escolaridade, $senha);
                    } else {
                        $msg = "Senhas divergentes!";
                    }

                } else {
                    $msg = alterar($id, $nome, $email, $cpf, $genero, $escolaridade);
                }
            }else{
                $msgCpf = "CPF inválido!";
            }
            
            echo $msg;
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
            <div class="form__input__radio">
                <label for="">Masculino</label>
                <input type="radio" name="genero" value="M" required <?php if($genero === "M" ) echo "checked"; ?>>
                <label for="">Feminino</label>
                <input type="radio" name="genero" value="F" required <?php if($genero === "F" )  echo  "checked"; ?>>
            </div>
            <label for="">Escolaridade</label>
            <select name="escolaridade" id="escolaridade" required>
                <option value="">Selecione</option>
                <option <?php if($escolaridade == "Sem escolaridade") { echo "selected";} ?> value="Sem escolaridade">Sem escolaridade</option>
                <option <?php if($escolaridade == "Ensino Fundamental") { echo "selected";} ?> value="Ensino Fundamental">Ensino Fundamental</option>
                <option <?php if($escolaridade == "Ensino Médio") { echo "selected";} ?> value="Ensino Médio">Ensino Médio</option>
                <option <?php if($escolaridade == "Ensino Superior") { echo "selected";} ?> value="Ensino Superior">Ensino Superior</option>
            </select>
            <?php if(!isset($_GET['id'])) { ?>
                <label for="">Senha:</label>
                <input type="password" name="senha" id="" required>
                <label for="">Confirme sua Senha:</label>
                <input type="password" name="confirmar" id="">
            <?php } ?>  
                <input type="submit" value="Registrar" class="btn_submit">
            <a href="form-pessoa.php" style="text-decoration: none;">
                <input type="button" value="Limpar" class="btn_submit">
            </a>
    </section>

    <section class="right">
        <table>
            <tr class="title">
                <td>Id</td>
                <td>Nome</td>
                <td>Email</td>
                <td>CPF</td>
                <td>Gênero</td>
                <td>Escolaridade</td>
                <td colspan="2"></td>
            </tr>
            <?php
                $dados = listar();
                while ($linha = $dados->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$linha['id']."</td>";
                    echo "<td>".$linha['nome']."</td>";
                    echo "<td>".$linha['email']."</td>";
                    echo "<td>".$linha['cpf']."</td>";
                    echo "<td>".$linha['genero']."</td>";
                    echo "<td>".$linha['escolaridade']."</td>";
                    echo "<td><a href='form-pessoa.php?id=".$linha['id']."'>Editar</a></td>";
                    echo "<td><a onclick='return apagar(".$linha['id'].");' href='form-pessoa.php?apagar=".$linha['id']."'>Apagar</a></td>";
                    echo "</tr>";
                }
            ?>
            <script>
                const apagar = (id) => confirm(`Deseja apagar o registro ID("${id}")`);
            </script>
        </table>
    </section>
</body>

</html>