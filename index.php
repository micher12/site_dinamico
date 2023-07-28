<?php include('config.php'); ?><!-- incluindo config -->
<?php Site::updateUsuario(); ?>
<?php Site::contador();?>
<?php
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
    $sql->execute();
    $siteConfig = $sql->fetch();

    if(isset($_POST['meupost'])){
        echo "postado!";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src='<?php echo INCLUDE_PATH; ?>js/jquery.mask.js'></script>
    <script src="<?php echo INCLUDE_PATH; ?>js/main.js"></script>
    <script src='<?php echo INCLUDE_PATH; ?>js/parallax.min.js'></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='description' content="Minha descrição!">
    <meta name="keywords" content="palavra,chaves,do,meu,site">
    <meta name="author" content="programador/dono da empresa">
    <link rel="icon" type="image/x-icon" href="<?php echo INCLUDE_PATH ?>icon.png">
    <!--google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;600;700&family=Chivo+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,400&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Lalezar&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,500&family=Open+Sans:wght@300;400;500;600&family=Oxygen:wght@300;400;700&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title><?php echo $siteConfig['titulo']; ?></title>
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>css/all.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

    
</head>
<body>



    <?php
        $url = isset($_GET['url']) ? $_GET['url'] : 'home';
        switch ($url) {
            case 'sobre':
                echo '<target target="sobre" />';
                break;
            
            case 'depoimentos':
                echo "<target target = 'depoimentos'/>";
                break;
        }

    ?><!--php para efeito scrolling navegation-->

    <div class="errorvalidate-center">
        <div class="error-validate">
            <h2><i class="fa-solid fa-triangle-exclamation" style="color: #fff; margin-right: 10px"></i>Algo deu errado!</h2>
        </div>
    </div><!--error_form-->
    

    <div class="startLoading">
        <div class="overlay-loading">
            <svg class="pl" width="240" height="240" viewBox="0 0 240 240">
                <circle class="pl__ring pl__ring--a" cx="120" cy="120" r="105" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round"></circle>
                <circle class="pl__ring pl__ring--b" cx="120" cy="120" r="35" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round"></circle>
                <circle class="pl__ring pl__ring--c" cx="85" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                <circle class="pl__ring pl__ring--d" cx="155" cy="120" r="70" fill="none" stroke="#000" stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
            </svg>
        </div><!--overlay-loading-->
    </div><!--tela de loading-->

    <div class="endLoading">
        <h2><i class="fa-regular fa-circle-check" style="color: #fff; margin-right: 10px;"></i>Enviado com sucesso!</h2>
    </div><!--resposta sucesso! form -->


    <div class="dark"></div><!--dark-->

    <header>
        <div class="menu">
            <span>
                <div class="linemain ln1"></div>
                <div class="linemain ln2"></div>
                <div class="linemain ln3"></div>
            </span>
        </div><!--menu-->
        <div class="container">
            <div class="flexheader">
                <a href="<?php echo INCLUDE_PATH; ?>home"><div class="logo"><?php echo $siteConfig['title_web'] ?></div></a><!--logo-->

                <nav class="desktop">
                    <ul>
                        <li><a href="<?php echo INCLUDE_PATH; ?>sobre">Sobre</a></li>
                        <li><a href="<?php echo INCLUDE_PATH; ?>depoimentos">Depoimentos</a></li>
                        <li><a href="<?php echo INCLUDE_PATH; ?>noticias">Notícias</a></li>
                        <li><a href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
                        <li><a href="<?php echo INCLUDE_PATH.'painel/'; ?>"><?php
                            if(isset($_SESSION['login'])){
                                echo '<i class="fa-solid fa-user"></i> Entrar';
                            }else if(isset($_COOKIE['lembrar'])){
                                echo '<i class="fa-solid fa-user"></i> Entrar';
                            }else{
                                echo '<i class="fa-regular fa-user"></i> Login';
                            }
                        
                        ?></a></li>
                    </ul>
                </nav><!--desktop-->
            </div><!--flexheader-->
        </div><!--container-->
        <nav class="mobile">
            <ul>
                <li><a href="<?php echo INCLUDE_PATH; ?>sobre">Sobre</a></li>
                <li><a href="<?php echo INCLUDE_PATH; ?>depoimentos">Depoimentos</a></li>
                <li><a href="<?php echo INCLUDE_PATH; ?>noticias">Notícias</a></li>
                <li><a href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
                <li><a href="<?php echo INCLUDE_PATH.'painel/'; ?>"><?php
                    if(isset($_SESSION['login'])){
                        echo '<i class="fa-solid fa-user"></i> Entrar';
                    }else{
                        echo '<i class="fa-regular fa-user"></i> Login';
                    }
                        
                ?></a></li>
            </ul>
        </nav><!--desktop-->
    </header><!--header-->

    <div class="container-principal">

        <?php
            $url = isset($_GET['url']) ? $_GET['url'] : 'home';
            
            if(file_exists('pages/'.$url.'.php')){
                //se existir o arquivo então execute:
                include("pages/".$url.".php");
            }else{
                //podemos fazer o que quiser, página não existe
                if($url != 'sobre' && $url != 'depoimentos'){
                    $urlPar = explode('/',$url)[0];
                    if($urlPar != 'noticias'){
                        include('pages/404.php');
                    }else{
                        include('pages/noticias.php');
                    }
                }else{
                    include('pages/home.php');
                }
            }
        ?><!-- index && error 404 -->

    </div><!--container-principal-->


    <footer>
        <div class="container">
            <p>Todos os direitos &copy;2023 reservados | Inc Company.</p>
        </div><!--container-->
    </footer>


<script src="<?php echo INCLUDE_PATH; ?>js/all.min.js"></script>
<script src="<?php echo INCLUDE_PATH; ?>js/jquery-ui.min.js"></script>

<?php
    if($url == 'contato'){
?>
<script defer src="<?php echo INCLUDE_PATH; ?>js/map.js"></script>
<script defer src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAuoClS5Cd2s2MSbHkI1ITZgoxC40rBBQg&callback=Function.prototype'></script>

<?php
    }
?><!-- fim do php para carregamento do map no contato -->

<script src="<?php echo INCLUDE_PATH ?>js/formulario.js"></script>

</body>
</html>