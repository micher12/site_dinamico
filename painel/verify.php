<?php
//caso tente entrar pela url
if($_SESSION['passcode'] == true){
    
    if(isset($_POST['validar'])){
        $codigo = $_POST['code'];
        if($_SESSION['verifycode'] == $codigo){
            $user = mb_strtolower($_SESSION['user']);
            $email = $_SESSION['email'];
            $password = $_SESSION['password'];
            $nome = $_SESSION['nome'];
            $img = $_SESSION['img'];
            $cargo = $_SESSION['cargo'];
            $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.usuarios` VALUES(null,?,?,?,?,?,?) ");
            $cadastros = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios`");
            $cadastros->fetchAll();
            $cadastros->execute();

            if($sql->execute(array($user,$email,$password,$img,$nome,$cargo))){
                $_SESSION['passcode'] = false;
                $_SESSION['login'] = true;
                $_SESSION['cadastrado'] = $cadastros->rowCount();
                Painel::alert("sucesso",'Conta registrada com sucesso!');
            }else{
                Painel::alert("error",'algo deu errado.');
            }
        }else{
            Painel::alert('error',"O codigo não é valido.");
        }
    }else if(isset($_POST['reenviar'])){
        $token = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        $_SESSION['verifycode'] = $token;
        if(Painel::verifyCode($_SESSION['email'],$_SESSION['verifycode'],$_SESSION['nome'])){
            Painel::alert("sucesso",'Novo codigo de confirmação foi enviado!');
        }
    }
?>  
    <div class="verify-code">
        <form method="post" class='verifycode'>
            <div class='flex' style='align-items: center'>
                <label style="white-space: nowrap; padding-right: 10px">Codigo de verificação: </label>
                <input type="text" name='code'>
                <input style='' type="submit" name='validar' value="Verificar">
            </div>
        </form>

        <form method='post' class='reenviar-code'>
            <label class='contagem' ></label>
            <input  type="submit" name='reenviar' value="reeviarcodigo">
        </form>
        
    </div>
    

<?php 
}else{
    echo "<div style='text-align: center; padding-top: 20px;'>Não foi enviado um codigo registro ainda</div>";
}
?>
