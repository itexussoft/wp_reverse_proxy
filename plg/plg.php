<?
class PLG {

    static $plugin_path;

    public function __construct(){
        $this->plugin_path = plugin_dir_path(__FILE__);
        register_activation_hook( __FILE__, array( $this, 'flush' ) );
        add_filter( 'query_vars', array( $this, 'query_vars') );
        add_action( 'init', array( $this, 'init') );
        add_action( 'parse_request', array( $this, 'parse_request') );

    }

    public function flush(){
        $this->init();
        flush_rewrite_rules();
    }

    public function init(){

        add_rewrite_rule(
            'reverse/?([\W\w\&]*)$',
            'index.php?reverse=$matches[0]',
            'top'
        );
    }

    public function query_vars( $query_vars ){
        $query_vars[] = 'reverse';
        return $query_vars;
    }

    public function parse_request( &$wp ){
        if ( array_key_exists( 'reverse', $wp->query_vars ) ){
            include dirname($this->plugin_path) . '/template/reverse.php';
            exit();
        }
        return;
    }



}