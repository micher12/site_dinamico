<?php
    if($_SESSION['user'] == ''){
        include('login.php'); 
        $_SESSION['sucesso'] = false;
        die();
    }else{

    if(isset($_GET['loggout'])){
        Painel::loggout();
        
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="<?php echo INCLUDE_PATH; ?>js/painel.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='<?php echo INCLUDE_PATH; ?>js/jquery.magnific-popup.min.js'></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <!--google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;600;700&family=Chivo+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,400&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Lalezar&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500&family=Open+Sans:wght@300;400;500;600&family=Oxygen:wght@300;400;700&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Painel de Controle</title>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/all.min.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/painel.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH?>css/magnific-popup.css">
    <link rel="icon" type="image/x-icon" href="<?php echo INCLUDE_PATH ?>img/config.png">
</head>
<body>

    <section class='main'>
        <div class="flex-main">
            <aside class='menu'>
                <h2 class='text-center'>ControlPainel</h2><!--text-center-->
                <div class="perfil">
                    <?php 
                        if($_SESSION['img'] == ''){
                            echo '<i class="fa-regular fa-user" style="color: #cccccc;"></i>';
                        }else{
                    ?>
                        <div class="img-usuario"
                        
                         style="background-image: url(<?php echo INCLUDE_PATH.'painel/uploads/'. $_SESSION['img']; ?>) "   
                        ></div><!--img-usuario-->    

                    <?php
                        }
                    ?>
                </div><!--perfil-->

                <p class='cargo'><?php  
                    if($_SESSION['cargo'] > 0){
                        echo $_SESSION['user'].'<br>';
                        echo Painel::pegarCargo($_SESSION['cargo']);
                    }else{
                        echo $_SESSION['user'];
                    }
                ?></p><!--cargo-->

                <nav>
                    <ul>
                        <li><a class='selected' href="<?php echo INCLUDE_PATH ?>painel/"><i class="fa-solid fa-user"></i></a></li>
                        <li><a href="<?php echo INCLUDE_PATH; ?>"><i class="fa-solid fa-house"></i></a></li>
                        <?php 
                        if($_SESSION['cargo'] > 0){

                        ?>
                        <li><a href="<?php echo INCLUDE_PATH.'painel/'; ?>files"><i class="fa-regular fa-file-lines"></i></a></li>
                        <?php } ?>
                        <li><a href="<?php echo INCLUDE_PATH .'painel/' ?>config"><i class="fa-solid fa-gear"></i></a></li>
                    </ul>
                </nav>

                <div class="close"><a href="<?php echo INCLUDE_PATH.'painel/'; ?>?loggout"><i class="fa-solid fa-door-closed"></i></a></div><!--close-->

            </aside><!--menu-->


            <div class="main__content">
                <div class="header">
                    <div class="container">
                        <div class="flex">
                            <a><i class="fa-solid fa-bars"></i></a>
                            <?php 
                                if(Painel::retomarHeader()){
                                    //estamos no index.
                            ?>
                            <h2>Bem vindo <b><?php echo $_SESSION['nome']; ?></b></h2>
                            <?php
                                }else{ //estamos na pagina de acordo com a url
                                    
                                
                            ?>
                                <h2 style='display: flex;align-items: center;'><a class='painel-block montserrat ftw500' href="<?php echo INCLUDE_PATH.'painel'?>">Painel</a> <i class="fa-solid fa-chevron-right" style="color: #000000; font-size: 16px; margin: 0 10px;"></i> <b style='cursor: text'><?php echo Painel::renomearTitleUrl($_GET['url']); ?></b></h2>

                            <?php } ?>

                        </div><!--flex-->
                    </div><!--container-->
                </div><!--header-->

                <div class="container">
                    <div class="content-main">
                        <?php
                            Painel::carregarPagina();
                        ?>
                        
                    </div><!--content-main-->
                </div><!--container conteudo do MAIN-->
                
            </div><!--main__content-->
        </div><!--flex-main-->
        
    </section><!--main-->

<script src='<?php echo INCLUDE_PATH ?>js/all.min.js'></script>
<script src='<?php echo INCLUDE_PATH ?>js/jquery-ui.min.js'></script>
<script src="https://cdn.tiny.cloud/1/hzbkfjpzjzimup3ro58180yjw32gw6749309rotleujjt725/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '.tinyMC',
        resize: false,
        menubar: 'file edit insert view format table tools help',
        language: 'pt_BR',
        content_langs: [
                { title: 'Português', code: 'pt_BR' },
            ],
        height: 500,
        plugins: [
          'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
          'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
          'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | bold italic backcolor | ' +
          'alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist outdent indent | removeformat | help'

    });
  </script>

</body>
</html>


<?php
    }
?>