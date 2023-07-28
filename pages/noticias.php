<?php 
    $url = explode('/',$_GET['url']);
    if(!isset($url[2])){

?>
<section class='newsheader' >
    <div class="container">
        <p class='text-center newsIcons'><i class="fa-regular fa-bell"></i></p>
        <h2 class='poppins text-center newsTittle'>Acompanhe as últimas <b>notícias do portal!</b></h2>
    </div>
</section>

<section class='newsContent'>
    <div class="newsMenu">
        <div class="singleNews">
            <form method='POST' class='newsForm'>
                <h3 class='title'>Realizar Busca <i style='padding-left: 10px;' class="fa-solid fa-magnifying-glass"></i></h3>
                <input class='montserrat ftw500' name='valor' type="text">
                <input class='poppins' type="submit" name='search' Value='Buscar' onclick='buscar()' >
            </form>
        </div><!--singleNews-->
        <div class="singleNews">
            <form method='GET' id='categoriaFORM' class='newsForm'>
                <h3 class='title'>Selecionar uma categoria <i style='padding-left: 10px;' class="fa-solid fa-list"></i></h3>
                <select class='montserrat ftw500' type="text" name='categorias' onchange='submitCategoria()'>
                    <?php if(isset($_GET['categorias']) && $_GET['categorias'] != 'todas'){ 
                        $slug = $_GET['categorias'];
                       
                        //se for setado a url categoria
                        
                        $sql = MySql::conectar()->prepare("SELECT nome FROM `tb_site.categorias` WHERE slug = ?");
                        $sql->execute(array($slug));
                        $valor = $sql->fetch();
                        echo "<option value=".$slug.">".$valor['nome']."</option>";
                        $categoria = Painel::selectAll('tb_site.categorias','WHERE slug != ?',array($slug));
                        foreach ($categoria as $key => $value) {
                               
                        
                    ?>       
                        
                        <option value="<?php echo $value['slug'] ?>"><?php echo $value['nome']; ?></option>
                        
                    <?php }//foreach ?>
                            
                        <option value="<?php echo 'todas' ?>">Todas</option>

                    <?php }else { //default assim que abre a página 
                    
                        if(isset($_GET['categoria']) && isset($_GET['pagina'])){
                            
                    ?>  
                        <option value="<?php echo $_GET['categoria'] ?>"><?php echo  Painel::select('tb_site.categorias','slug = ?',array($_GET['categoria']))['nome']; ?></option>
                        
                        <?php  
                            $singleCategoria = Painel::selectAll('tb_site.categorias','WHERE slug != ?',array($_GET['categoria']));
                            foreach ($singleCategoria as $key => $value) {
                            
                        ?>
                            <option value="<?php echo $value['slug']; ?>"><?php echo $value['nome']; ?></option>
                        <?php } ?>
                            <option value="todas">Todas</option>

                    <?php }else { ?>
                        
                        <option value="todas">Todas</option>
                    <?php
                        $categorias = Painel::selectAll('tb_site.categorias',null,null);
                        foreach ($categorias as $key => $value) {

                    ?>
                    <option value="<?php echo $value['slug'] ?>"><?php echo $value['nome'] ?></option>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </select>
            </form>
        </div><!--singleNews-->
        <div class="singleNews">
            <form method='POST' class='newsForm'>
                <h3 class='title'>Conheça o autor <i style='padding-left: 10px;' class="fa-solid fa-user-large"></i></h3>
                <div class="authorNesImage" style='background-image: url(<?php echo INCLUDE_PATH."img/perfil3.jpg" ?>);'></div>
                <p class='montserrat ftwbold text-center mrt-20'>Michel Alves</p>
                <p class='poppins text-center p6'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean fringilla sem sed urna fermentum, in dictum dui venenatis.</p>
            </form>
        </div><!--singleNews-->
    </div><!--newsMenu-->
    <div class="content-news">   
        
        <?php

            $pegarTypeCategory = MySql::conectar()->prepare("SELECT nome FROM `tb_site.categorias`");
            $pegarTypeCategory->execute();
            $oldTypeCategory = $pegarTypeCategory->fetch();     

            if(isset($_GET['categorias']) ? $_GET['categorias'] : 0){
                $nome = @$_GET['categorias'];

                if($nome == 'todas'){
                    $limitacao = null;
                    $execute = null;
                }else if($nome == 'nenhuma'){
                    $limitacao = 'ORDER BY id DESC';
                    $execute = null;
                }else if($nome === $nome){
                    $limitacao = 'WHERE slug = ?';
                    $execute = array($nome);
                }
            }

            if(isset($_POST['search'])){
                $valorSearch = $_POST['valor'];

                if(isset($_GET['categoria']) && isset($_GET['pagina'])){
                    $categoriaAtual = Painel::select("tb_site.categorias",'slug = ?',array($_GET['categoria']))['categoria_id'];
                    //Painel::alert("sucesso",$categoriaAtual);

                    @$categoria_idSearch = Painel::select('tb_site.noticias', "titulo LIKE '%$valorSearch%' AND categoria_id = ? ",array($categoriaAtual))['categoria_id'];

                    $quandoNoticia = "WHERE titulo LIKE '%$valorSearch%' AND categoria_id = ? ORDER BY id DESC LIMIT 0,5";
                    $executeNoticia = array($categoria_idSearch);

                }else{
                    @$categoria_idSearch = Painel::select('tb_site.noticias', "titulo LIKE '%$valorSearch%'", null)['categoria_id'];

                    $quandoNoticia = "WHERE titulo LIKE '%$valorSearch%' AND categoria_id = ? ORDER BY id DESC LIMIT 0,5";
                    $executeNoticia = array($categoria_idSearch);
                }

               

                

                if(isset($_GET['categorias']) && $_GET['categorias'] !== 'todas' ){ 
                    //select category
                    $limitacao = 'WHERE categoria_id = ? AND slug = ?';
                    $execute = array($categoria_idSearch, $_GET['categorias']);
                }else if(isset($_GET['categoria']) && isset($_GET['pagina'])){
                    //paginator
                    $limitacao = 'WHERE categoria_id = ? AND slug = ?';
                    $execute = array($categoria_idSearch, $_GET['categoria']);   
                    
                }else{
                    //default
                    $limitacao = 'WHERE categoria_id = ?';
                    $execute = array($categoria_idSearch);

                }

            }

            if(isset($_GET['categoria']) && isset($_GET['pagina'])){
                $limitacao = 'WHERE slug = ?';
                $execute = array($_GET['categoria']);
            }

            //categorias
            $categoria = Painel::selectAll('tb_site.categorias',@$limitacao,@$execute);
            foreach ($categoria as $key => $value) {
                $slugTypeCategory = $value['slug'];
        ?>

            <h2 class='montserrat ftw500 title'>Visualizando posts em: <b><?php echo $value['nome']; ?></b></h2>
                    
            <?php  
                $start = isset($_GET['categoria']) && isset($_GET['pagina']) ? $_GET['pagina'] : 0;
                $porpagina = 5;

                if(isset($_POST['search'])){

                    $noticias = Painel::selectAll('tb_site.noticias',$quandoNoticia,$executeNoticia);
                }else{
                    $noticias = Painel::selectAll('tb_site.noticias'," WHERE categoria_id = ? ORDER BY id DESC LIMIT $start,$porpagina ",array($value['categoria_id']));
                }

                foreach ($noticias as $key => $value) {
                    $slugDaNoticia = $value['slug'];
                    
            ?>        

            <div class='noticiaContent'>
                <h3><?php echo $data = Painel::changeDataFormate($value['data']).' - '.$value['titulo']; ?></h3>
                <img class='imagem-noticia' src='<?php echo INCLUDE_PATH.'painel/uploads/'.$value['imagem']; ?>' >
                <p class='noticiaParagrafo'><?php echo Painel::limitText($value['texto']); ?></p>
                
                <div class="btn-ler-noticia">
                    <a class='readingNews' href='<?php echo INCLUDE_PATH.'noticias/'.$slugTypeCategory.'/'.$slugDaNoticia ?>' >Leia mais</a>
                </div>
            </div><!--single-notica-->
            <?php } //fim noticias 

                //paginas
                if(isset($_POST['search'])){
                    $valorSearch = $_POST['valor'];

                    $noticaQuantidade = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE titulo LIKE '%$valorSearch%' AND categoria_id = ? ");
                    $noticaQuantidade->execute(array($value['categoria_id']));
                    $qnt = $noticaQuantidade->rowCount();
                }else{

                    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ? ");
                    $sql->execute(array($value['categoria_id']));
                    $qnt = $sql->rowCount();
                }
                $totalPaginas = ceil($qnt);

                echo "<div style='justify-content: center;align-items: center;' class='flex'>";

                for ($i=0; $i < $totalPaginas; $i +=5) { 
                    $valor = ($i/5) + 1;

                    if($i == $start){
                        echo '<a class="pages-val pagina-selected" href="'.INCLUDE_PATH.'noticias?categoria='.$slugTypeCategory.'&pagina='.$i.'">'.$valor.'</a>';
                    }else{
                        echo '<a class="pages-val" href="'.INCLUDE_PATH.'noticias?categoria='.$slugTypeCategory.'&pagina='.$i.'">'.$valor.'</a>';
                    }
                }

                echo "</div>";

            ?>
        
        <?php }//fim do foreach categorias  ?>
        
    </div><!--content-news-->

</section>
<?php }else {

    include("noticia_single.php");

}?>