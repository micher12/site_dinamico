<?php 
$url = explode('/',$_GET['url']);
if(Painel::existeNaTabela('tb_site.categorias','slug = ?',$url[1])){
    if(!Painel::existeNaTabela('tb_site.noticias','slug = ?',$url[2])){
        Painel::alert('error','Notícia não foi encotrada!');
    }else{
    
?>
<section class='single-noticia'>
    <?php  
    
        $url = explode('/',$_GET['url']);      

        $categoria = $url[1];
        $slugNoticia = $url[2];
        $categoria_id = Painel::returnCategoriaIdSlug('tb_site.categorias',$categoria);

        $noticia = Painel::selectAll('tb_site.noticias','WHERE slug = ? AND categoria_id = ?',array($slugNoticia,$categoria_id));

        foreach ($noticia as $key => $value) {
    ?>
    <div class="container">
        <h2 class='titulo-noticia poppins ftw500'><?php echo $value['titulo'];?></h2>
        <img style='width: 100%' class='imagem-noticia' src='<?php echo INCLUDE_PATH.'painel/uploads/'.$value['imagem']; ?>'>
        <p class='texto-noticia'><?php echo $value['texto']; ?></p>
    </div>

    <?php } ?>
</section>
<?php } 
}else{  
  include('pages/404.php');
} 
?>