<?php
/*
Plugin Name: Reverse Proxy
Description: Tool for loading external urls as though it originated from the current site.
Version: 1.0
Author: Vgrinchik
*/
?>

<?php

    if (!@include_once __DIR__ . '/plg/plg.php') {
        die('Could not load plg to register custom page url in wp');
    }

    if (!@include_once __DIR__ . '/php5rp/ProxyHandler.class.php') {
        die('Could not load proxy');
    }

    if (!@include_once __DIR__ . '/simplehtmldom_1_5/simple_html_dom.php') {
        die('Could not load php html parser');
    }


    if ( is_admin() ){ 
        // add menu item in admin
        add_action( 'admin_menu', 'add_admin_menu' );
        // register variables
        add_action( 'admin_init', 'register_mysettings' );
    } 


    function add_admin_menu() {
        add_options_page( 'My Plugin Options', 'Reverse proxy options', 'manage_options', 'reverse-proxy', 'my_plugin_options' );
    }

    function register_mysettings() { 
      register_setting( 'reverse-proxy-group', 'external_site' );
      register_setting( 'reverse-proxy-group', 'external_site_name' );
      register_setting( 'reverse-proxy-group', 'use_pretty_permalinks' );

    }

    function my_plugin_options() {
        ?>
            <div class="wrap">
            <h2>Reverse proxy options</h2>
            <form method="post" action="options.php">
                <?php settings_fields( 'reverse-proxy-group' ); ?>
                <?php do_settings_sections( 'reverse-proxy-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row">External site</th>
                    <td><input type="text" style="width:400px" name="external_site" value="<?php echo esc_attr( get_option('external_site') ); ?>" /></td>
                    </tr> 
                    <tr valign="top">
                    <th scope="row">Link name</th>
                    <td><input type="text" style="width:400px" name="external_site_name" value="<?php echo esc_attr( get_option('external_site_name') ); ?>" /></td>
                    </tr>      
                    <tr>
                        <th>Use pretty permalink</th>
                        <td><input type="checkbox" name="use_pretty_permalinks" value="1" <?= checked( 1, esc_attr( get_option('use_pretty_permalinks')), false ) ?>></td>
                    </tr>    
                </table>
                
                <?php submit_button(); ?>

            </form>
            </div>
        <? 
    }



    //     ************* TEMPLATE TAGS ***************    //

    function external_site_link()
    {
        $reverse_proxy = new Reverse_Proxy();
        echo $reverse_proxy->getExternalSiteLink();
    }

    function loadPage()
    {
        $reverse_proxy = new Reverse_Proxy();
        $reverse_proxy->doReverseProxy();         
    }

    ////////////////////////////////////////////////////////


    $plg = new PLG();  // register additional page in wp rewrite sistem to show external pages there
    define(REVERSING_MARK,'reverse');






    class Reverse_Proxy{

        private $external_site;
        private $external_site_link_name;
        private $current_site_url;

        public function __construct()
        {
            $this->current_site_url  = site_url();
            $this->external_site = trim( get_option('external_site' ), '/' );
            $this->external_site_link_name = get_option('external_site_name');
            $this->use_pretty_permalinks = get_option('use_pretty_permalinks');

            if ( empty( $this->external_site ) ){   
                echo 'You should set external site url <a href="'.admin_url('admin.php?page=reverse-proxy').'" >in the plugin settings page</a>';
                die;
            }  

        }

        public function getExternalSiteLink(){
            return '<a href="' . $this->reverseLink( $this->external_site)  . '">'.$this->external_site_link_name.'</a>';
        }


        public function doReverseProxy(){
            $proxy = new ProxyHandler( array(
                'requestUri' => $this->external_site . $this->getReversedUrl(),
                'bufferedContentTypes' => array()
            ));
            $proxy->setCurlOption(CURLOPT_RETURNTRANSFER, 1);

            $res = $proxy->execute();

            if (  $res){
                
                $this->prepareResult( $res  );

            } else {
                echo $proxy->getCurlError();
            }

            $proxy->close();
        }


        public function reverseLink( $external_url )
        {
            if ( strpos($external_url, $this->external_site) !==  false ) {
                return $this->replaseAllUrls($external_url);
            } else {
                return $external_url;
            }
        }


        public function replaseAllUrls( $string )
        {
            return str_replace( $this->external_site, $this->current_site_url . '/'.$this->reversingMarkStr() , $string );
        }

        /*****************************************************/
        private function reversingMarkStr(){
            return $this->use_pretty_permalinks ? REVERSING_MARK : '?' . REVERSING_MARK . '=';
        }



        private function getReversedUrl()
        {
            $regExp = $this->use_pretty_permalinks ? REVERSING_MARK : '\?' . REVERSING_MARK . '\=';
            preg_match('/'.$regExp.'(.*)/',$_SERVER['REQUEST_URI'], $match); 

            return $match[1];
        }

        private function prepareResult( $res ) {

            $html = str_get_html($res);

            foreach($html->find('a') as $a) {
               $a->href = $this->reverseLink( $a->href );
            }
            foreach($html->find('form') as $a) {
               $a->action = $this->reverseLink( $a->action );
            }
            foreach($html->find('link') as $a) {
               $a->href = $this->reverseLink( $a->href );
            }
            foreach($html->find('script') as $a) {
               $a->src = $this->reverseLink( $a->src );
            }
            foreach($html->find('[onclick]') as $a) {
                $a->onclick = $this->replaseAllUrls($a->onclick);
            }

            echo $html;
        }


    }


