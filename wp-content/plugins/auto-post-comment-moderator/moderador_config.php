<?php 
    $path = "options-general.php?page=config-moderador-digitar";
    $url = admin_url($path);

    if ( $registroDeletado == 'sim' )
    {
        echo " <div id='message' class='wrap'>
                    <div id='message' class='updated notice is-dismissible'>
                        <p>Regra excluída com sucesso!</p>
                    </div>
                </div> ";
    }    
?>

<div class="wrap">
    
    <h1 class="wp-heading-inline">Moderador automático de comentários de Posts</h1>

    <a href="<?php echo $url ?>" class="page-title-action">Adicionar novo</a>

    <hr class="wp-header-end">

    <table class="wp-list-table widefat plugins" style="margin-top: 25px;">
        <thead>
            <tr>
                <td >
                </td>
                
                <th scope="col" id='name' class='manage-column column-name column-primary' style="font-weight: bold;">Texto</th>
                <th scope="col" class='manage-column column-description' style="font-weight: bold;">Substituição</th>
                <th scope="col" class='manage-column column-description' style="font-weight: bold;">Tipo</th>
                <th scope="col" colspan="2" class='manage-column column-description' style="font-weight: bold;">Ações</th>
            </tr>
        </thead>

        <tbody id="the-list">

                <!-- <th scope='row' class='check-column'></th> -->

                <?php  

                    foreach ($regras as $regra) 
                    {
                        $regraID = $regra->id;
                        $texto = $regra->texto;
                        $textoSub = $regra->textosub;
                        $tipo = $regra->tipo == 1 ? 'Esconder Texto' : 'Criar Link';

                        echo "
                            <tr>
                                <td class='plugin-title column-primary'> 
                                </td>                    
                                
                                <td>
                                    $texto
                                </td>
            
                                <td>
                                    $textoSub
                                </td>   
            
                                <td>
                                    $tipo
                                </td>                     
                                
                                <td>
                                    <form action='$url' method='post'>
                                        <input type='text' name='ID' hidden value='$regraID'> 
                                        <input type='submit' value='Alterar' class='page-title-action'>    
                                    </form>
                                </td>   
                                
                                <td>
                                    <form method='post' onsubmit='return excluirConfirmar()'>
                                        <input type='text' name='ID' hidden value='$regraID'> 
                                        <input type='submit' value='Excluir' class='page-title-action'>    
                                    </form>
                                </td> 
                            </tr>
                        ";
                    }
                ?>
        </tbody>
    </table>

    <script>
        function excluirConfirmar()
        {
            return confirm('Confirma exclusão?');
        }
    </script>

</div>    