<?php
    $usuariosOnline = Painel::listarUsuariosOnline();

    $visitasTotais = MySql::conectar()->prepare("SELECT * FROM  `tb_admin.visitas`");
    $visitasTotais->execute();
    $visitasTotais = $visitasTotais->rowCount();
    $_SESSION['visitaTotal'] = $visitasTotais;

    $visitasHoje = MySql::conectar()->prepare("SELECT * FROM  `tb_admin.visitas` WHERE `dia` = ?");
    $visitasHoje->execute(array(date('Y-m-d')));
    $visitasHoje = $visitasHoje->rowCount();

    if($_SESSION['cargo'] == 2){

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
        $sql->execute();
        $siteConfig = $sql->fetch();
    
        if(isset($_POST['atualizar-titulo'])){
            $titulo = $_POST['valor'];
            $att = MySql::conectar()->prepare("UPDATE `tb_site.config` SET titulo = ?");
            if($att->execute(array($titulo))){
                Painel::alert("sucesso","Atualizado para: ".$titulo);
                
            }else{
                Painel::alert("error","Algo deu errado.");
            }
            
        }else if(isset($_POST['atualizar-title'])){
            $titulo = $_POST['valor'];
            $att = MySql::conectar()->prepare("UPDATE `tb_site.config` SET title_web = ?");
            if($att->execute(array($titulo))){
                Painel::alert("sucesso","Atualizado para: ".$titulo);
            }else{
                Painel::alert("error","Algo deu errado.");
            }
        }else if(isset($_POST['atualizar-titulo-sobre'])){
            $titulo = $_POST['valor'];
            $att = MySql::conectar()->prepare("UPDATE `tb_site.config` SET title_about = ?");
            if($att->execute(array($titulo))){
                Painel::alert("sucesso","Atualizado para: ".$titulo);
            }else{
                Painel::alert("error","Algo deu errado.");
            }
        }else if(isset($_POST['atualizar-text1-sobre'])){
            $titulo = $_POST['valor'];
            $att = MySql::conectar()->prepare("UPDATE `tb_site.config` SET `text1-sobre` = ?");
            if($att->execute(array($titulo))){
                Painel::alert("sucesso","Atualizado com sucesso!");
            }else{
                Painel::alert("error","Algo deu errado.");
            }
        }else if(isset($_POST['atualizar-text2-sobre'])){
            $titulo = $_POST['valor'];
            $att = MySql::conectar()->prepare("UPDATE `tb_site.config` SET `text2-sobre` = ?");
            if($att->execute(array($titulo))){
                Painel::alert("sucesso","Atualizado com sucesso!");
            }else{
                Painel::alert("error","Algo deu errado.");
            }
        }

?>
<!-- ADMIN -->
<div class="box-content " style='width: fit-content;'>
    <p style='margin-bottom: 20px'>Editar conteúdos: </p>
    <a class='singlecat' href="<?php echo INCLUDE_PATH.'painel/categorias' ?>">Categorias</a>
    <a class='singlecat' href="<?php echo INCLUDE_PATH.'painel/noticias' ?>">Notícias</a>
</div>
<h2 class='titulo-session mrt-30'>Informações do Site: </h2>

<div class="box-content">
    <div class='flex' style='flex-direction: column;'>
        <form method='POST' style='justify-content: space-between' class="flex config-site">
            <div style='align-items: center;' class='flex w50'><label style='padding-right: 10px'>Titulo do site: </label><input type="text" name='valor' placeholder='titulo:' value='<?php echo $siteConfig['titulo']; ?>'></div>
            <input class='poppins ftw500' type="submit" name='atualizar-titulo' value='Atualizar'>
        </form>
        <form method='POST' style='justify-content: space-between' class="flex config-site">
            <div style='align-items: center;' class='flex w50'><label style='padding-right: 10px'>Titulo do header: </label><input type="text" name='valor' placeholder='titulo:' value='<?php echo $siteConfig['title_web']; ?>'></div>
            <input class='poppins ftw500' type="submit" name='atualizar-title' value='Atualizar'>
        </form>
        <form method='POST' style='justify-content: space-between' class="flex config-site">
            <div style='align-items: center;' class='flex w50'><label style='padding-right: 10px'>Titulo do Sobre: </label><input type="text" name='valor' placeholder='titulo:' value='<?php echo $siteConfig['title_about']; ?>'></div>
            <input class='poppins ftw500' type="submit" name='atualizar-titulo-sobre' value='Atualizar'>
        </form>
        <form method='POST' style='justify-content: space-between; align-items: center' class="flex config-site">
            <div style='align-items: center;' class='flex w50'><label>Texto 1 do Sobre: </label><textarea class='tinyMC'  name='valor' ><?php echo $siteConfig['text1-sobre'] ?></textarea></div>
            <input class='poppins ftw500' type="submit" name='atualizar-text1-sobre' value='Atualizar'>
        </form>
        <form method='POST' style='justify-content: space-between; align-items: center' class="flex config-site">
            <div style='align-items: center;' class='flex w50'><label >Texto 2 do Sobre: </label><textarea class='tinyMC' name='valor' ><?php echo $siteConfig['text2-sobre'] ?></textarea></div>
            <input class='poppins ftw500' type="submit" name='atualizar-text2-sobre' value='Atualizar'>
        </form>
        
    </div>
</div>

<?php } //FIM ADMIN ?>

<div class="box-content">
    <h3>Painel de Controle:</h3>
    <div class="flex-main">
        <div class="content">
            <h2>Usuários Online: <p><?php echo count($usuariosOnline); ?></p></h2>
        </div><!--content-->
        <div class="content">
            <h2>Total de Visitas: <p><?php echo $visitasTotais; ?></p></h2>
        </div><!--content-->
        <div class="content">
            <h2>Visitas Hoje: <p><?php echo $visitasHoje; ?></p></h2>
        </div><!--content-->
    </div><!--flex-main-->
    
</div><!--box-content-->

<div class="box-content">
    <h2><i class="fa-solid fa-users-line" style='margin-right: 10px'></i> Usuários Online: <a class='hideList' style="cursor: pointer"><i class="fa-solid fa-chevron-up"></i></a></h2>

    <div class="content__table">
        
        <?php
            foreach ($usuariosOnline as $key => $value) {
        
        ?>
        
        <div class="table aberta">
            <div class="leftTable">
                <p><b>IP: </b></p>
                <p><?php echo $value['ip']; ?></p>
            </div><!--leftTable-->
            <div class="rightTable">
                <p><b>Última ação: </b></p>
                <p><?php echo date('d/m/Y H:i:s',strtotime($value['ultima_acao'])); ?></p>
            </div><!--rightTable-->
        </div><!--table-->

        <?php } ?>
    </div>
    
</div><!--box-content-->

