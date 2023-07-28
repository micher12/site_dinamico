<?php

    class Site {
        public static function updateUsuario(){
            if(isset($_SESSION['online'])){
                //sessão online foi iniciada
                $token = $_SESSION['online'];
                $horarioAtual = date('Y-m-d H:i:s');

                //checa se a mesma sessao foi retomada
                $check = MySql::conectar()->prepare("SELECT `id` FROM `tb_admin.online` WHERE token = ? ");
                $check->execute(array($_SESSION['online']));

                if($check->rowCount() == 1){
                    //existe um sessão aberta
                    $sql = MySql::conectar()->prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ? ");
                    $sql->execute(array($horarioAtual,$token));
                }else{
                    //criar nova sessão
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $token = $_SESSION['online'];
                    $horarioAtual = date('Y-m-d H:i:s');
                    $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?)");
                    $sql->execute(array($ip,$horarioAtual,$token));
                }

            }else{
                //iniciar sessão online
                $_SESSION['online'] = uniqid();
                $ip = $_SERVER['REMOTE_ADDR'];
                $token = $_SESSION['online'];
                $horarioAtual = date('Y-m-d H:i:s');
                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES (null,?,?,?)");
                $sql->execute(array($ip,$horarioAtual,$token));
            }
        }

        public static function contador(){
            if(!isset($_COOKIE['visita'])){
                //total de visita na ultima semana
                setcookie('visita','true',time() + (60*60 * 24 * 7) ); //uma semana
                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.visitas` VALUES(null,?,?)");
                $sql->execute(array($_SERVER['REMOTE_ADDR'],date('Y-m-d')));
            }
        }
    }

?>