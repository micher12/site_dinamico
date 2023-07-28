<?php

    class Painel{
        public static function logado(){
            return isset($_SESSION['login']) ? true : false;
        }
        public static function loggout(){
            setcookie('lembrar','true',time() - 1, '/');
            session_destroy();
            header('Location: '.INCLUDE_PATH  .'painel/' );
        }

        public static function gerarSlug($str){
            $str = mb_strtolower($str);
			$str = preg_replace('/(â|á|ã)/', 'a', $str);
			$str = preg_replace('/(ê|é)/', 'e', $str);
			$str = preg_replace('/(í|Í)/', 'i', $str);
			$str = preg_replace('/(ú)/', 'u', $str);
			$str = preg_replace('/(ó|ô|õ|Ô)/', 'o',$str);
			$str = preg_replace('/(_|\/|!|\?|#)/', '',$str);
			$str = preg_replace('/( )/', '-',$str);
			$str = preg_replace('/ç/','c',$str);
			$str = preg_replace('/(-[-]{1,})/','-',$str);
			$str = preg_replace('/(,)/','-',$str);
			$str=strtolower($str);
			return $str;
        }

        public static function retomarHeader(){
            $url = explode('/',@$_GET['url']);
            if(file_exists('paginas/'.$url[0].'.php')){
                //existe pagina de acordo com a url
                return false;
            }else{
                //não existe estamos no index.
                return true;
            }
        }

        public static function renomearTitleUrl($title){
            $arr = [
                'files' => 'Arquivos',
                'config' => 'Configuração',
                'categorias'=> 'Categorias',
                'noticias'=>"Notícias",
            ];

            return $arr[$title];
        }

        public static function pegarCategoria($table,$categoria_id){
            $valor = Painel::select($table,'categoria_id = ?',array($categoria_id));
            return $valor['nome'];
        }

        public static function returnCategoriaIdSlug($table,$slug){
            $valor = Painel::select($table,'slug = ?',array($slug));
            return $valor['categoria_id'];
        }

        public static function limitText($texto){
            // Encontra a posição do segundo ponto
            $posicaoSegundoPonto = strpos($texto, '.', strpos($texto, '.') + 1);

            // Extrai o texto até a posição do segundo ponto
            $textoLimitado = substr($texto, 0, $posicaoSegundoPonto);

            // Adiciona reticências ao texto limitado
            $textoLimitado .= '...';

            return $textoLimitado;
        }

        public static function carregarPagina(){
            if(isset($_GET['url'])){
                //se tiver
                $url = explode('/',$_GET['url']);
                if(file_exists('paginas/'.$url[0].'.php')){
                    //se existir arquivo
                    include('paginas/'.$url[0].'.php');
                }else{
                    //caso contrario volte para home
                    header("Location: ".INCLUDE_PATH.'painel/');
                }
            }else{
                //se não tiver url
                include('paginas/home.php');
            }
        }

        public static function pegarCargo($cargo){
            $arr = [
                '0' => 'Normal',
                '1' => 'Moderador',
                '2' => 'Administrador',
            ];

            return $arr[$cargo];
        }

        public static function listarUsuariosOnline(){
            self::limparUsuariosOnline();
            $sql = MySql::conectar()->prepare("SELECT * FROM  `tb_admin.online`");
            $sql->execute();
            return $sql->fetchAll();
        }

        public static function limparUsuariosOnline(){
            $date = date('Y-m-d H:i:s');
            $sql = MySql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE  ultima_acao < '$date' - INTERVAL 1 MINUTE ");
        }

        public static function alert($tipo,$mensagem){
            if($tipo == 'sucesso'){
                //sucesso!
                echo "<div class='sucessoAlert'>".$mensagem.' <i class="fa-solid fa-check" style="color: #ffffff;"></i></div>';
            }else if($tipo == 'error' ){
                //error
                echo "<div class='errorAlert'> <i class='fa-solid fa-triangle-exclamation' style='color: #ffffff;margin-right: 10px; font-size: 18px'></i>".$mensagem.'</div>';
            }else if($tipo == 'alert'){
                echo "<div class='alert'>".'<i class="fa-solid fa-triangle-exclamation" style="color: #ffffff;"></i> '.$mensagem.'</div>';
            }
        }

        public static function imagemValida($img){
            if($img['type'] == 'image/jpg' || 
            $img['type'] == 'image/jpeg' ||
            $img['type'] == 'image/png'){

                //tirar espaço no nome da img
                $nomeimg = str_replace(' ','_',$img['name']);   

                $tamanho = intVal($img['size']/1024);
                if($tamanho < 2000){
                    return array(
                        'status' => true,
                        'nome' => $nomeimg,
                    );
                }else{
                    return array(
                        'status' => false,
                        'nome' => $nomeimg,
                    );
                }
            }else{
                return array(
                    'status' => false,
                    'nome' => $nomeimg,
                );
            }
        }

        public static function uploadFile($file){
            $formatarArquivo = explode('.',$file['name']);
            $imagemNome = uniqid().'.'.$formatarArquivo[count($formatarArquivo) - 1];
            if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploads/'.$imagemNome)){

                return $imagemNome;
            }else{
                return false;
            }
        }

        public static function deleteFile($file){
            @unlink(BASE_DIR_PAINEL.'/uploads/'.$file);
        }

        public static function verifyCode($emailcadastrado,$token,$nome){
            $assunto = "Codigo de confirmação"; //ASSUNTO DO EMAIL
            $corpo = '<h2>Olá '.$nome.'</h2><br><p>Uma conta foi registra no seu email: '.$emailcadastrado.'</p> <br>Codigo de validação: <b><h2>'.$token.'</h2></b>';             //CORPO DO EMAIL " PODE HTML"
            $info = array('assunto'=> $assunto, 'corpo'=>$corpo);
            $mail = new Email('smtp.gmail.com','michelasm3@gmail.com','xcadtnrmbiioeenl','Confirmação de email.');
            $mail->addAdress($emailcadastrado,$nome);
            $mail->formatarEmail($info);
            if($mail->enviarEmail()){
                return true;
            }else{
                return false;
            }
            
        }

        public static function pegarSenha($email){
            $sql = MySql::conectar()->prepare("SELECT `password` FROM `tb_admin.usuarios` WHERE email = ?");
            if($sql->execute(array($email))){
                $info = $sql->fetch();
                return $info['password'];
            }else{
                return false;
            }
        }

        public static function pegarNome($email){
            $sql = MySql::conectar()->prepare("SELECT nome FROM `tb_admin.usuarios` WHERE email = ?");
            if($sql->execute(array($email))){
                $info = $sql->fetch();
                return $info['nome'];
            }else{
                return false;
            }
        }

        public static function pegarUsuario($email){
            $sql = MySql::conectar()->prepare("SELECT user FROM `tb_admin.usuarios` WHERE email = ?");
            if($sql->execute(array($email))){
                $info = $sql->fetch();
                return $info['user'];
            }else{
                return false;
            }
        }

        public static function titleExiste($title){
            $sql = MySql::conectar()->prepare("SELECT title FROM `tb_site.servicos` WHERE title = ?");
            $sql->execute(array($title));
            if($sql->rowCount() > 0){
                //existe
                return true;
            }else{
                //não existe
                return false;
            }
            
        }

        public static function existeNaTabela($table,$info,$valor){
            $sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $info");
            $sql->execute(array($valor));
            if($sql->rowCount() > 0){
                //existe
                return true;
            }else{
                //não existe
                return false;
            }
        }

        public static function qntCadastrado($table,$valor){
            $sql = MySql::conectar()->prepare("SELECT * FROM `$table`");
            $sql->execute();
            $sql->fetchAll();
            $valor = $sql->rowCount();
            return $valor;
            
        }

        public static function changeDataFormate($data){
            $valor = str_replace('-','/',$data);
            return $valor;
        }

        public static function deleteAllImages($table,$quando,$execute){
            $sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $quando ");
            $sql->execute($execute);
            $info = $sql->fetchAll();
            foreach ($info as $key => $value) {
                Painel::deleteFile($value['imagem']);
            }
        }

        public static function selectAll($table,$LIMIT,$execute){
            $sql = MySql::conectar()->prepare("SELECT * FROM `$table` $LIMIT");
            $sql->execute($execute);
            return $sql->fetchAll();
        }

        public static function attOrderId($id,$table,$valor){
            $MySql = MySql::conectar()->prepare("UPDATE `$table` SET $valor WHERE id = ? ");
            if($MySql->execute((array($id,$id)))){
                return true;
            }else{
                return false;
            }
        }

        public static function select($table,$value,$arr){
            $sql = MySql::conectar()->prepare("SELECT * FROM `$table` WHERE $value ");
            $sql->execute($arr);
            return $sql->fetch();
        }

        public static function orderItem($table,$order,$id){
            if($order == 'up'){
                $infoItemAtual = Painel::select($table,'id = ?',array($id));
                $order_id = $infoItemAtual['order_id'];

                $itemAcima = Mysql::conectar()->prepare("SELECT * FROM `$table` WHERE order_id < ? ORDER BY order_id DESC LIMIT 1");
                $itemAcima->execute(array($order_id));
                if($itemAcima->rowCount() == 0)
                    return;

                $itemAcima = $itemAcima->fetch();
                $update = MySql::conectar()->prepare("UPDATE `$table` SET order_id = ? WHERE id = ?");
                $update->execute(array($itemAcima['order_id'],$infoItemAtual['id']));
                $update->execute(array($infoItemAtual['order_id'],$itemAcima['id']));

            }else if($order == 'down'){

                $infoItemAtual = Painel::select($table,'id = ?',array($id));
                $order_id = $infoItemAtual['order_id'];

                $itemAcima = Mysql::conectar()->prepare("SELECT * FROM `$table` WHERE order_id > ? ORDER BY order_id ASC LIMIT 1");
                $itemAcima->execute(array($order_id));
                if($itemAcima->rowCount() == 0)
                    return;

                $itemAcima = $itemAcima->fetch();
                $update = MySql::conectar()->prepare("UPDATE `$table` SET order_id = ? WHERE id = ?");
                $update->execute(array($itemAcima['order_id'],$infoItemAtual['id']));
                $update->execute(array($infoItemAtual['order_id'],$itemAcima['id']));
            }
        }

    }

?>