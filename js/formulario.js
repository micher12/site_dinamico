$(function(){

    //$('form').submit(function (){}); poderia utilizar ou o abaixo para pegar DOM
    $('.form__main,.contato__form').submit(function(){
        var form = $(this);
        var loading = false;

        $.ajax({
            beforeSend: () =>{
                if(!loading){
                    $('.dark').toggle("fade",'slow');
                    $('.startLoading').toggle('fade','slow');
                }
            },
            url: 'ajax/formularios.php',
            method:'POST',
            dataType: 'json',
            data: form.serialize(),
        }).done(function(data){
            if(data.sucesso){
                //tudo certo!
                $('.dark').toggle('fade','slow');
                $('.startLoading').toggle('fade','slow');
                $('.endLoading').toggle('slide',{direction: 'up'},'slow',()=>{
                    $('.endLoading').addClass("width40p");
                },1000);

                setTimeout(()=>{
                    $('.endLoading').toggle('slide',{direction: 'up'},'slow').removeClass('width40p');
                },3000)
                
            }else{
                //algo deu errado.
                $('.dark').toggle('fade','slow');
                $('.startLoading').toggle('fade','slow');
                $('.error-validate').toggle('shake','slow')

                setTimeout(()=>{
                    $('.error-validate').toggle('fade','slow');
                },3000);
            }
        });

        return false;
    });

    
});

