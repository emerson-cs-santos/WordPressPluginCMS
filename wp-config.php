<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'plugin' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost:3307' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '<@Gv(qG#o6u`%38++s:8.M^pwPY/ieg)nd86~Uf|- .qPU&0UIT&_GFg{T!1@>2L' );
define( 'SECURE_AUTH_KEY',  'UA!-gA)=dI)HN^^{QZUh*d,c`:DrvWCOk0b&7i,eOGg>IJL|x:a<W1gKjz>D=b@?' );
define( 'LOGGED_IN_KEY',    'Fa7TH&T;XlA&p,{;wa0hUN@qO$a1n+ZYeube49N_?XlkLUve!=0*IpZ`6uV_,^`n' );
define( 'NONCE_KEY',        'P=#UKkp>/@#`(XlFNt}aVZeE}dtSfV9Qg]TqZ|d5S(P!82^uAj%wBnw,$QkV|#!W' );
define( 'AUTH_SALT',        'Bwt{{[&Kc$5GRIumB{aePb5bQEU6a+<fz:JMjnQU@*o>YHkQxe@M#2-$w$C/b-E_' );
define( 'SECURE_AUTH_SALT', 'a%$&:^H<`_>|!x/.f(uQ1V`|QIl%f45i`c%D(h*}@!9eR8)x},k&+4kmg>y}15?v' );
define( 'LOGGED_IN_SALT',   'B]C{m^dzBT.R<#l$DL>)/SkVt~b$@VFZxxPf_PU[l2MMQy^!Hfr#IZNqI!VENRJA' );
define( 'NONCE_SALT',       'O;D$u)W1!6q;ohDbS)L1.aJ!xVAr#e/]4Jv}f8&4N$jX[L787KUBTzSvT^XflRKj' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
