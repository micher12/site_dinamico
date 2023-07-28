$(function(){

    //menu Mobile
    mobileMenu()
    function mobileMenu(){
        var menu = $('.menu');
        var ln1 = $('.ln1');
        var ln2 = $('.ln2');
        var ln3 = $('.ln3');
        var span = $('.menu span');
        var mobile = $('.mobile');
        mobileaberto = false;
        animando = false;

        menu.click(function(){
            if(animando) return

            if(!mobileaberto){
                animando = true;
                mobileaberto = true;
                ln1.css("transform","rotate(45deg)").css("top","14px")
                ln2.css("display","none");
                ln3.css("transform","rotate(-45deg)").css("top","11px");
                span.css("background-color","red")
                mobile.toggle('slide',{direction: 'up'},'slow',function(){
                    animando = false;
                },1000);
            }else{
                animando = true;
                mobileaberto = false;
                ln1.css("transform","rotate(0)").css("top","3px")
                ln2.css("display","block");
                ln3.css("transform","rotate(0)").css("top","17px");
                span.css("background-color","transparent")
                mobile.toggle('slide',{direction: 'up'},'slow',function(){
                    animando = false;
                },1000);
            }
        });

        $(window).resize(()=>{
            if($(window).width() > 860){
                if(mobileaberto){
                    mobileaberto = false;
                    ln1.css("transform","rotate(0)").css("top","3px")
                    ln2.css("display","block");
                    ln3.css("transform","rotate(0)").css("top","17px");
                    span.css("background-color","transparent")
                    mobile.toggle('slide',{direction: 'up'},'slow',function(){
                        animando = false;
                    },1000);
                }
            }
        });

    }

    //desativar alertas
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

    //mask do contato
    $("[type='tel']").mask('(00) 90000-0000');

   //navegação
    if($('target').length > 0){
        //o elemento existe
        res = 67;
        var elemento = '#'+$('target').attr('target');
        var animacao = $(elemento).offset().top;
        var animar = animacao - res
 
        
        $('html,body').animate({scrollTop: animar},1000);
    }

    //slider
    $('.slider').slick({
        adaptiveHeight: true,
        centerMode: false,
        dots: true,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 4500,
        prevArrow: $('.prev'),
        nextArrow: $('.next'),
        cssEase: 'cubic-bezier(0.600, 0.1, 0.635, 0.045)',
        responsive: [
            {
              breakpoint: 601,
              settings: {
                arrows: false,
              }
            },
          ]
    });
    
    //veirificar Content
    contentVeirfy()
    function contentVeirfy(){
        var content = $('.content-news');
        var noticiaContent = $('.content-news > h2 ~ div');

        if(content.text().trim() === '' ){
            content.html("<div class='not-found'><h2>Nenhuma notícia foi encontrada!</h2></div> ");
        }else if(noticiaContent.text().trim() === '' ){
            noticiaContent.html("<div class='not-found'><h2>Não foi encontrado a notícia na categoria selecionada!</h2></div> ");
        }
        

        
    }
    

});
//categorias 
function submitCategoria(){
    document.getElementById('categoriaFORM').submit(function(){
        return false;
    });

}