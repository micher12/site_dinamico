<?php 

    class Usuario{
        public static function atualizarUsuario($nome,$user,$senha,$img){
           $sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET nome = ?, user = ?, `password` = ?, img = ? WHERE email = ?");
           if($sql->execute(array($nome,$user,$senha,$img,$_SESSION['email']))){
            return true;
           }else{
            return false;
           }
        }

        public static function emailCadastrado($email){
            $sql = MySql::conectar()->prepare("SELECT email FROM `tb_admin.usuarios` WHERE email = ?");
            $sql->execute(array($email));
            if($sql->rowCount() > 0){
                //email ja cadastrado
                return false;
            }else{
                //tudo ok pode cadastrar
                return true;
            }
        }

        public static function userCadastrado($user){
            $sql = MySql::conectar()->prepare("SELECT user FROM `tb_admin.usuarios` WHERE user = ?");
            $sql->execute(array($user));
            if($sql->rowCount() > 0){
                //usuario já existe no banco de dados
                return false;
            }else{
                //tudo certo
                return true;
            }
        }

        public static function servicoCadastrado($title,$servico){
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.servicos` WHERE title = ? OR servicos = ?");
            $sql->execute(array($title,$servico));
            if($sql->rowCount() > 0){
                //já cadastrado
                return false;
            }else{
                //não foi cadastrado
                return true;
            }
        }

        public static function depoimentoCadastrado($nome,$depoimento){
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.depoimentos` WHERE nome = ? OR depoimento = ?");
            $sql->execute(array($nome,$depoimento));
            if($sql->rowCount() > 0){
                //já foi cadastrado
                return false;
            }else{
                //tudo certo!
                return true;
            }
        }

        public static function deletarDepoimento($nome){
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.depoimentos` WHERE nome = ?");
            $sql->execute(array($nome));
            if($sql->rowCount() > 0){
                $delete = MySql::conectar()->prepare("DELETE FROM `tb_site.depoimentos` WHERE nome = ?");
                if($delete->execute(array($nome))){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }

        

    }

?>