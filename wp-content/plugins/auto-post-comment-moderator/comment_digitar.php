<?php
    // $ID = $_POST['ID'];
    // echo $ID ;

    $ID = 0;
    $texto = "";
    $textoSub = "";
    $tipoTexto = "";
    $tipoLink = "";

    foreach ($regras as $regra) 
    {
        $ID    =  $regra->id;
        $texto =  $regra->texto;
        $textoSub = $regra->textosub;
        $tipoTexto = $regra->tipo == 1 ? 'selected' : '';
        $tipoLink = $regra->tipo == 2 ? 'selected' : '';
    }

    if ( $gravou == 'sim' )
    {
        echo " <div id='message' class='wrap'>
                    <div id='message' class='updated notice is-dismissible'>
                        <p>Informações salvas com sucesso!</p>
                    </div>
                </div> ";
    }

    if ( $gravou == 'nao' )
    {
        echo " <div id='message' class='wrap'>
                    <div id='message' class='notice notice-error is-dismissible'>
                        <p>Preencha todos os Campos!</p>
                    </div>
                </div> ";
    }
?>

<div class="wrap">
    <h1> <?php echo $acao ?> </h1>

    <div id="help" hidden>
        <p> <kbd>Tipo "texto"</kbd> Vai trocar o texto monitorado pelo texto cadastrado como substituir.</p>    
        <p> <mark>Exemplo:</mark> Comentário = "Esse Post precisa de palavra" </p>
        <p>Se tiver uma regra cadastrada desta forma:</p>
        <p>Texto para monitorar = "palavra", Texto para substituir = "****" </p>
        <p>O comentário será gravado dessa forma:</p>
        <p>Comentário = "Esse Post precisa de *****"</p>

        <p> <kbd>Tipo "link"</kbd> Segue o mesmo funcionamento, com a diferença que o texto monitorado vai ser transformado em um link. Esse link/url precisa ser informado no campo "Texto para substituir".</p> 

        <p><kbd>Observação:</kbd> Maiusculos e minusculos não são considerados no mesmo cadastro, sendo precisar fazer mais regras se necessário.</p>
    </div>

    <button class="button button-primary" onclick="exibirHelp()" data-placement="top" data-toggle="tooltip" title="Ver instruções de uso."> Ajuda </button>

    <form id="myForm" method="post" onsubmit="return validarCampos()">

        <div hidden>
            <input class="regular-text code" type="text" name="ID" id='ID' value="<?php echo $ID ?>">        
        </div>    

        <table class="form-table" role="presentation">

            <tr>
                <th scope="row">
                    <label for="texto">Texto para monitorar</label>
                </th>
                <td>
                    <input name="texto" type="text" id="texto" required value="<?php echo $texto ?>" class="regular-text code" />
                </td>
            </tr>   
            
            <tr>
                <th scope="row">
                    <label for="textoSub">Texto para substituir</label>
                </th>
                <td>
                    <input name="textoSub" type="text" id="textoSub" required value="<?php echo $textoSub ?>" class="regular-text code" />
                </td>
            </tr>  
            
            <tr>
                <th scope="row">
                    <label for="tipo" data-placement="top" data-toggle="tooltip" title="texto = Substituir texto, link = Gerar um link com o texto cadastrado.">Tipo</label>
                </th>
                <td>
                    <select name="tipo" id='tipo' class='postform' data-placement="top" data-toggle="tooltip" title="texto = Substituir texto, link = Gerar um link com o texto cadastrado.">
                        <option  <?php echo $tipoTexto ?>   value="texto">Esconder Texto</option>
                        <option <?php echo $tipoLink ?>     value="link">Criar Link</option>
                    </select>
                </td>
            </tr>              

        </table>

        <!-- <div style="margin-top: 10px;">
            <label for="texto">Texto</label>
            <input type="text" name="texto" required value="<?php echo $texto ?>">        
        </div>

        <div style="margin-top: 10px;">
            <label for="textoSub">Texto Sub</label>
            <input type="text" name="textoSub" required value="<?php echo $textoSub ?>">        
        </div> -->

        <!-- <select name="tipo">
            <option  <?php echo $tipoTexto  ?>     value="texto">Esconder Texto</option>
            <option <?php echo $tipoLink  ?>  value="link">Criar Link</option>
        </select>         -->

        <?php
            submit_button();
        ?>
    </form>

    <?php
        $pathVoltar = "options-general.php?page=config-moderador-menu";
        $urlVoltar = admin_url($pathVoltar);
    ?>

    <form action="<?php echo $urlVoltar ?>" method="post">
        <p class="submit">
            <input type="submit" name="submitVoltar" id="submitVoltar" class="button button-primary" value="Voltar"  />
        </p>
    </form>

    <!-- <script>
      //  function myFunction() 
      //  {
            //document.getElementById("myForm").submit();
        // document.getElementById("message").hidden = false;
        // alert('Informações salvas com sucesso!');
            
     //   }

        // window.onbeforeunload = function(event)
        // {
        //     alert('teste');
        // };    

        // if ( window.history.replaceState ) {
        //     window.history.replaceState( null, null, window.location.href );
        // }    

    // window.onbeforeunload = function () {return false;}    
    </script>     -->

    <script>
        function exibirHelp() 
        {
            var div_hidden = document.getElementById('help');

            if (div_hidden.hidden == true)
            {
                div_hidden.hidden = false;
            }
            else
            {
                div_hidden.hidden = true;
            }
        }

        function validarCampos()
        {
            let retorno = true;

            const texto     = document.getElementById("texto").value;
            const textoSub  = document.getElementById("textoSub").value;
            const tipo      = document.getElementById("tipo").value;

            if ( texto == "" || textoSub == "" || tipo == "" )
            {
                retorno = false;
            }

            if ( !retorno )
            {
                alert('Preencha todos os campos!');
            }

            return retorno;

        }
    </script>

</div>