<?php
    if($_SESSION['cargo'] >= 2) {
    
    
    if(isset($_POST['acao'])){
        $sql = MySql::conectar()->prepare("INSERT INTO `tb_site.categorias` values(null,?,?,?,?)");

        $nome = $_POST['nome'];
        $categoria_ID = '0';
        $order_id = '0';

        if(!Painel::existeNaTabela('tb_site.categorias','nome = ?',$nome)){

            if($nome != ''){
                $slug = Painel::gerarSlug($nome);
                if($sql->execute(array($nome,$slug,$categoria_ID,$order_id))){
                    $categoria_ID = Painel::select('tb_site.categorias','nome = ?',array($nome));
                    $sql = MySql::conectar()->prepare("UPDATE `tb_site.categorias` SET categoria_id = ?, order_id = ? WHERE id = ?");
                    $sql->execute(array($categoria_ID['id'],$categoria_ID['id'],$categoria_ID['id']));
                    Painel::alert("sucesso","Cadastrado com sucesso!");
                }
            }else{
                Painel::alert("error","É preciso de um nome!");
            }
        }else{
            Painel::alert("error","Categoria ".$nome.' já existe.');
        }
    }else if(isset($_POST['editar'])){
        if(isset($_GET['id'])){
            $sql = MySql::conectar()->prepare("UPDATE `tb_site.categorias` SET nome = ? , slug = ? WHERE id = ? ");

            $nome = $_POST['nome'];
            $id = $_GET['id'];
            
            if($nome != ''){
                $slug = Painel::gerarSlug($nome);
                if($sql->execute(array($nome,$slug,$id))){
                    Painel::alert("sucesso","Editado com sucesso!");
                }
            }else{
                Painel::alert("error","É preciso de um novo nome!");
            }
        }else{
            Painel::alert("error","É preciso selecionar um ID.");
        }

    }else if(isset($_POST['deletar'])){
        $categoria_ID = Painel::select('tb_site.categorias','nome = ?',array($_POST['nome']))['categoria_id'];
        $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.categorias` WHERE nome = ? ");

        $nome = $_POST['nome'];
        
        if($nome != ''){
            if(Painel::existeNaTabela('tb_site.categorias','nome = ?',$nome)){
                if($sql->execute(array($nome))){
                    Painel::deleteAllImages('tb_site.noticias','categoria_id = ?',array($categoria_ID));
                    $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.noticias` WHERE categoria_id = ? ");
                    $sql->execute(array($categoria_ID));
                    Painel::alert("sucesso","Deletado com sucesso!");
                }
                Painel::alert("sucesso",$categoria_ID);
            }else{
                Painel::alert("error","Categoria ".$nome.' não existe.');
            }
        }else{
            Painel::alert("error","É preciso definir um nome!");
        }

    }else if(isset($_GET['delete']) && isset($_GET['excluir'])){
        $valor = $_GET['delete'];
        $categoria_ID = $_GET['excluir'];
        $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.categorias` WHERE id = ?");
        if($sql->execute(array($valor))){
            Painel::deleteAllImages('tb_site.noticias','categoria_id = ?',array($categoria_ID));
            $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.noticias` WHERE categoria_id = ? ");
            $sql->execute(array($categoria_ID));
            Painel::alert("sucesso","Categoria foi deletada com sucesso!");
        }else{
            Painel::alert("error","Algo deu errado.");
        }
    }else if(isset($_GET['order']) && isset($_GET['id']) ){
        Painel::orderItem('tb_site.categorias',$_GET['order'],$_GET['id']);
    }

?>
<div class="box-content " style='width: fit-content;'>
    <p style='margin-bottom: 20px'>Editar conteúdos: </p>
    <a style='background-color: #5a5add; box-shadow: 1px 3px 1px #fff' class='singlecat' href="<?php echo INCLUDE_PATH.'painel/categorias' ?>">Categorias</a>
    <a class='singlecat' href="<?php echo INCLUDE_PATH.'painel/noticias' ?>">Notícias</a>
</div>
<div class="flex">
    <div class="box-content w50 mr-2">
        <h2 class='title'>Criar Categoria: <i class="fa-solid fa-plus"></i></h2>
        <form method='POST' class='atualizar__form'>
            <div class="form-group">
                <label>Nome</label>
                <input name='nome' type="text" placeholder='Esportes...'>
            </div>
            <div class="form-group">
                <input type="submit" name='acao' Value='Cadastrar'>
            </div>
        </form>
    </div>

    <div class="box-content w50 ml-2">
    <h2 class='title'>Editar Categoria: <i class="fa-solid fa-plus"></i></h2>
        <form method='POST' class='atualizar__form'>
            <div class="form-group">
                <label>Novo nome: </label>
                <input name='nome' type="text" placeholder='Tecnologias...' value='<?php if(isset($_GET['id'])){ echo Painel::select('tb_site.categorias','id = ?',array($_GET['id']))['nome']; } ?>'>
            </div>
            <div class="form-group">
                <input type="submit" name='editar' Value='Editar'>
            </div>
        </form>
    </div>
</div>

<div class="flex">
    <div class="box-content w50S">
    <h2 class='title'>Excluir Categoria: <i class="fa-solid fa-plus"></i></h2>
        <form method='POST' class='atualizar__form'>
            <div class="form-group">
                <label>Nome</label>
                <input name='nome' type="text" placeholder='Esportes...'>
            </div>
            <div class="form-group">
                <input type="submit" name='deletar' Value='Excluir'>
            </div>
        </form>
    </div>
    </div>
</div>

<div class="box-content">
    <?php
        $start = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1 - 1;
        $porpagina = 5;

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` ORDER BY order_id LIMIT $start,$porpagina ");
        $sql->execute();
        $info = $sql->fetchAll();
        
        foreach ($info as $key => $value) {
            $qnt = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ?");
            $qnt->execute(array($value['categoria_id']));
            
    ?>
    <div class="table categoria-EDIT">
        <div class="flex" style='flex-direction: column'>
            <h2><?php echo $value['nome']; ?></h2>
            <p style='margin-left: 0'><?php echo $value['slug'] ?></p>
            <p style='margin-left: 0'>Quantidades de notícias: <?php echo $qnt->rowCount(); ?></p>
        </div>
        <div class="flex">
            <a class='order-item' href="<?php echo INCLUDE_PATH.'painel/categorias?order=up&id='.$value['id']; ?>"><i class="fa-solid fa-chevron-up"></i></a>
            <a class='order-item' href="<?php echo INCLUDE_PATH.'painel/categorias?order=down&id='.$value['id']; ?>"><i class="fa-solid fa-chevron-down"></i></a>
        </div>
        <div class="flex">
            <a style='margin-right: 10px' href='<?php echo INCLUDE_PATH.'painel/categorias?id='.$value['id'] ?>' class='editar-btn'><i class='fa-regular fa-pen-to-square'></i> Editar</a>
            <a style='margin-left: 10px' actionBtn='delete' href="<?php echo INCLUDE_PATH.'painel/categorias?delete='.$value['id'].'&excluir='.$value['categoria_id']; ?>"><i style='background-color: lightcoral; padding: 4px 6px; border-radius: 4px; color: #fff;' class='fa-solid fa-xmark'></i></a>
        </div>
    </div>
    <?php } 

        //Páginas
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias`");
        $sql->execute();
        $qnt = $sql->rowCount();
        $totalPaginas = ceil($qnt);

        echo "<div style='justify-content: center;align-items: center;' class='flex'>";

            for ($i=0; $i < $totalPaginas; $i +=5) { 
                $valor = ($i/5) + 1;

                if($i == $start){
                    echo '<a class="pages-val pagina-selected" href="'.INCLUDE_PATH.'painel/categorias?pagina='.$i.'">'.$valor.'</a>';
                }else{
                    echo '<a class="pages-val" href="'.INCLUDE_PATH.'painel/categorias?pagina='.$i.'">'.$valor.'</a>';
                }
            }

        echo "</div>";

    ?>
</div>

<script>
$(function(){
    $('.selected').html('<i class="fa-solid fa-file-pen"></i>');
});
</script>

<?php }else{
    Painel::alert("error","Você não tem permissão para está pagina");
} ?>