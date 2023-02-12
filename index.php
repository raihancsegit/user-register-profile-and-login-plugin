<?php 
/**
 * @wordpress-plugin
 * Plugin Name:       New Plugin
 * Plugin URI:        newplugin.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Raihan Islam
 * Author URI:        raihan.website
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       new-plugin
 * Domain Path:       /languages
 */

 add_shortcode( 'my_posts', 'my_posts_func' );
 function my_posts_func(){

    $arg = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'meta_key' => 'views',
         
    );

    $query = new WP_Query($arg);
    ob_start();
    if($query->have_posts()):
        ?>
<ul>
    <?php
   global $post;
    while($query->have_posts()){
        $query->the_post();
        echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a>('.get_post_meta($post->ID,'views',true).')</li>';
    }
    ?>
</ul>
<?php
    endif;
    $html = ob_get_clean();

    return $html;
 }
 function head_func(){
    if(is_single()){
        global $post;


        $views = get_post_meta($post->ID,'views',true);
        if($views == ''){
            add_post_meta($post->ID,'views',1);
        }else {
            $views++;
            update_post_meta($post->ID,'views',$views);
        }

        echo "Views:".get_post_meta($post->ID,'views',true);
    }
 }
 add_action('wp_head','head_func');


 add_shortcode('custom-register', 'custom_register_form' );
 function custom_register_form(){
    ob_start();
    include 'pub/register.php';
    $html = ob_get_clean();
    return $html;
 }

 add_shortcode('custom-login', 'custom_login_form' );
 function custom_login_form(){
    ob_start();
    include 'pub/login.php';
    $html = ob_get_clean();
    return $html;
 }

 function custom_profile(){
    ob_start();
    include 'pub/profile.php';
    $html2 = ob_get_clean();

    return $html2;
 }

 add_shortcode( 'custom-profile', 'custom_profile' );


 add_action('template_redirect','my_login');
 function my_login(){
    if(isset($_POST['user_login'])){
        $username = esc_sql( $_POST['username'] );
        $pass = esc_sql( $_POST['pass'] );

        $credentials = array(
                'user_login' =>  $username,
                'user_password' =>$pass,
        );
        $user = wp_signon( $credentials);

        if(!is_wp_error( $user )){
            if($user->roles[0] == 'adminstrator'){
                wp_redirect( admin_url() );
                exit;
            }
            else {
                wp_redirect( site_url('profile') );
            }
            
        }else {
            echo $user->get_error_message();
        }
    }
 }

function my_proile(){
    $is_user_logged_in = is_user_logged_in();
    if($is_user_logged_in && (is_page( 'login' ) || is_page( 'register' ))){
        wp_redirect( site_url('profile') );
        exit;
    }elseif(!$is_user_logged_in && is_page('profile')){
        wp_redirect( site_url('login') );
        exit;
    }
}
 add_action('template_redirect','my_proile');
 add_action('wp_logout','redirect_my_login');
 function redirect_my_login(){
    wp_redirect(site_url('login'));
    exit;
 }