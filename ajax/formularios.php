<?php
    include('../config.php');
    $data = array();
    $assunto = "Um novo email foi cadastrado:"; //ASSUNTO DO EMAIL
    $corpo = '';             //CORPO DO EMAIL " PODE HTML"
    foreach ($_POST as $key => $value) { //loop para pegar todos os itens do form
        $corpo.=ucfirst($key).": ".$value;
        $corpo.="<hr>";
    }
    $info = array('assunto'=>$assunto,'corpo'=>$corpo);
    $mail = new Email('smtp.gmail.com','empresa@gmail.com','password','Cadastro realizado.');
    $mail->addAdress('recebercadastros@gmail.com','minhaempresa');
    $mail->formatarEmail($info);

    if($mail->enviarEmail()){
        $data['sucesso'] = true;
    }else{
        $data['error'] = true;
    }

    die(json_encode($data));


?><!--php-->
