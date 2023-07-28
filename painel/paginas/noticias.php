<?php
    if($_SESSION['cargo'] >= 2) {
        
    

    if(isset($_POST['acao'])){
        $title = $_POST['title'];
        $text = $_POST['text'];
        $categoria = $_POST['categoria_id'];
        $order_id = '0';
        $slug = Painel::gerarSlug($title);
        $data = date('d-m-Y');
        $imagem = $_FILES['imagem'];
        

        $sql = MySql::conectar()->prepare("INSERT INTO `tb_site.noticias` VALUES(null,?,?,?,?,?,?,?) ");
        
        if($title != '' && $text != ''){
            if($imagem['name'] != ''){
                if(Painel::imagemValida($imagem)['status']){
                    $imagem = Painel::uploadFile($imagem);

                    if($sql->execute(array($title,$text,$data,$slug,$imagem,$categoria,$order_id))){
                        $order_id = Painel::select('tb_site.noticias', 'titulo = ?',array($title));
                        Painel::attOrderId($order_id['id'],'tb_site.noticias','order_id = ?');
                        Painel::alert("sucesso","Notícia cadastrada com sucesso!");
                    }else{
                        Painel::alert("error","Algo deu errado.");
                    }
                }else{
                    Painel::alert("error",'Formato de imagem inválido.');
                }
            }else{
                Painel::alert("error",'É preciso selecionar uma imagem!');
            }
        }else{
            Painel::alert("error","Campos vazios não são permitidos!");
        }

    }else if(isset($_POST['editar'])){
        $title = $_POST['title'];
        $text = $_POST['text'];
        $id = @$_GET['id'];
        $slug = Painel::gerarSlug($title);
        $categoria = $_POST['categoria'];
        $imagem = $_FILES['imagem'];
        $imagemAtual = $_POST['imagem_atual'];

        if(isset($_GET['id'])){
            if($imagem['name'] != ''){
                if(Painel::imagemValida($imagem)['status']){

                    $categoriaAtual = Painel::select('tb_site.noticias','id = ?',array($id))['categoria_id'];

                    if($title != '' && $text != ''){
                        $imagem = Painel::uploadFile($imagem);
                        Painel::deleteFile($imagemAtual);

                        if($categoriaAtual == $categoria){
                            //catégoria é a mesma
                            $sql = MySql::conectar()->prepare("UPDATE `tb_site.noticias` SET titulo = ?, texto = ? , slug = ?, imagem = ? WHERE id = ? ");
                            if($sql->execute(array($title,$text,$slug,$imagem,$id))){
                                Painel::alert("sucesso","Notícia editada com sucesso!");
                            }else{
                                Painel::alert("error","Algo deu errado.");
                            }
                        }else{
                            //mudou a categoria
                            $sql = MySql::conectar()->prepare("UPDATE `tb_site.noticias` SET titulo = ?, texto = ? , slug = ? , categoria_id = ?, imagem = ? WHERE id = ? ");
                            if($sql->execute(array($title,$text,$slug,$categoria,$imagem,$id))){
                                Painel::alert("sucesso","Notícia editada com sucesso!");
                            }else{
                                Painel::alert("error","Algo deu errado.");
                            }
                        }
                        
                    }else{
                        Painel::alert("error","Campos vazios não são permitidos!");
                    }
                }else{
                    Painel::alert("error",'Formato de imagem inválida.');
                }
            }else{
                $categoriaAtual = Painel::select('tb_site.noticias','id = ?',array($id))['categoria_id'];

                if($title != '' && $text != ''){
                    if($categoriaAtual == $categoria){
                        //catégoria é a mesma
                        $sql = MySql::conectar()->prepare("UPDATE `tb_site.noticias` SET titulo = ?, texto = ? , slug = ? WHERE id = ? ");
                        if($sql->execute(array($title,$text,$slug,$id))){
                            Painel::alert("sucesso","Notícia editada com sucesso!");
                        }else{
                            Painel::alert("error","Algo deu errado.");
                        }
                    }else{
                        //mudou a categoria
                        $sql = MySql::conectar()->prepare("UPDATE `tb_site.noticias` SET titulo = ?, texto = ? , slug = ? , categoria_id = ? WHERE id = ? ");
                        if($sql->execute(array($title,$text,$slug,$categoria,$id))){
                            Painel::alert("sucesso","Notícia editada com sucesso!");
                        }else{
                            Painel::alert("error","Algo deu errado.");
                        }
                    }
                    
                }else{
                    Painel::alert("error","Campos vazios não são permitidos!");
                }
            }
        }else{
            Painel::alert("error","É preciso selecionar um id.");
        }
    }else if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $imagem = Painel::select('tb_site.noticias','id = ? ',array($id))['imagem'];
        $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.noticias` WHERE id = ?");
        if($sql->execute(array($id))){
            Painel::deleteFile($imagem);
            Painel::alert("sucesso","Notícia foi deletada com sucesso!");
        }else{
            Painel::alert("error","Algo deu errado.");
        }
    }else if(isset($_POST['deletar'])){
        $title = $_POST['title'];
        if($title != ''){
            if(Painel::existeNaTabela('tb_site.noticias','titulo = ?',$title)){
                $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.noticias` WHERE titulo = ? ");
                if($sql->execute(array($title))){
                    Painel::alert("sucesso","Notícia deletada com sucesso!");
                }else{
                    Painel::alert("error","Algo deu errado.");
                }
            }else{
                Painel::alert("error","Título não foi encotrado!");
            }
        }else{
            Painel::alert("error","É preciso definir um tiítulo.");
        }
    }

?>
<div class="box-content " style='width: fit-content;'>
    <p style='margin-bottom: 20px'>Editar conteúdos: </p>
    <a class='singlecat' href="<?php echo INCLUDE_PATH.'painel/categorias' ?>">Categorias</a>
    <a style='background-color: #5a5add; box-shadow: 1px 3px 1px #fff' class='singlecat' href="<?php echo INCLUDE_PATH.'painel/noticias' ?>">Notícias</a>
</div>
<div class="flex">
    <div class="box-content w50 mr-2">
        <h2 class='title'>Criar Notícia: <i class="fa-solid fa-plus"></i></h2>
        <form method='POST' class='atualizar__form' enctype="multipart/form-data">
            <div class="form-group">
                <label>Título</label>
                <input name='title' type="text">
            </div>
            <div class="form-group">
                <label>Texto</label>
                <input class='tinyMC' name='text' type="text">
            </div>
            <div class="form-group">
                <label>Categoria: </label>
                <select name="categoria_id">
                    <?php 
                        $categoria = Painel::selectAll('tb_site.categorias',null,null);
                        foreach ($categoria as $key => $value) {
                    ?>
                    
                    <option value='<?php echo $value['id'] ?>'><?php echo $value['nome'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label>Capa: </label>
                <input type="file" name='imagem'>
            </div>
            <div class="form-group">
                <input type="submit" name='acao' Value='Cadastrar'>
            </div>
            
        </form>
    </div>

    <div class="box-content w50 ml-2">
    <h2 class='title'>Editar Notícia: <i class="fa-solid fa-plus"></i></h2>
        <form method='POST' class='atualizar__form' enctype="multipart/form-data">
            <?php
                if(isset($_GET['id'])){
                    $sql = Painel::selectAll('tb_site.noticias','WHERE id = ?',array($_GET['id']));
                    foreach ($sql as $key => $value) {
                        $titulo = $value['titulo'];
                        $texto = $value['texto'];
                        $imagemName = $value['imagem'];
                        
                    }
                }
            ?>
            <div class="form-group">
                <label>Titulo</label>
                <input name='title' type="text" value='<?php if(isset($_GET['id'])){ echo $titulo; } ?>' placeholder='Novelas...'>
            </div>
            <div class="form-group">
                <label>Texto: </label>
                <textarea class='tinyMC' name='text' type="text"><?php 
                    if(isset($_GET['id'])){
                        echo @$texto;
                    } ?>
                    </textarea>
            </div>
            <div class="form-group">
                <label>Categoria: </label>
                <select name="categoria">
                    <?php 
                        $info = Painel::selectAll('tb_site.categorias',null,null);
                        foreach ($info as $key => $value) {  
                    ?>
                    <option value="<?php echo $value['categoria_id'] ?>"><?php echo $value['nome']; ?></option>
                    <?php }  ?>
                </select>
                <?php
                    if(isset($_GET['id'])){
                        
                        $categoria_id = Painel::select('tb_site.noticias',' id = ?',array($_GET['id']))['categoria_id'];
                        $valor = Painel::pegarCategoria('tb_site.categorias',$categoria_id);
                ?>
                <script>
                    $(function(){
                        var valor = <?php echo $categoria_id; ?>;
                        var el = $('select[name="categoria"]').find('option');
                        if($(el[0]).attr('value') != valor){

                            var opEl = $('select[name="categoria"]').find('option[value="'+  valor +'"]');
                            var op0 = el[0];
                            var valor0 = el[0].value;
                            var valorEl = $(opEl).val();
                            var op0Text = op0.text;

                            $(op0).text(opEl.text());
                            $(op0).val(valorEl);

                            opEl.text(op0Text);
                            opEl.val(valor0);
                        }
                    });
                </script>

                <?php } ?>
            </div>
            <div class="form-group">
                <label>Capa: </label>
                <input type="hidden" name='imagem_atual' value='<?php echo Painel::select('tb_site.noticias','id = ?',array($_GET['id']))['imagem'] ?>'>
                <input type="file" name='imagem'>
            </div>
            <div class="form-group">
                <input type="submit" name='editar' Value='Editar'>
            </div>
        </form>
    </div>
</div>

<div class="flex">
    <div class="box-content w50S">
    <h2 class='title'>Excluir Notícia: <i class="fa-solid fa-plus"></i></h2>
        <form method='POST' class='atualizar__form'>
            <div class="form-group">
                <label>Título</label>
                <input name='title' type="text" placeholder='Esportes...'>
            </div>
            <div class="form-group">
                <input type="submit" name='deletar' Value='Excluir'>
            </div>
        </form>
    </div>
    </div>
</div>

<?php //noticias cadastradas
$categoria = Painel::selectAll('tb_site.categorias',null,null);
foreach ($categoria as $key => $value) {
$slugTypeCategory = $value['slug'];

?>
<div class="box-content">
    <h2><?php  echo "Navegando em: ".$value['nome']; ?></h2>
    <?php
        $start = isset($_GET['pagina-categoria-'.$slugTypeCategory ]) ? $_GET['pagina-categoria-'.$slugTypeCategory] : 0;
        $porpagina = 5;

        $noticias = Painel::selectAll('tb_site.noticias',"WHERE categoria_id = ? ORDER BY id DESC LIMIT $start,$porpagina",array($value['categoria_id']));
        foreach ($noticias as $key => $value) {

    ?>
    <div class="table categoria-EDIT">
        <div class="flex" style='flex-direction: column'>
            <h2 class='noticiasTitle'><?php echo $value['data'].' - '.$value['titulo']; ?></h2>
            <img class='noticia-preview' src="<?php echo INCLUDE_PATH.'painel/uploads/'.$value['imagem']; ?>">
            <div style='margin-top: 10px;' class="flex">
                <a style='margin-right: 10px' href='<?php echo INCLUDE_PATH.'painel/noticias?id='.$value['id']; ?>' class='editar-btn'><i class='fa-regular fa-pen-to-square'></i> Editar</a>
                <a style='margin-left: 10px' actionBtn='delete' href='<?php echo INCLUDE_PATH.'painel/noticias?delete='.$value['id']; ?>'> <i style='background-color: lightcoral; padding: 4px 6px; border-radius: 4px; color: #fff;' class='fa-solid fa-xmark'></i> </a>
            </div>
        </div>

    </div>
    <?php }//fim das noticias 
        //páginas AQUI!
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? ");
        $sql->execute(array($value['categoria_id']));
        $qnt = $sql->rowCount();
        $totalPaginas = ceil($qnt);

            echo "<div style='justify-content: center;align-items: center;' class='flex'>";

                for ($i=0; $i < $totalPaginas; $i +=5) { 
                    $valor = ($i/5) + 1;

                    if($i == $start){
                        echo '<a class="pages-val pagina-selected" href="'.INCLUDE_PATH.'painel/noticias?pagina-categoria-'.$slugTypeCategory.'='.$i.'">'.$valor.'</a>';
                    }else{
                        echo '<a class="pages-val" href="'.INCLUDE_PATH.'painel/noticias?pagina-categoria-'.$slugTypeCategory.'='.$i.'">'.$valor.'</a>';
                    }
                }

            echo "</div>";
    ?>
</div>

<?php }//fim das categorias ?>

<script>
$(function(){
    $('.selected').html('<i class="fa-solid fa-file-lines"></i>')
});
</script>

<?php }else{
    Painel::alert("error","Você não tem permissão para está pagina");
} ?>