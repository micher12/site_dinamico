<section data-z-index="0" class="main parallax-window" data-parallax="scroll" data-image-src="<?php echo INCLUDE_PATH.'img/background.jpg'; ?>">
    <div class="escurecer"></div>
    <div class="container">
               

        <form method="post" action="" class="form__main">
            <h2>Qual o seu melhor e-mail?</h2>
            <input type="email" required name="email" placeholder="e-mail">
            <input type="submit" name='acao' value="Cadastrar!">
        </form><!--form__m ain-->

    </div><!--container-->
</section><!--main-->

<section id='sobre' class="sobre">
    <div class="container">
        <h2><?php echo $siteConfig['title_about']; ?></h2>
        <div class="flexcontent">
            <div class="leftcontent">
                
                <?php echo $siteConfig['text1-sobre'] ?>
                <?php echo $siteConfig['text2-sobre'] ?>
            </div><!--leftcontent-->
            <div class="rightcontent">
                <img src="<?php echo INCLUDE_PATH ?>img/perfil3.jpg">
            </div><!--rightcontent-->
        </div><!--flexcontent-->
    </div><!--container-->
</section><!--sobre-->

<section class='sliders'>
    <div class="slider">
        <?php 
            $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.slides` ORDER BY order_id");
            $sql->execute();
            $info = $sql->fetchAll();
            foreach ($info as $key => $value) {
        ?>
            <div data-z-index="0" class="slidersingle parallax-window" data-parallax="scroll" style='background-image: url("<?php echo INCLUDE_PATH.'painel/uploads/'.$value['imagem']; ?>")'>
                <h2 class='slidertitle'><?php echo $value['nome']; ?></h2>
            </div>
        <?php } ?>
    </div>

    <div class="nav-bullets">
        <ul>
            <li class="prev"><i class="fa-solid fa-chevron-left"></i></li><!--prev-->
            <li class="next"><i class="fa-solid fa-chevron-right"></i></li><!--next-->
        </ul>
    </div><!--nav-bullest-->
</section>

<section id='depoimentos' class='depoimentos'>
    <div class="container">
        <div class="flex">
            <div class="dep w50 mr-2">
                

                <h2 class='poppins ftw500 p20'>Depoimentos dos clientes: <i class="fa-regular fa-comment-dots" style="color: #ffffff;"></i></h2>
                <?php
                $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.depoimentos` ORDER BY order_id LIMIT 3");
                $sql->execute();
                $info = $sql->fetchAll();
                foreach ($info as $key => $value) {
                    echo "<p class='content-dep montserrat p6'>".$value['depoimento']."<br> <b class='p6 poppins'>".$value['nome']."</b>"."</p>";
                }
                
                ?>
            </div><!--left-->
            <div class="serv w50 ml-2">
                <h2 class='poppins ftw500 p20'>Serviços: <i class="fa-solid fa-briefcase" style="color: #ffffff;"></i></h2>
                <ul>
                    <?php
                        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.servicos` ORDER BY order_id LIMIT 3");
                        $sql->execute();
                        $info = $sql->fetchAll();
                        foreach ($info as $key => $value) {
                    ?>
                    <li>
                        <p class='p20 montserrat'><b style='font-size: 24px'><?php echo $value['title']; ?></b><br/><?php echo $value['servicos']; ?></p>
                    </li>
                    <?php } ?>
                </ul>
            </div><!--right-->
        </div>
    </div><!--container-->
</section><!--depoimentos-->



