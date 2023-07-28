<?php
    if(isset($_COOKIE['lembrar'])){
        $email = $_COOKIE['email'];
        $password = $_COOKIE['senha'];

        $cadastros = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios`");
        $cadastros->fetchAll();
        $cadastros->execute();

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE `email` = ? AND `password` = ? ");
        $sql->execute(array($email,$password));
        if($sql->rowCount() == 1){
            //logado com sucesso!
            $info = $sql->fetch();
            $_SESSION['user'] = $info['user'];
            $_SESSION['login'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['cargo'] = $info['cargo'];
            $_SESSION['nome'] = $info['nome'];
            $_SESSION['img'] = $info['img'];
            $_SESSION['password'] = $password;
            $_SESSION['cadastrado'] = $cadastros->rowCount();
            header('Location: '.INCLUDE_PATH.'painel/');
            die();
        }

    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="<?php echo INCLUDE_PATH; ?>js/painel.js"></script>
    <script src='<?php echo INCLUDE_PATH?>js/all.min.js'></script>
    <script src='<?php echo INCLUDE_PATH?>js/jquery.magnific-popup.min.js'></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!--google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;600;700&family=Chivo+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,400&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Lalezar&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500&family=Open+Sans:wght@300;400;500;600&family=Oxygen:wght@300;400;700&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/all.min.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/painel.css">
    <link rel="icon" type="image/x-icon" href="../login-icon.svg">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/magnific-popup.css">
</head>
<body>
    
    <div class="center">
        <?php
            if(isset($_POST['acao'])){
                $email = $_POST['email'];
                $password = $_POST['password'];
                $cadastros = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios`");
                $cadastros->fetchAll();
                $cadastros->execute();
                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` WHERE `email` = ? AND `password` = ? ");
                $sql->execute(array($email,$password));
                if($sql->rowCount() == 1){
                    if(isset($_POST['lembrar'])){
                        setcookie('lembrar',true,time()+(60*60*24*7), '/');
                        setcookie('email',$email,time()+(60*60*24*7), '/' );
                        setcookie('senha',$password,time()+(60*60*24*7), '/');
                    }

                    $info = $sql->fetch();
                    //logado com sucesso!
                    $_SESSION['user'] = $info['user'];
                    $_SESSION['login'] = true;
                    $_SESSION['email'] = $email;
                    $_SESSION['cargo'] = $info['cargo'];
                    $_SESSION['nome'] = $info['nome'];
                    $_SESSION['img'] = $info['img'];
                    $_SESSION['password'] = $password;
                    $_SESSION['cadastrado'] = $cadastros->rowCount();
                    header('Location: '.INCLUDE_PATH.'painel/');
                    die();
                }else{
                    //senha e usuário não bate.
                    echo "<h2 class='error'>".'<i class="fa-solid fa-triangle-exclamation" style="color: #fff; margin-right: 10px"></i>'."Usuário ou senha estão incorretos.</p></h2>";
                }
            }

            if(isset($_POST['register'])){
                $user = $_POST['user'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $nome = $_POST['nome'];
                $_SESSION['preuser'] = $user;
                $_SESSION['preemail']= $email;
                $_SESSION['prepass'] = $password;
                $_SESSION['prenome'] = $nome;
                $img = '';
                $cargo = 0;
                $token = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
                $_SESSION['verifycode'] = $token;
                $confirmPassoword = $_POST['confirmpassword'];
                
                if(Usuario::emailCadastrado($email)){
                    //email não consta no banco de dados
                    if(Usuario::userCadastrado($user)){
                        //Usuário novo!
                        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                            //email validado!
                            if(preg_match('/^(?=.*\d)(?=.*[^\w\s]).{8,}$/',$password)){
                                //senha valida
                                if($confirmPassoword == $password){
                                    //senhas iguais
                                    //colocar codigo para confirmar
                                    if(Painel::verifyCode($email,$_SESSION['verifycode'],$nome)){
                                        $_SESSION['user'] = $user;
                                        $_SESSION['email'] = $email;
                                        $_SESSION['password'] = $password;
                                        $_SESSION['nome'] = $nome;
                                        $_SESSION['img'] = $img;
                                        $_SESSION['cargo'] = $cargo;
                                        $_SESSION['passcode'] = true;
                                        $_SESSION['email'] = $email;
                                        $_SESSION['password'] = $password; 
                                        Painel::alert("sucesso",'Codigo de confirmação enviado para '.$email);
                                    }else{
                                        Painel::alert("error",'Algo deu errado.');
                                    }
                                }else{
                                    //senhas não batem
                                    echo "<h2 class='error'>".'<i class="fa-solid fa-triangle-exclamation" style="color: #fff; margin-right: 10px"></i>'."As senhas não batem.</h2>";
                                }
                            }else{
                                echo "<h2 class='error'>".'<i class="fa-solid fa-triangle-exclamation" style="color: #fff; margin-right: 10px"></i>'."Formato de senha invalido!<p>*deve ter: no mínimo 8 caracteres, um número e um caractere especial.</p></h2>";
                            }
                        }else{
                            echo "<h2 class='error'>".'<i class="fa-solid fa-triangle-exclamation" style="color: #fff; margin-right: 10px"></i>'."Email invalido!</h2>";
                        }
                    }else{
                        echo "<h2 class='error'>".'<i class="fa-solid fa-triangle-exclamation" style="color: #fff; margin-right: 10px"></i>'."O usuário não está disponível.</h2>";
                    }
                }else{
                    echo "<h2 class='error'>".'<i class="fa-solid fa-triangle-exclamation" style="color: #fff; margin-right: 10px"></i>'."O email já está cadastrado.</h2>";
                }
                
            }
            


        ?>


        <div class="login-content">
            <div class="container">
                <a href="<?php echo INCLUDE_PATH;?>"><i class="fa-solid fa-caret-left" style="color: #000000;margin-right: 10px"></i>voltar</a>
                <h2 class='login'>Login</h2>
                <form method='post' class='form-login'>
                    <input type="email" name='email' placeholder="Email" required>
                    <input type="password" name='password' placeholder="Senha" required>
                    <div class="flex">
                        <div class='flex'>
                            <input type="checkbox" name='lembrar' checked>
                            <span style="white-space:nowrap; padding-left: 10px">Lembrar login</span>
                        </div><!--flex-->
                        <div class='flex'>
                            <input style="margin-left: 10px" class='showpass' type="checkbox" >
                            <span style="white-space:nowrap; padding-left: 10px;">Mostrar senha</span>
                        </div><!--flex-->
                    </div><!--flex-->
                   
                    <div class="flex">
                        <input type="submit" name='acao' value="Logar">
                        <p id='registrar'>registrar</p>
                    </div><!--flex-->
                </form><!--form-login-->   

                <form method='post' class='register-form'>
                    <input type="text" name='nome' placeholder="Nome completo" value='<?php if(isset($_SESSION['prenome'])){echo $_SESSION['prenome'];}  ?>' required>
                    <input type="email" name='email' placeholder="Email" value='<?php if(isset($_SESSION['preemail'])){echo $_SESSION['preemail'];}  ?>' required>
                    <input style='text-transform: lowercase;' type="text" name='user' placeholder="Usuário" value='<?php if(isset($_SESSION['preuser'])){echo $_SESSION['preuser'];}  ?>' required>
                    <input type="password" name='password' placeholder="Senha" value='<?php if(isset($_SESSION['prepass'])){echo $_SESSION['prepass'];}  ?>' required>
                    <input type="password" name='confirmpassword' placeholder="Digite novamente a senha" value='<?php if(isset($_SESSION['prepass'])){echo $_SESSION['prepass'];}  ?>' required>
                    <div class='flex'>
                        <input class='showpass' type="checkbox">
                        <span style="white-space:nowrap; padding-left: 10px">Mostrar senha</span>
                    </div>
                    <div class="flex">
                        <input type="submit" name='register' value="Registrar">
                        <p id='login'>Login</p>
                    </div>
                </form>

            </div><!--container-->
        </div><!--login-content-->

        <?php if(@$_SESSION['passcode'] == true){
            include('verify.php');
            die();
        }
        ?> 
    </div><!--center-->
</body>
</html>

