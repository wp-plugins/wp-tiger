<?php
/**
 * User: smackcoder
 * Date: 18/07/13
 * WP Tiger init class.
 */

class SmackWPVT {

    /*
     * Function to initialize this plugin
     */
    public static function init() {
        add_action ( 'admin_enqueue_scripts', 'LoadWpTigerScript' );
        add_action ( 'admin_menu', 'wptigermenu' );
        add_action ( 'user_register', 'wp_tiger_capture_registering_users' );
        add_action ( 'after_plugin_row_wp-tiger/wp-tiger.php', array('SmackWPVT', 'plugin_row') );
        add_filter ( 'plugin_action_links_wp-tiger/wp-tiger.php', array('SmackWPVT', 'plugin_settings_link'),10,2);
    }

    /*
     * Function to get the settings link
     * @$links string URL for the link
     * @$file string filename for the link
     * @return string html links
     */
    public static function plugin_settings_link( $links, $file ) {

        array_unshift($links, '<a href="' . admin_url("admin.php") . '?page=wp-tiger">' . __( 'Settings', 'wp-tiger' ) . '</a>');

        return $links;
    }

    /*
     * Function to get the plugin row
     * @$plugin_name as string
     */
    public static function plugin_row($plugin_name){
        echo '</tr><tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message"> Now get 25% discount for purchasing pro version using the coupon "<b>OFF25WPTIGER</b>" <a href="http://www.smackcoders.com/wp-vtiger-pro.html">Purchase pro version now!</a></div></td>';
    }

}
