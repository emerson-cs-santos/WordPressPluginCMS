<?php
/*
* Plugin Name: Moderador Comentário Post auto
* Plugin URI: https://github.com/emerson-cs-santos/WordPressPluginCMS
* Description: Moderação automática de comentários de posts. Com base em um cadastro de palavras, caso uma delas seja usada, uma ação será feita (esconder ou virar um link).
* Version: 1.0.0
* Author: Emerson Costa
* Author URI: https://github.com/emerson-cs-santos
* License: CC BY
*/

// Não permite acesso direto ao plugin, neste caso a constante abaixo não vai estar definida
if ( !defined( 'WPINC' ) )
{
    die;
}

class Moderador
{
    private $tableName = "";

    function __construct()
    {
        // Adicionar menu
        add_action( 'admin_menu', array( $this, 'gerar_item_menu' ) );   

        // Filtro do comentário, definindo a função de callback
        add_filter( 'pre_comment_content', array( $this, 'filter_pre_comment_content' ) );

        // Criar tabela de moderação
        register_activation_hook( __FILE__, array( $this, 'create_moderador_tabela' ) );

        // Deletar tabela de moderação
        register_deactivation_hook( __FILE__, array( $this, 'drop_moderador_tabela' ) );

        global $wpdb;
        $this->tableName = $wpdb->prefix . "MODERADOR_COMMENT";
    }

    // add_action
    function gerar_item_menu()
    {
        add_submenu_page(   'options-general.php'
                            , 'Moderador Comentário'
                            ,'Moderador Comentário'
                            ,'administrator'
                            ,'config-moderador-menu'
                            ,array( $this, 'abre_config_moderador_menu' )
                            ,1);
                            


        // Hidden page
        add_submenu_page(
            null, 
            'Moderador Comentário Digitar',
            'Moderador Comentário Digitar', 
            'administrator', 
            'config-moderador-digitar', 
            array( $this, 'comentario_digitar' )
        );

    }

    function abre_config_moderador_menu()
    {
        $tableName = $this->tableName;
        global $wpdb;

        $ID = 0;
        $registroDeletado = '';

        if ( isset( $_POST['ID'] ) )
        {
             $ID = $_POST['ID'];

             $wpdb->delete( $tableName, array( 'id' => $ID ) );

             $registroDeletado = 'sim';
        } 
        
        $regras = $wpdb->get_results(" SELECT * FROM $tableName ORDER BY ID DESC ");

        require 'moderador_config.php';
    } 
    
    function comentario_digitar () 
    {
        $tableName = $this->tableName;
        global $wpdb;
        $regras = [];
        $gravou = "";
        $ID = 0;
        $acao = 'Gerenciar regra';

        if ( isset( $_POST['ID'] ) )
        {
             $ID = $_POST['ID'];
        }        
        
       if ( isset( $_POST['texto'] ) and isset( $_POST['textoSub'] ) and isset( $_POST['tipo'] ) )
       {
            $texto      = $_POST['texto'];
            $textoSub   = $_POST['textoSub'];
            $tipo       = $_POST['tipo'];

            if ( !empty( $texto ) and !empty( $textoSub ) and !empty( $tipo ) )
            {
                if ( $tipo == 'texto' )
                {
                    $tipo = 1;
                }
    
                if ( $tipo == 'link' )
                {
                    $tipo = 2;
                }            
    
                // Incluir
                if ( $ID == 0 )
                {
                    $wpdb->insert($tableName, array(
                        "texto"     => $texto
                        ,"textoSub" => $textoSub
                        ,"tipo"     => $tipo
                     ));
                     
                    // Atribuir novo ID para ser carregado na tela
                    $ID = $wpdb->insert_id;
                    
                }
    
                // Alterar
                if ( $ID > 0 )
                {
                    $wpdb->update($tableName, array(
                        "texto"     => $texto
                        ,"textoSub" => $textoSub
                        ,"tipo"     => $tipo
                    ), array(
                        'id' => $ID
                    ));   
                    
                }            
    
                $gravou = "sim";
            }
            else
            {
                $gravou = "nao";
            }
       }

       if ( $ID == 0 )
       {
            $acao = 'Incluir nova Regra';
       }       
        
       if ( $ID > 0 )
       {
            $regras = $wpdb->get_results(" SELECT * FROM $tableName where id = " . $ID);
       }

        require 'comment_digitar.php';
    }    
    
    // add_filter
    function filter_pre_comment_content( $commentdata_comment_content ) 
    { 

        $tableName = $this->tableName;
        global $wpdb;  
        $regras = $wpdb->get_results(" SELECT * FROM $tableName");

        $comment = $commentdata_comment_content;

        foreach ($regras as $regra) 
        {
            $texto = $regra->texto;
            $textosub = $regra->textosub;
            $tipo = $regra->tipo;

            // Esconder texto
            if ( $tipo == 1 )
            {
                $comment = str_replace( $texto, $textosub, $comment );    
                
                $comment = strtr ( $comment, array ( $texto => $textosub) );

                $comment = strtr ( $comment, array ( strtoupper( $texto ) => $textosub) );
               
                // // Verifica com upper se texto foi utilizado no comentário
                // if ( strpos( strtoupper( $comment ) , strtoupper( $texto ) ) !== FALSE )
                // {
                //     $comment = strtr ( strtoupper($comment), array ( strtoupper( $texto ) => $textosub) ); 
                // }
            }


            // Criar Link
            if ( $tipo == 2 )
            {
                $link = "<a href='$textosub' target='_blank'>$texto</a>";
                $comment = str_replace( $texto, $link, $comment );

                $comment = strtr ( $comment, array ( $texto => $link) );

                $comment = strtr ( $comment, array ( strtoupper( $texto ) => $link) );
            }
         }        
    
        return $comment; 
    } 
    
    // register_activation
    function create_moderador_tabela()
    {
        $tableName = $this->tableName;
        
        global $wpdb;
    
        $Query = " CREATE TABLE IF NOT EXISTS $tableName 
                    ( 
                        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
                        ,texto VARCHAR(255) NOT NULL
                        ,textosub VARCHAR(255) NOT NULL
                        ,tipo TINYINT UNSIGNED NOT NULL  
                    ) ";
        
        // Legenda:
            // texto - Texto que vai ser monitorado, quando esse texto for detectado, a regra vai ser ativada.
            // textosub - Texto que vai substituir o texto procurado.
            // tipo
                // 1 = Trocar o texto encontrado no comentário, literalmente pelo texto cadastrado.
                // 2 = O texto cadastrado vai se tornar um link no comentário, esse link deve estar cadastrado no campo textosub
        
        $wpdb->query( $Query );
    }    

    function drop_moderador_tabela()
    {
        $tableName = $this->tableName;
        
        global $wpdb;
    
        $Query = " DROP TABLE IF EXISTS $tableName ";
        $wpdb->query( $Query );
    }  
}

new Moderador;



// add_action('comment_post', 'do_action_comment' );

// function do_action_comment() 
// {
//     // Tipo do comentário
//     // $comment_approved = 1: Aprovado
//     // $comment_approved = 0: Reprovado

//   //  var_dump( get_comment_text($comment_ID) );

//   global $wpdb;

//   $tableName = $wpdb->prefix . "comments";

//   // $comment =  $wpdb->get_results( " SELECT * FROM $tableName ORDER BY comment_ID DESC LIMIT 1 " );

// }

// add_action('comment_post', 'acaoPosComentarioPostado');

// function acaoPosComentarioPostado()
// {
//     echo 'TesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTesteTeste';
// }

// function wpse_89292_save_my_post( $content ) {
//     global $post;
//     if( isset($post) && get_post_type( $post->ID ) == 'post' ){
//       $content['post_content'] = "fgfgfgf";
//     }
//     return $content;
//   }
//   add_filter( 'wp_insert_post_data', 'wpse_89292_save_my_posts' );