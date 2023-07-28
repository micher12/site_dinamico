$(function(){

    //mudarformulario para registrar
    mudarformulario();
    function mudarformulario(){
        var register = $('#registrar');
        var login = $('#login');
        var loginForm = $('.form-login');
        var registerForm = $('.register-form');
        var title = $('.login')

        register.click(function(){
            var email = $('.form-login input[name="email"]');
            var senha = $('.form-login input[name="password"]');
            email.val('');
            senha.val('');
            loginForm.css("display",'none');
            title.html('Registrar');
            registerForm.css('display','flex');
        })

        login.click(function(){
            loginForm.css("display",'flex');
            title.html('Login');
            registerForm.css('display','none');
        });

    }

    //mostar senha
    mostarSenha()
    function mostarSenha(){
        var btn = $('.showpass');
        var senha = $('input[type="password"]');
        var showPassword = false;
        btn.click(function(){
            if(!showPassword){
                showPassword = true
                senha.attr('type','text');
            }else{
                showPassword=false;
                senha.attr('type','password');
            }
            
        })
    }

    //login disponivel!
    registarDisponivel()
    logarDisponivel();
    function logarDisponivel(){
        var email = $('.form-login input[name="email"]');
        var senha = $('.form-login input[name="password"]');
        var logar = $('.form-login input[type="submit"]');


        setInterval(()=>{
            if(email.val() != '' && senha.val() != '' ){
                logar.css("border","0").css("background-color","#7c7cf1").css('box-shadow','2px 4px 1px rgb(87, 87, 231)').css('color','#fff').css("cursor","pointer");
                
            }else{
                logar.css("border",'0').css("border",'1px solid #ccc').css('background-color',"transparent").css('color','#ccc').css("box-shadow","none");
            }
        },100)
    

    }
    function registarDisponivel(){
        var nome = $('.register-form input[name="nome"]');
        var usuario = $('.register-form input[name="user"]');
        var email = $('.register-form input[name="email"]')
        var senha = $('.register-form input[name="password"]');
        var btn = $('.register-form input[type="submit"]');

        setInterval(()=>{
            if(nome.val() != '' && usuario.val() != '' && email.val() != '' && senha.val() != '' ){
                btn.css("border","0").css("background-color","#7c7cf1").css('box-shadow','2px 4px 1px rgb(87, 87, 231)').css('color','#fff').css("cursor","pointer");
            }else{
                btn.css("border",'0').css("border",'1px solid #ccc').css('background-color',"transparent").css('color','#ccc').css("box-shadow","none");
            }
        },100);

    }
    //mobile
    mobile()
    function mobile(){
        var btn = $('.header a');
        var menu = $('.menu');
        var mobileAberto = false;
        var animando = false;

        btn.click(function(){
            var svg = btn.find('svg');

            if(animando) return

            if(!mobileAberto){
                svg.removeClass('fa-bars').addClass('fa-xmark').css("color",'red');
                animando = true;
                mobileAberto = true;
                menu.toggle('slide','slow',function(){
                    $(this).css("display",'flex');
                    animando = false;
                },1000).css('display','flex');

            }else{
                svg.removeClass('fa-xmark').addClass('fa-bars').css("color",'black');
                animando = true;
                mobileAberto = false;
                menu.toggle('slide','slow',function(){
                    animando = false;
                });
            }
        });

        $(window).resize(function(){
            if($(window).width() >= 500){
                menu.css("display",'flex');
            }else{
                var svg = btn.find('svg');
                svg.removeClass('fa-xmark').addClass('fa-bars').css("color",'black');
                menu.css("display",'none')
                if(mobileAberto){
                    mobileAberto = false
                }
            }
        }); 

    }

    //desativarAlert
    disableAlerts();
    function disableAlerts(){
        setInterval(function () {
            if($('.sucessoAlert').css('display') == 'block' ){
                setInterval(function(){
                    $('.sucessoAlert').slideUp();
                },3000);
                
            }else if($('.errorAlert').css("display") == 'block' ){
                setInterval(function(){
                    $('.errorAlert').slideUp();
                },3000);
            }else if($('.error').css('display') == 'block'){
                setInterval(function(){
                    $('.error').slideUp();
                },6000);
            }else if($('.sucesso').css('display') == 'block'){
                setInterval(function(){
                    $('.sucesso').slideUp();
                },3000);
            }else if($('.alert').css('display') == 'block'){
                setInterval(function(){
                    $('.alert').slideUp();
                },3000);
            }
        },500);
    }

    //mudarcoricones
    changeIcon();
    function changeIcon(){
        var icons = $('.menu nav li a');

        icons.hover(function(){
            icons.css("color","#fff");
            $(this).css("color",'#cf1dcf');
        },function(){
            icons.css("color","#fff");
            if($(this).attr('class') == 'selected'){
                $(this).css("color",'#cf1dcf');
            }else{
                $('.menu li a.selected').css("color", '#cf1dcf');

            }
        });

        var door = $('.close > a');
        door.hover(()=>{
            var svg = door.find('svg');
            svg.removeClass('fa-door-closed').addClass('fa-door-open').css('color','red');
        },()=>{
            var svg = door.find('svg');
            svg.removeClass('fa-door-open').addClass('fa-door-closed').css("color","#fff");
        });
    }

    //diminuir a lista no painel
    diminuirLista()
    function diminuirLista(){
        var clicado = false;

        $('.hideList').click(function(){
            if(!clicado){
                clicado = true

                var icon = $(this);
                icon.find('svg').removeClass("svg-inline--fa fa-chevron-down").addClass("svg-inline--fa fa-chevron-up");
                
                var el = $(this).parent();
                var table = $(el).parent().find('.table');
                if($(table).length > 0){
                    table.each(function(index) {
                        if (index > 0) {
                            $(this).css('display', 'none');
                        }
                    });
                }
            }else{
                clicado = false;

                var icon = $(this);
                icon.find('svg').removeClass("svg-inline--fa fa-chevron-up").addClass('svg-inline--fa fa-chevron-down');

                var el = $(this).parent();
                var table = $(el).parent().find('.table');
                if($(table).length > 0){
                    table.each(function(index) {
                        if (index > 0) {
                            $(this).css('display', 'flex');
                        }
                    });
                }
            }
        });

    }  

    //confirmar ação de deletar
    $('[actionBtn="delete"]').click(function(){
        var r = confirm("Confirmar ação de deletar ?");
        if(r == true){
            return true;
        }else{
            return false;
        }
    })

    //deixar imagem maior PAINEL
    $('.minPopup').magnificPopup({
        type:'image'
    });

    //reemviar codigo
    verifyAnotherCode()
    function verifyAnotherCode(){
        var el = $('.verify-code');
        var other = $('.reenviar-code input');
        var tempo  = $('.contagem');
        var tempoTotal = 60;
        

        if(el.length > 0){
            
            setInterval(function(){
                if(tempoTotal > 0){
                    tempoTotal--;
                    tempo.text(tempoTotal+'s');
                }else{
                    mudarInput();
                    tempo.text('');
                }
            },1000);

            
            function mudarInput(){
                other.css("color",'#000').css('pointer-events','visible');
            }
            
        }
    }

});