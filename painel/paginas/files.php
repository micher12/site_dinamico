
<?php
    if($_SESSION['cargo'] >= 2){
    
    //deletar usuarios
    if(isset($_GET['excluir'])){
        $idExcluir = intval($_GET['excluir']);
        $sql = MySql::conectar()->prepare("DELETE FROM `tb_admin.usuarios` WHERE id = ?");
        if($sql->execute(array($idExcluir))){
            Header("Location: ".INCLUDE_PATH."/painel/files");
        }else{
            Painel::alert("error","Algo deu errado!");
        }
    }

    //deletar depoimento
    if(isset($_GET['deldepoimento'])){
        $idExcluir = intval($_GET['deldepoimento']);
        $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.depoimentos` WHERE id = ?");
        if($sql->execute(array($idExcluir))){
            Header("Location: ".INCLUDE_PATH."/painel/files");
        }else{
            Painel::alert("error","Algo deu errado!");
        }
    }

    //deletar servico
    if(isset($_GET['delservicoid'])){
        $idExcluir = intval($_GET['delservicoid']);
        $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.servicos` WHERE id = ?");
        if($sql->execute(array($idExcluir))){
            Header("Location: ".INCLUDE_PATH."/painel/files");
        }else{
            Painel::alert("error","Algo deu errado!");
        }
    }

    //order up/down
    if(isset($_GET['order']) && isset($_GET['id'])){
        Painel::orderItem('tb_site.depoimentos',$_GET['order'],$_GET['id']);
    }else if(isset($_GET['orderservice']) && isset($_GET['id'])){
        Painel::orderItem('tb_site.servicos',$_GET['orderservice'],$_GET['id']);
    }else if(isset($_GET['orderslide']) && isset($_GET['id'])){
        Painel::orderItem('tb_site.slides',$_GET['orderslide'],$_GET['id']);
    }

    //deletar slide
    if(isset($_GET['delslide'])){
        $id = $_GET['delslide'];
        $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.slides` WHERE id = ?");
        if($valor = Painel::select('tb_site.slides',"id = ?",array($id))){
            Painel::deleteFile($valor['imagem']);
            if($sql->execute(array($id))){     
                Painel::alert("sucesso","Slider ID:".$id.' foi deletado com sucesso!');
            }else{
                Painel::alert("error","Algo deu errado!");
            }
        }else{
            Painel::alert("error","Error ao conectar-se.");
        }
    }

?>


<div class="box-content">
    <!--USUARIOS CADASTRADOS-->
    <h2 class='title'>Usuários Cadastrados: <a class='hideList' style="cursor: pointer"><i class="fa-solid fa-chevron-down"></i></a> <span class='qntValues'><?php echo $valor = Painel::qntCadastrado('tb_admin.usuarios',''); ?></span></h2>
    <?php
        $inicio = isset($_GET['usuarios']) ? (int)$_GET['usuarios'] : 1 - 1;
        $perpagina = 5;
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` ORDER BY `id` DESC LIMIT $inicio,$perpagina");
        $sql->execute();

        $info = $sql->fetchAll();
        foreach ($info as $key => $value) {
            echo "<div class='table userstable'>"."<div style='align-items: center;' class='flex'><h2>".$value["user"]."</h2>"."<p style='margin-top: 0'>".$value['email']."</p>".'</div> <a actionBtn="delete" href="'.INCLUDE_PATH.'painel/files?excluir='.$value['id'].'" id="deleteUSER"> <i style="background-color: lightcoral; padding: 4px 6px; border-radius: 4px; color: #fff;" class="fa-solid fa-xmark"></i></a></div>';
        }

        //páginas
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.usuarios` ");
        $sql->execute();
        $qnt = $sql->rowCount();
        $totalPaginas = ceil($qnt);
        echo "<div style='justify-content: center;align-items: center;' class='flex'>";

            for ($i=0; $i < $totalPaginas; $i+= 5) { 
                $valor = ($i / 5 )+1;

                if($i == $inicio){
                    echo '<a class="pages-val pagina-selected" href="'.INCLUDE_PATH.'painel/files?usuarios='.$i.'">'.$valor.'</a>';
                }else{
                    echo '<a class="pages-val" href="'.INCLUDE_PATH.'painel/files?usuarios='.$i.'">'.$valor.'</a>';
                }
            }

        echo "</div>";
    ?>
</div>

<?php }  //fim do cargo 2
    if($_SESSION['cargo'] > 1){
?>
<!--DEPOIMENTOS CADASTRADOS-->
<div class="box-content" style="justify-content: center; display: flex; flex-direction: column;">
    <h2 class='title'>Depoimentos Cadastrados: <a class='hideList' style="cursor: pointer"><i class="fa-solid fa-chevron-down"></i></a> <span class='qntValues'><?php echo $valor = Painel::qntCadastrado('tb_site.depoimentos', ''); ?></span></h2>
    <?php
        $start = isset($_GET['depoimento']) ? (int)$_GET['depoimento'] : 1 - 1;
        $porpagina = 5;
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.depoimentos` ORDER BY order_id LIMIT $start,$porpagina ");
        

        $sql->execute();
        $info = $sql->fetchAll();
        foreach ($info as $key => $value) {
    ?>
    <div class="table">
        <p style='margin-left: 0;' class='w50 p10 montserrat ftw500 mr-2 ln-4'><?php echo $value['depoimento']; ?>  <br> <b><?php echo $value['nome']; ?></b></p>

        <a href='<?php echo INCLUDE_PATH.'painel/config?id='.$value['id']; ?>' class='editar-btn'><i class='fa-regular fa-pen-to-square'></i> Editar</a>

        <div class="flex" style='flex-direction: row;'>
            <a class='order-item' href="<?php echo INCLUDE_PATH.'painel/files?order=up&id='.$value['id']; ?>"><i class="fa-solid fa-chevron-up"></i></a>
            <a class='order-item' href="<?php echo INCLUDE_PATH.'painel/files?order=down&id='.$value['id']; ?>"><i class="fa-solid fa-chevron-down"></i></a>
        </div><!--flex-->

        <a actionBtn='delete' href='<?php echo INCLUDE_PATH.'painel/files?deldepoimento='.$value['id']; ?>' class='ml-2'> <i style='background-color: lightcoral; padding: 4px 6px; border-radius: 4px; color: #fff;' class='fa-solid fa-xmark'></i> </a>
        
    </div>

    <?php } ?>

    <?php
    //páginas
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.depoimentos` ");
    $sql->execute();
    $qnt = $sql->rowCount();
    $totalPaginas = ceil($qnt);

        echo "<div style='justify-content: center;align-items: center;' class='flex'>";

            for ($i=0; $i < $totalPaginas; $i +=5) { 
                $valor = ($i/5) + 1;

                if($i == $start){
                    echo '<a class="pages-val pagina-selected" href="'.INCLUDE_PATH.'painel/files?depoimento='.$i.'">'.$valor.'</a>';
                }else{
                    echo '<a class="pages-val" href="'.INCLUDE_PATH.'painel/files?depoimento='.$i.'">'.$valor.'</a>';
                }
            }

        echo "</div>";
    ?>
</div><!--box-content-->

<div class="box-content">
    <!--SESSÃO SERVICOS-->
    <h2 class='title'>Serviços cadastrados: <a class='hideList' style="cursor: pointer"><i class="fa-solid fa-chevron-down"></i></a> <span class='qntValues'><?php echo $valor = Painel::qntCadastrado('tb_site.servicos', ''); ?></span></h2>

    <?php
        $start = isset($_GET['servico']) ? (int)$_GET['servico'] : 1 - 1;
        $porpagina = 5;

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.servicos` ORDER BY order_id LIMIT $start,$porpagina");
        $sql->execute();
        $info = $sql->fetchAll();
        foreach ($info as $key => $value) {
    ?>
    <div class="table">
        <p class='w50'><b><?php echo $value['title']; ?></b><br> <?php echo $value['servicos']; ?></p>

        <a href='<?php echo INCLUDE_PATH.'painel/config?servicoid='.$value['id'] ?>' class='editar-btn'><i class='fa-regular fa-pen-to-square'></i> Editar</a>

        <div class="flex" style='flex-direction: row;'>
            <a class='order-item' href="<?php echo INCLUDE_PATH.'painel/files?orderservice=up&id='.$value['id']; ?>"><i class="fa-solid fa-chevron-up"></i></a>
            <a class='order-item' href="<?php echo INCLUDE_PATH.'painel/files?orderservice=down&id='.$value['id']; ?>"><i class="fa-solid fa-chevron-down"></i></a>
        </div><!--flex-->

        <a actionBtn='delete' href="<?php echo INCLUDE_PATH.'painel/files?delservicoid='.$value['id']; ?>"><i style='background-color: lightcoral; padding: 4px 6px; border-radius: 4px; color: #fff;' class='fa-solid fa-xmark'></i></a>
    </div>

    <?php } 

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.servicos` ");
        $sql->execute();
        $qnt = $sql->rowCount();
        $totalPaginas = ceil($qnt);

        echo "<div style='justify-content: center;align-items: center;' class='flex'>";

            for ($i=0; $i < $totalPaginas; $i +=5) { 
                $valor = ($i/5) + 1;

                if($i == $start){
                    echo '<a class="pages-val pagina-selected" href="'.INCLUDE_PATH.'painel/files?servico='.$i.'">'.$valor.'</a>';
                }else{
                    echo '<a class="pages-val" href="'.INCLUDE_PATH.'painel/files?servico='.$i.'">'.$valor.'</a>';
                }
            }

        echo "</div>";
    ?>
</div>
<!-- SESSÃO SLIDES -->
<div class="box-content">
    <h2 class='title'>Slides cadastrados: <a class='hideList' style="cursor: pointer"><i class="fa-solid fa-chevron-down"></i></a> <span class='qntValues'><?php echo $valor = Painel::qntCadastrado('tb_site.slides',''); ?></span></h2>
    
    <?php 
        $start = isset($_GET['slides']) ? $_GET['slides'] : 1 - 1;
        $porpagina = 3;
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.slides` ORDER BY order_id LIMIT $start,$porpagina ");
        $sql->execute();
        $info = $sql->fetchAll();
        foreach ($info as $key => $value){
    ?>
    <div class="table slidertable">
        <div class='w50'>
            <h2><?php echo $value['nome']; ?></h2>
            <a class='minPopup' href="<?php echo INCLUDE_PATH.'painel/uploads/'.$value['imagem']; ?>"><img style='height: 100px; border-radius: 8px;' src="<?php echo INCLUDE_PATH.'painel/uploads/'.$value['imagem']; ?>"></a>
            
        </div>

        <a href='<?php echo INCLUDE_PATH.'painel/config?slideid='.$value['id'] ?>' class='editar-btn'><i class='fa-regular fa-pen-to-square'></i> Editar</a>

        <div class="flex" style='flex-direction: row;'>
            <a class='order-item' href="<?php echo INCLUDE_PATH.'painel/files?orderslide=up&id='.$value['id']; ?>"><i class="fa-solid fa-chevron-up"></i></a>
            <a class='order-item' href="<?php echo INCLUDE_PATH.'painel/files?orderslide=down&id='.$value['id']; ?>"><i class="fa-solid fa-chevron-down"></i></a>
        </div><!--flex-->

        <a actionBtn='delete' href="<?php echo INCLUDE_PATH.'painel/files?delslide='.$value['id']; ?>"><i style='background-color: lightcoral; padding: 4px 6px; border-radius: 4px; color: #fff;' class='fa-solid fa-xmark'></i></a>

    </div>

    <?php } 
        //páginas
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.slides` ");
        $sql->execute();
        $qnt = $sql->rowCount();
        $totalPaginas = ceil($qnt);

            echo "<div style='justify-content: center;align-items: center;' class='flex'>";

                for ($i=0; $i < $totalPaginas; $i +=3) { 
                    $valor = ($i/3) + 1;

                    if($i == $start){
                        echo '<a class="pages-val pagina-selected" href="'.INCLUDE_PATH.'painel/files?slides='.$i.'">'.$valor.'</a>';
                    }else{
                        echo '<a class="pages-val" href="'.INCLUDE_PATH.'painel/files?slides='.$i.'">'.$valor.'</a>';
                    }
                }

            echo "</div>";
    ?>
</div><!--box-content-->

<?php }//fim do cargo 1 -- INICIO CARGO NORMAL NÃO COLOCAR NADA!
    if($_SESSION['cargo'] == 0){
        echo "<div style='margin-top: 20px;' class='error'><h2>Você não tem permissão para está página</h2></div>";
    }
?>

<script>
$(function(){

changeSelected()
function changeSelected(){
    var icons = $('.menu nav a');
    icons.removeClass('selected');
    $('.menu nav li:nth-of-type(3) a').addClass("selected");
}
});
</script>