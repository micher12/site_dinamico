<?php if($_SESSION['cargo'] == 2 ){ //se for administrador

?>
  <h2 style='margin-top: 40px; background-color: #f7984a; color: #fff;padding: 10px 2%;'>Sessão: Admin</h2><!--title sessão-->

  <div class="box-content cargo-2"> 
      <h2 class='title'>Dados <i class="fa-solid fa-chart-simple"></i> : </h2>
      <div class='graficos'>
          <canvas id="myChart"></canvas>
      </div>
      <p>Usuários registrados: <?php echo $_SESSION['cadastrado']; ?></p>
      <p>Total de visitas: <?php echo $_SESSION['visitaTotal']; ?></p>
  </div>

  <div class="flex">
    <div class="box-content cargo-2 w50 mr-2">
      <h2>Inserir Usuário <i class="fa-solid fa-user-plus" style="color: #ffffff;font-size: 22px;"></i></h2>
      <?php

        //registrar usuário ADMIN
        if(isset($_POST['register'])){
          $usuario = $_POST['user'];
          $email = $_POST['email'];
          $senha = $_POST['password'];
          $img = '';
          $nome = $_POST['nome'];
          $cargo = $_POST['cargo'];
          $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.usuarios` VALUES(null,?,?,?,?,?,?)");
          if(Usuario::emailCadastrado($email)){
            //não consta no banco de dados pode continuar
            if(Usuario::userCadastrado($usuario)){
              //usuário não existe
              if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                //é um email válido continua
                if($cargo == ''){
                  //cargo nulo
                  $cargo = 0;
                  if($sql->execute(array($usuario,$email,$senha,$img,$nome,$cargo))){
                    Painel::alert("sucesso","Inserido com sucesso! cargo igual a: 0");
                  }else{
                    //error
                    Painel::alert('error',"Não foi possível inserir.");
                  }
                }else{
                  //cargo foi definido de acordo com o valor
                  $cargo = $_POST['cargo'];
                  if($sql->execute(array($usuario,$email,$senha,$img,$nome,$cargo))){
                    Painel::alert("sucesso","Inserido com sucesso! cargo igual a: ".$cargo);
                  }else{
                    //error
                    Painel::alert('error',"Não foi possível inserir.");
                  }
                }
              }else{
                //não é um email valido
                Painel::alert('error',"Formato do email é invalido.");
              }
            }else{
              Painel::alert('error',"Usuário não está disponível.");
            }
          }else{
            //não é possivel
            Painel::alert('error',"Email já utilizado.");
          }
        }
        
        //mudar usuário ADMIN =========================================
        if(isset($_POST['change'])){
          $nome = $_POST['nome'];
          $usuario = $_POST['user'];
          $email = $_POST['email'];
          $senha = $_POST['password'];
          $cargo = $_POST['cargo'];
          $emailatual = $_POST['emailatual'];
          $sql = MySql::conectar()->prepare("UPDATE `tb_admin.usuarios` SET nome = ? , user = ?, email = ?, `password` = ? , cargo = ? WHERE email = ?");
          //$sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));

          if($emailatual != ''){
            //pode seguir
            if(!Usuario::emailCadastrado($emailatual)){

              if($nome != ''){
                if($senha != ''){
                  if($usuario != ''){
                    //SEGUNRAÇA NÃO TER DOIS USUÁRIO IGUAIS
                    if(Usuario::userCadastrado($usuario)){
                      //TUDO CERTO!
                      if($email != ''){
                        //foi preenchido
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                        }
                      }else{
                        //está vazio mantém o mesmo
                        $email = $emailatual;
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                        }
                      }
                    }else{
                      Painel::alert("error","Usuário não disponível.");
                    }
                    
                  }else{
                    //Usuário é vazio
                    $usuario = Painel::pegarUsuario($emailatual);

                    if(Usuario::userCadastrado($usuario)){
                      //TUDO CERTO!
                      if($email != ''){
                        //foi preenchido
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                        }
                      }else{
                        //está vazio mantém o mesmo
                        $email = $emailatual;
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Usuário atulizado! cargo resetado.");
                        }
                      }
                    }else{
                      Painel::alert("error","Usuário não disponível.");
                    }
                  }
                }else{
                  $senha = Painel::pegarSenha($emailatual);
                  if($usuario != ''){
                    if(Usuario::userCadastrado($usuario)){
                      //TUDO CERTO!
                      if($email != ''){
                        //foi preenchido
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                        }
                      }else{
                        //está vazio mantém o mesmo
                        $email = $emailatual;
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Usuário atulizado! cargo resetado.");
                        }
                      }
                    }else{
                      Painel::alert("error","Usuário não está disponível.");
                    }
                  }else{
                    //Usuário é vazio
                    $usuario = Painel::pegarUsuario($emailatual);

                    if(Usuario::userCadastrado($usuario)){
                      //TUDO CERTO!
                      if($email != ''){
                        //foi preenchido
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                        }
                      }else{
                        //está vazio mantém o mesmo
                        $email = $emailatual;
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Usuário atulizado! cargo resetado.");
                        }
                      }
                    }else{
                      Painel::alert("error","Usuário está não disponível.");
                    }
                  }
                }
              }else{
                //nome é vazio
                $nome = Painel::pegarNome($emailatual);
                if($senha != ''){
                  if($usuario != ''){
                    if(Usuario::userCadastrado($usuario)){
                      //TUDO CERTO!
                      if($email != ''){
                        //foi preenchido
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                        }
                      }else{
                        //está vazio mantém o mesmo
                        $email = $emailatual;
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Usuário atulizado! cargo resetado.");
                        }
                      }
                    }else{
                      Painel::alert("error","Usuário está não disponível.");
                    }
                  }else{
                    //Usuário é vazio
                    $usuario = Painel::pegarUsuario($emailatual);
                    //TUDO CERTO!
                    if($email != ''){
                      //foi preenchido
                      if($cargo != ''){
                        $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                        Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                      }else{
                        $cargo = '0';
                        $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                        Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                      }
                    }else{
                      //está vazio mantém o mesmo
                      $email = $emailatual;
                      if($cargo != ''){
                        $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                        Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                      }else{
                        $cargo = '0';
                        $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                        Painel::alert('sucesso',"Senha atulizada! cargo resetado.");
                      }
                    }
                    
                  }
                }else{
                  $senha = Painel::pegarSenha($emailatual);
                  if($usuario != ''){
                    if(Usuario::userCadastrado($usuario)){
                      //TUDO CERTO!
                      if($email != ''){
                        //foi preenchido
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                        }
                      }else{
                        //está vazio mantém o mesmo
                        $email = $emailatual;
                        if($cargo != ''){
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                        }else{
                          $cargo = '0';
                          $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                          Painel::alert('sucesso',"Usuário atulizado! cargo resetado.");
                        }
                      }
                    }else{
                      Painel::alert("error","Usuário está não disponível.");
                    }
                  }else{
                    $usuario = Painel::pegarUsuario($emailatual);
                    //TUDO CERTO!
                    if($email != ''){
                      //foi preenchido
                      if($cargo != ''){
                        $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                        Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                      }else{
                        $cargo = '0';
                        $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                        Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso! <br> cargo definido como: ".$cargo);
                      }
                    }else{
                      //está vazio mantém o mesmo
                      $email = $emailatual;
                      if($cargo != ''){
                        $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                        Painel::alert('sucesso',"Todos os itens foi atualizado com sucesso!");
                      }else{
                        $cargo = '0';
                        $sql->execute(array($nome,$usuario,$email,$senha,$cargo,$emailatual));
                        Painel::alert('sucesso',"Usuário atulizado! cargo resetado.");
                      }
                    }
                    
                  }
                }
              }
            //EMAIL não ENCONTRADO ABAIXO:  
            }else{
              Painel::alert('error',"Email não encontrado!");
            }
          }else{
            //precisa da referencia
            Painel::alert('error',"É preciso do email como índice para editar");
          }

        }//acabou EDIT USER ==================================================

        //deletar usuário
        if(isset($_POST['delete'])){
          $user = $_POST['user'];
          $email = $_POST['email'];
          $sql = MySql::conectar()->prepare("DELETE FROM `tb_admin.usuarios` WHERE email = ? AND user = ?");
          if(!Usuario::emailCadastrado($email)){
            if(!Usuario::userCadastrado($user)){
              $sql->execute(array($email,$user));
              if($sql->rowCount() > 0){
                Painel::alert("sucesso",$user.' foi deletado com sucesso!');
              }else{
                Painel::alert("error","O ".$user.' ou '.$email.' não são correspondentes.');
              }
            }else{
              Painel::alert("error","O usuário: ".$user.' não foi encontrado.');
            }
          }else{
            Painel::alert("error","O email: ".$email.' não foi encontrado.');
          }

          
        }


      ?>

      <form method="post" class='inserir'>
        <input type="nome" name='nome' placeholder="Nome completo" required>
        <input type="nome" name='user' placeholder="Usuário" required>
        <input type="email" name='email' placeholder="Email" required>
        <input type="password" name='password' placeholder="Senha" required>
        <input type="text" name='cargo' placeholder="Cargo *numero">
        <input type="submit" name='register' value="Registrar">
      </form>
    </div><!--box-content-->

    <div class="box-content cargo-2 w50 ml-2">
      <h2>Alterar dados do usuário <i class="fa-solid fa-user-pen" style="color: #ffffff;font-size: 22px;"></i></h2>
      <form method="post" class='alterarUsuario'>
      <input type="email" name='emailatual' placeholder="Email atual*" >
        <input type="nome" name='nome' placeholder="Nome" >
        <input type="nome" name='user' placeholder="Usuário" >
        <input type="email" name='email' placeholder="Novo Email">
        <input type="password" name='password' placeholder="Senha" >
        <input type="text" name='cargo' placeholder="Cargo *0">
        <input type="submit" name='change' value="Alterar">
      </form>
    </div><!--box-content-->

  </div><!--flex-->

  <div class="flex">
    <div class="box-content cargo-2 w50S" >
        <h2>Excluir Usuário <i class="fa-solid fa-user-minus" style="color: #ffffff; font-size: 22px;"></i></h2>
        <form method='POST' class='delete'>
          <input type="email" name='email' placeholder='email' required>
          <input type="text" name='user' placeholder="usuário" required>
          <input type="submit" name='delete' value="Excluir">
        </form>
    </div><!--box-content-->
  </div><!--flex-->
  
<?php
} 
if($_SESSION['cargo'] > 0){ //se o cargo for moderador ==========================================================================

  //inserir depoimento
  if(isset($_POST['inserirdep'])){
    $nome = $_POST['nome'];
    $depoimento = $_POST['depoimento'];
    $lastId = Mysql::conectar()->lastInsertId();
    $sql = MySql::conectar()->prepare("INSERT INTO `tb_site.depoimentos` values(null,?,?,?)");
    if(Usuario::depoimentoCadastrado($nome,$depoimento)){
      if($sql->execute(array($nome,$depoimento,$lastId))){
        $lastId = Mysql::conectar()->lastInsertId();
        $sql = MySql::conectar()->prepare("UPDATE `tb_site.depoimentos` SET order_id = ? WHERE id = ?");
        $sql->execute(array($lastId,$lastId));
        Painel::alert("sucesso","Depoimento inserido com sucesso!");
      }else{
        Painel::alert("error","Não foi possível inserir o depoimento.");
      }
    }else{
      Painel::alert("error","Depoimento já foi cadastrado.");
    }
    
  }

  //deletar depoimento
  if(isset($_POST['deletdep'])){
    $nome = $_POST['nome'];
    if(Usuario::deletarDepoimento($nome)){
      Painel::alert("sucesso","Depoimento deletado com sucesso!");
    }else{
      Painel::alert("error","Não foi possível deletar o depoimento ou ele não existe.");
    }
  }

  //editar-depoimento
  if(isset($_POST['editar-dep'])){
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $nome = $_POST['nome'];
      $depoimento = $_POST['depoimento'];
      if($nome != ''){
        if($depoimento != ''){
          $sql = MySql::conectar()->prepare("UPDATE `tb_site.depoimentos`  SET nome = ? ,depoimento = ?  WHERE id = ? ");
          if($sql->execute(array($nome,$depoimento,$id))){
            Painel::alert("sucesso","Todos os itens do id: ".$_GET['id']." foi atualizado com sucesso!");
          }else{
            Painel::alert("error","Algo deu errado.");
          }
        }else{
          $sql = MySql::conectar()->prepare("UPDATE `tb_site.depoimentos` SET nome = ? WHERE id = ?");
          if($sql->execute(array($nome,$id))){
            Painel::alert("sucesso","O nome do id: ".$_GET['id']." foi atualizado com sucesso!");
          }else{
            Painel::alert("error","Algo deu errado.");
          }
        }
      }else{
        if($depoimento != ''){
          $sql = MySql::conectar()->prepare("UPDATE `tb_site.depoimentos` SET depoimento = ? WHERE  id = ? ");
          if($sql->execute(array($depoimento,$id))){
            Painel::alert("sucesso","Depoimento do id: ".$_GET['id']." foi atualizado com sucesso!");
          }else{
            Painel::alert("error","Algo deu errado.");
          }
        }else{
          Painel::alert('alert',"Nada foi alterado.");
        }
      }
    }else{
      Painel::alert("error",'é preciso selecionar um  ID!');
    }
  }

  //adicionar servicos
  if(isset($_POST['inserirservicos'])){
    $title = $_POST['title'];
    $servicos = $_POST['servico'];
    $lastId = MySql::conectar()->lastInsertId();
    $sql = MySql::conectar()->prepare("INSERT INTO `tb_site.servicos` VALUES(null,?,?,?)");
    if(Usuario::servicoCadastrado($title,$servicos)){
      if($sql->execute(array($title,$servicos,$lastId))){
        $lastId = MySql::conectar()->lastInsertId();
        $sql = MySql::conectar()->prepare("UPDATE `tb_site.servicos` SET order_id = ? WHERE id = ?");
        $sql->execute(array($lastId,$lastId));
        Painel::alert("sucesso","Servico inserido com sucesso!");
      }else{
        Painel::alert("error","Algo deu errado.");
      }
    }else{
      Painel::alert("error","Seriço já está cadastrado.");
    }
  }


  //deletetar servicos
  if(isset($_POST['deletar-servico'])){
    $title = $_POST['title'];
    if(Painel::titleExiste($title)){
      $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.servicos` WHERE title = ?");
      if($sql->execute(array($title))){
        Painel::alert("sucesso","Serviço ".$title." foi deletado com sucesso.");
      }else{
        Painel::alert("error","Algo deu errado.");
      }
    }else{
      Painel::alert("error","Não foi encontrado.");
    }
  }

  //editar servicos
  if(isset($_POST['editar-servico'])){
    if(isset($_GET['servicoid'])){
      $id = (int)$_GET['servicoid'];
      $title = $_POST['title'];
      $servicos = $_POST['servico'];

      if($title != ''){
        if($servicos != ''){
          $sql = MySql::conectar()->prepare("UPDATE `tb_site.servicos` SET title = ?, servicos = ? WHERE id = ?");
          if($sql->execute(array($title,$servicos,$id))){
            Painel::alert("sucesso","Atualizado com sucesso!");
          }else{
            Painel::alert("error","Algo deu errado.");
          }
        }else{
          $sql = MySql::conectar()->prepare("UPDATE `tb_site.servicos` SET title = ? WHERE id = ?");
          if($sql->execute(array($title,$id))){
            Painel::alert("sucesso","Atualizado com sucesso!");
          }else{
            Painel::alert("error","Algo deu errado.");
          }
        }
      }else{
        if($servicos != ''){
          $sql = MySql::conectar()->prepare("UPDATE `tb_site.servicos` SET servicos = ? WHERE id = ?");
          if($sql->execute(array($servicos,$id))){
            Painel::alert("sucesso","Atualizado com sucesso!");
          }else{
            Painel::alert("error","Algo deu errado.");
          }
        }else{
          Painel::alert("alert","Nada foi alterado.");
        }
      }

    }else{
      Painel::alert("error","É preciso de um ID.");
    }
  }

  //inserir slides
  if(isset($_POST['slide-inserir'])){
    //Painel::alert("sucesso",'ok');
    $nome = $_POST['nome'];
    $img = $_FILES['imagem'];
    $lastId = '0';
    $sql = MySql::conectar()->prepare("INSERT `tb_site.slides` values(null,?,?,?)");

    if($img['name'] != ''){
      if($nome != ''){
        if(!Painel::existeNaTabela('tb_site.slides','nome = ?',$nome)){
          if(Painel::imagemValida($img)['status']){
            $nomeImg = Painel::uploadFile($img);
            if($sql->execute(array($nome,$nomeImg,$lastId))){
              $lastId = MySql::conectar()->lastInsertId();
              $sql = MySql::conectar()->prepare("UPDATE `tb_site.slides` SET order_id = ? WHERE id = ?");
              $sql->execute(array($lastId,$lastId));
              Painel::alert("sucesso","Slider adicionado com sucesso!");
            }else{
              Painel::alert("error","Algo deu errado.");
            }
          }else{
            Painel::alert("error",'Imagem inválida!');
          }
        }else{
          Painel::alert("error","Slider já existe.");
        }
      }else{
        Painel::alert("error",'Nome precisa ser preenchido!');
      }
    }else{
      Painel::alert("error",'É preciso selecionar uma imagem!');
    }

  }

  //editar slides
  if(isset($_POST['slide-editar'])){
    if(isset($_GET['slideid'])){
      $id = $_GET['slideid'];
      $nome = $_POST['nome'];
      $img = $_FILES['imagem'];

      if($nome != ''){
        $sql = MySql::conectar()->prepare("UPDATE `tb_site.slides` SET imagem = ?, nome = ? WHERE id = ?");
        if($img['name'] != ''){
          if(Painel::imagemValida($img)['status']){
            $pegarImg = MySql::conectar()->prepare("SELECT imagem FROM `tb_site.slides` WHERE id = ?");
            if($pegarImg->execute(array($id))){
              $nomeImg = $pegarImg->fetch();
              Painel::deleteFile($nomeImg['imagem']);
              $imagem_atual = Painel::uploadFile($img);
              if($sql->execute(array($imagem_atual,$nome,$id))){
                Painel::alert("sucesso","Atualizado com sucesso!");
              }else{
                Painel::alert("error","Algo deu errado.");
              }
            }else{
              Painel::alert("error","Algo deu errado.");
            }
          }else{
            Painel::alert("error","Formato de inválido.");
          }
        }else{
          $sql = MySql::conectar()->prepare("UPDATE `tb_site.slides` SET nome = ? WHERE id = ?");
          if($sql->execute(array($nome,$id))){
            Painel::alert("sucesso","Nome foi alterado com sucesso!");
          }else{
            Painel::alert("error","Algo deu errado.");
          }
        }
      }else{
        $sql = MySql::conectar()->prepare("UPDATE `tb_site.slides` SET imagem = ? WHERE id = ?");
        if($img != ''){
          if(Painel::imagemValida($img)['status']){
            $pegarImg = MySql::conectar()->prepare("SELECT imagem FROM `tb_site.slides` WHERE id = ?");
            if($pegarImg->execute(array($id))){
              $nomeImg = $pegarImg->fetch();
              Painel::deleteFile($nomeImg['imagem']);
              $imagem_atual = Painel::uploadFile($img);
              if($sql->execute(array($imagem_atual,$id))){
                Painel::alert("sucesso","Atualizado com sucesso!");
              }else{
                Painel::alert("error","Algo deu errado.");
              }
            }else{
              Painel::alert("error","Algo deu errado.");
            }
          }else{
            Painel::alert("error","Formato de inválido.");
          }
        }else{
          Painel::alert("sucesso","Nome foi alterado com sucesso!");
        }
      }
    }else{
      Painel::alert("error","É preciso selecionar um ID.");
    }
  }

  //deletar slides
  if(isset($_POST['slide-deletar'])){
    $nome = $_POST['nome'];
    if($nomeExiste = Painel::select('tb_site.slides','nome = ?',array($nome))){
      $sql = MySql::conectar()->prepare("DELETE FROM `tb_site.slides` WHERE nome = ?");
      $pegarImg = MySql::conectar()->prepare("SELECT imagem FROM `tb_site.slides` WHERE nome = ? ");
      $pegarImg->execute(array($nome));
      $valor = $pegarImg->fetch();
      Painel::deleteFile($valor['imagem']);
      if($sql->execute(array($nomeExiste['nome']))){
        Painel::alert("sucesso","Slider ".$nomeExiste['nome'].' foi deletado com sucesso!');
      }else{
        Painel::alert("error","Algo deu errado.");
      }
    }else{
      Painel::alert("error","Slider não encontrado.");
    }
  }



?>
  <h2 style='margin-top: 40px; background-color: #f7984a; color: #fff;padding: 10px 2%;'>Sessão: Moderador</h2><!--title sessão-->

  <!--DEPOIMENTOS  -->
  <h2 class='titulo-session' style='margin-top: 40px;'>Depoimentos:</h2>
  <div class="flex">
    <div class="box-content cargo-1 w50 mr-2">
      <h2 class='title'>Inserir Depoimento <i style="font-size: 22px;" class="fa-regular fa-file-lines"></i></h2>

      <form method='post' class='form-dep'>
        <input type="text" name='nome' placeholder='Nome:' required>
        <textarea name="depoimento" id="" cols="30" rows="10"  placeholder='Depoimento:' required></textarea>
        <input type="submit" name='inserirdep' value='Inserir'>
      </form>
    </div><!--box-content-->

    <div class="box-content cargo-1 w50 ml-2">
      <h2 class='title'>Editar Depoimento <i style='font-size: 22px' class="fa-regular fa-pen-to-square"></i></h2>
      <form method='post' class='form-dep'>
        <input type="text" name='nome' placeholder='Alterar nome:'>
        <textarea name="depoimento" cols="30" rows="10" placeholder='Alterar depoimento: '></textarea>
        <input type="submit" name='editar-dep' value='Editar'>
      </form>
    </div><!--box-content-->

    
  </div><!--flex-->

  <div class="flex">
    <div class="box-content cargo-1 w50S mr-2">
        <h2 class='title'>Excluir depoimento <i style="font-size: 22px;" class="fa-solid fa-trash"></i></h2>

        <form method='post' class='form-dep'>
          <input type="text" name='nome' placeholder='Nome:' required>
          <input type="submit" name='deletdep' value='Excluir'>
        </form>
      </div><!--box-content-->

  </div><!--flex-->

  <!-- SERVICOS -->
  <h2 style='margin-top: 40px;' class='titulo-session'>Serviços: </h2>
  <div class="flex">
    <div class="box-content cargo-1 w50 mr-2">
        <h2 class='title'>Insirir serviços: <i style='font-size: 22px'  class="fa-solid fa-briefcase"></i></h2>
        <form method='post' class='form-dep'>
          <input type="text" name='title' placeholder='Titulo:' required>
          <textarea name="servico" cols="30" rows="10" placeholder='Seriço: '></textarea required>
          <input type="submit" name='inserirservicos' value='Inserir'>
        </form>
      </div><!--box-content-->

      <div class="box-content cargo-1 w50 ml-2">
        <h2 class='title'>Editar serviços: <i style='font-size: 22px'   class="fa-solid fa-pencil"></i></h2>
        <form method='post' class='form-dep'>
          <input type="text" name='title' placeholder='Alterar titulo:'>
          <textarea name="servico" cols="30" rows="10" placeholder='Alterar servico: '></textarea>
          <input type="submit" name='editar-servico' value='Editar'>
        </form>
      </div><!--box-content-->
  </div>

  <div class="flex">

    <div class="box-content cargo-1 w50S mr-2">
      <h2 class='title'>Excluir serviço: <i style='font-size: 22px' class="fa-solid fa-trash"></i></h2>
      <form method='post' class='form-dep'>
        <input type="text" name='title' placeholder='Titulo:' required>
        <input type="submit" name='deletar-servico' value='Excluir'>
      </form>
    </div><!--box-content-->
  </div><!--flex-->

  <!-- SLIDES -->
  <h2 style='margin-top: 40px;' class='titulo-session'>Slides: </h2>

  <div class="flex">
    <div class="box-content cargo-1 w50 mr-2">
      <h2 class='title'>Adicionar slide: <i style='font-size: 22px' class="fa-solid fa-panorama"></i></h2>
      <label >é recomendado dimensão de 16:9 = 1920x1080</label>
      <form method='post' class='form-dep' enctype="multipart/form-data">
        <input type="text" name='nome' placeholder='Nome do slide: ' required>
        <input type="file" name='imagem' required>
        <input type="submit" name='slide-inserir' value='Inserir'>
      </form>
    </div><!--box-content-->

    <div class="box-content cargo-1 w50 ml-2">
      <h2 class='title'>Editar slide: <i style='font-size: 22px' class="fa-regular fa-images"></i></h2>
      <form method='post' class='form-dep' enctype="multipart/form-data">
        <input type="text" name='nome' placeholder='Nome do slide: '>
        <input type="file" name='imagem'>
        <input type="submit" name='slide-editar' value='Editar'>
      </form>
    </div><!--box-content-->
  </div><!--flex-->

  <div class="flex">
    <div class="box-content cargo-1 w50S mr-2">
      <h2 class='title'>Deletar slide: <i style='font-size: 22px' class="fa-solid fa-trash"></i></h2>
      <form method='post' class='form-dep' enctype="multipart/form-data">
        <input type="text" name='nome' placeholder='Nome do slide: ' required>
        <input type="submit" name='slide-deletar' value='Deletar'>
      </form>
    </div><!--box-content-->
  </div><!--flex-->


<?php
} 
if($_SESSION['cargo'] >= 0){ //Usuário normal
?>
<div class="flex">
<div class="box-content w50S mr-2">
  <h2 class='title'>Editar cadastro <i class="fa-solid fa-pen"></i> :</h2>
  <form method='post' enctype='multipart/form-data' class='atualizar__form'>

    <?php
      if(isset($_POST['acao'])){
        //enviado
        
        $nome = $_POST['nome'];
        $user = $_POST['user'];
        $senha = $_POST['password'];
        $img = $_FILES['imagem'];
        $usuarioAtual = $_SESSION['user'];
        $imagem_atual = $_POST['imagem_atual'];

        if($senha != '' && $senha != $_SESSION['password'] ){
          if(preg_match('/^(?=.*\d)(?=.*[^\w\s]).{8,}$/',$senha)){
            if(Usuario::userCadastrado($user)){
              //usuário não cadastrado.
              if($img['name'] != ''){
                //selecionada img
                if(Painel::imagemValida($img)['status']){
                  $img['name'] = Painel::imagemValida($img)['nome'];
                  
                  Painel::deleteFile($imagem_atual);
                  $img = Painel::uploadFile($img);
                  if(Usuario::atualizarUsuario($nome,$user,$senha,$img)){
                    //sucesso!
                    $_SESSION['img'] = $img;
                    $_SESSION['nome'] = $nome;
                    $_SESSION['user'] = $user;
                    $_SESSION['password'] = $senha;
                    Painel::alert('sucesso','Atualizado com sucesso!');
                  }else{
                    //erro :(
                    Painel::alert('error','Não foi possível atualizar.');
                  }
                }else{
                  Painel::alert('error','Formato não é valido.');
                }
      
              }else{
                //não foi selecionado img
                $img = $imagem_atual;
                if(Usuario::atualizarUsuario($nome,$user,$senha,$img)){
                  //sucesso!
                  $_SESSION['img'] = $img;
                  $_SESSION['nome'] = $nome;
                  $_SESSION['user'] = $user;
                  $_SESSION['password'] = $senha;
                  Painel::alert('sucesso','Atualizado com sucesso!');
                }else{
                  //erro :(
                  Painel::alert('error','Não foi possível atualizar');
                }
              }
            }else{
              //verificar se é o seu / se não foi alterado.
              if($usuarioAtual == $user){
                //tudo certo não foi alterado
                if($img['name'] != ''){
                  //selecionada img
                  if(Painel::imagemValida($img)['status']){
                    $img['name'] = Painel::imagemValida($img)['nome'];
                    
                    Painel::deleteFile($imagem_atual);
                    $img = Painel::uploadFile($img);
                    if(Usuario::atualizarUsuario($nome,$user,$senha,$img)){
                      //sucesso!
                      $_SESSION['img'] = $img;
                      $_SESSION['nome'] = $nome;
                      $_SESSION['user'] = $user;
                      $_SESSION['password'] = $senha;
                      Painel::alert('sucesso','Atualizado com sucesso!');
                    }else{
                      //erro :(
                      Painel::alert('error','Não foi possível atualizar.');
                    }
                  }else{
                    Painel::alert('error','Formato não é valido.');
                  }
        
                }else{
                  //não foi selecionado img
                  $img = $imagem_atual;
                  if(Usuario::atualizarUsuario($nome,$user,$senha,$img)){
                    //sucesso!
                    $_SESSION['img'] = $img;
                    $_SESSION['nome'] = $nome;
                    $_SESSION['user'] = $user;
                    $_SESSION['password'] = $senha;
                    Painel::alert('sucesso','Atualizado com sucesso!');
                  }else{
                    //erro :(
                    Painel::alert('error','Não foi possível atualizar');
                  }
                }
              }else{
                //usuário não disponivel
                Painel::alert("error",'Usuário não disponível');
              }
            }
          }else{
            Painel::alert("error",'Formato de senha inválido.');
          }
        }else{
          //continua a mesma
          if(Usuario::userCadastrado($user)){
            //usuário não cadastrado.
            if($img['name'] != ''){
              //selecionada img
              if(Painel::imagemValida($img)['status']){
                $img['name'] = Painel::imagemValida($img)['nome'];
                
                Painel::deleteFile($imagem_atual);
                $img = Painel::uploadFile($img);
                if(Usuario::atualizarUsuario($nome,$user,$senha,$img)){
                  //sucesso!
                  $_SESSION['img'] = $img;
                  $_SESSION['nome'] = $nome;
                  $_SESSION['user'] = $user;
                  $_SESSION['password'] = $senha;
                  Painel::alert('sucesso','Atualizado com sucesso!');
                }else{
                  //erro :(
                  Painel::alert('error','Não foi possível atualizar.');
                }
              }else{
                Painel::alert('error','Formato não é valido.');
              }
    
            }else{
              //não foi selecionado img
              $img = $imagem_atual;
              if(Usuario::atualizarUsuario($nome,$user,$senha,$img)){
                //sucesso!
                $_SESSION['img'] = $img;
                $_SESSION['nome'] = $nome;
                $_SESSION['user'] = $user;
                $_SESSION['password'] = $senha;
                Painel::alert('sucesso','Atualizado com sucesso!');
              }else{
                //erro :(
                Painel::alert('error','Não foi possível atualizar');
              }
            }
          }else{
            //verificar se é o seu / se não foi alterado.
            if($usuarioAtual == $user){
              //tudo certo não foi alterado
              if($img['name'] != ''){
                //selecionada img
                if(Painel::imagemValida($img)['status']){
                  $img['name'] = Painel::imagemValida($img)['nome'];
                  
                  Painel::deleteFile($imagem_atual);
                  $img = Painel::uploadFile($img);
                  if(Usuario::atualizarUsuario($nome,$user,$senha,$img)){
                    //sucesso!
                    $_SESSION['img'] = $img;
                    $_SESSION['nome'] = $nome;
                    $_SESSION['user'] = $user;
                    $_SESSION['password'] = $senha;
                    Painel::alert('sucesso','Atualizado com sucesso!');
                  }else{
                    //erro :(
                    Painel::alert('error','Não foi possível atualizar.');
                  }
                }else{
                  Painel::alert('error','Formato não é valido.');
                }
      
              }else{
                //não foi selecionado img
                Painel::alert("alert","Nada foi alterado!");
              }
            }else{
              //usuário não disponivel
              Painel::alert("error",'Usuário não disponível');
            }
          }


        }
      }

    
    ?>


    <div class="form-group">
      <label>Nome: </label>
      <input type="text" name='nome' value='<?php echo $_SESSION['nome']?>' required>
    </div><!--form-group-->
    <div class="form-group">
      <label>Usuário: </label>
      <input style='text-transform: lowercase;' type="text" name='user' value="<?php echo $_SESSION['user']?>" required>
    </div><!--form-group-->
    <div class="form-group">
      <label>Senha: </label>
      <input type="password" name='password' value="<?php echo $_SESSION['password']?>" required>
    </div><!--form-group-->
    <div class="form-group">
      <label>Foto: </label>
      <input type="file" name='imagem'>
      <input type="hidden" name='imagem_atual' value='<?php echo $_SESSION['img']?>'>
    </div><!--form-group-->
    <div class="form-group">
      <input type="submit" name='acao' value='atualizar'>
    </div><!--form-group-->
  </form>

</div><!--box-content-->

</div><!--flex-->
<?php
}
?>




<script>
$(function(){

    changeSelected()
    function changeSelected(){
        var icons = $('.menu nav a');
        icons.removeClass('selected');
        $('.menu nav li:last-child a').addClass("selected");
    }
});

const ctx = document.getElementById('myChart');
  Chart.defaults.color = '#fff';
  Chart.defaults.borderColor = '#36A2EB';
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Usuários cadastrados: <?php echo $_SESSION['cadastrado']?>', 'Total de Visitas: <?php echo $_SESSION['visitaTotal']; ?>'],
      datasets: [{
        label: 'Dados',
        data: [<?php echo $_SESSION['cadastrado']?>,<?php echo $_SESSION['visitaTotal']; ?>],
        borderWidth: 5,
        borderColor: '#8ecae6',
        backgroundColor: '#219ebc',
      }],
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    font: {
                        size: 14, //tamanho do titulo
                    },
                },
            },
        },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            fontSize: 20 // Define o tamanho da fonte das etiquetas
          }
        },
        x: {
          ticks: {
            fontSize: 22 // Define o tamanho da fonte das etiquetas no eixo X
          }
        },
      }
      
    }
});

</script>