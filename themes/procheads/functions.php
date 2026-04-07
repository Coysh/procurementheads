<?php
/**
 *  Procurement Heads Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package  Procurement Heads
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_PROCUREMENT_HEADS_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

    wp_enqueue_style( 'procurement-heads-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_PROCUREMENT_HEADS_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );




// add_action('acf/init', 'my_acf_init_block_types');
// function my_acf_init_block_types() {
// 
//     // Check function exists.
//     if( function_exists('acf_register_block_type') ) {
// 
//         // register a section card block.
//         acf_register_block_type(array(
//             'name'              => 'hubs',
//             'title'             => __('Hubs'),
//             'description'       => __('A custom section block for Procurement Heads.'),
//             'render_template'   => 'template-parts/blocks/hubs/hubs.php',
//             'category'          => 'formatting',
//             'icon'              => 'images-alt2',
//             'enqueue_assets'    => function(){
//                 wp_enqueue_style( 'flickity', 'https://unpkg.com/flickity@2.3.0/dist/flickity.min.css', array(), '2.3.0' );
//                 wp_enqueue_script( 'flickity', 'https://unpkg.com/flickity@2.3.0/dist/flickity.pkgd.min.js', array(), '2.3.0' );
//                 
//                 wp_enqueue_style( ' hubs', get_stylesheet_directory_uri() . '/template-parts/blocks/hubs/hubs.css', array(), '1.0.0' );
//                 wp_enqueue_script( ' hubs', get_stylesheet_directory_uri() . '/template-parts/blocks/hubs/hubs.js', array(), '1.0.0', true );
// 
//             },
//         ));
//         
//     }
// }





/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
// require_once( 'library/foundation.php' );

/** Register all navigation menus */
// require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
// require_once( 'library/menu-walkers.php' );

/** Create widget areas in sidebar and footer */
require_once( 'library/widget-areas.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
// require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Add ACF support - Options page */
require_once( 'library/acf.php' );

/** Gravity Forms mods */
// require_once( 'library/gravity-forms.php' );

/** Add Nav Options to Customer */
// require_once( 'library/custom-nav.php' );

/** Change WP's sticky post class */
// require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/images.php' );

/** Configure Jobs record type */
require_once( 'library/jobs.php' );

/** Configure Team record type */
require_once( 'library/team.php' );

/** Configure Event record type */
// require_once( 'library/events.php' );

/** Configure Feature record type */
require_once( 'library/sections.php' );


require_once( 'library/global-features.php' );
require_once( 'library/features.php' );

require_once( 'library/helpers.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/protocol-relative-theme-assets.php' );
// Show all Team members on the Team archive (no pagination)
add_action('pre_get_posts', function ($query) {
    // Only affect the front-end main query
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // Team archive page: /team/
    if ( $query->is_post_type_archive('team') ) {
        $query->set('posts_per_page', -1); // -1 = show all

        // Optional: respects Team → Re-order if used
        $query->set('orderby', 'menu_order');
        $query->set('order', 'ASC');
    }
});

/**
 * TEMPORARY PERFORMANCE DEBUGGER
 * Remove after diagnosis. View output in browser console or error log.
 * Access debug log at: yoursite.com/?ph_debug=1 (admin only)
 */
if ( defined('WP_DEBUG') && WP_DEBUG ) {

    // Start global timer as early as possible
    if ( ! defined('PH_DEBUG_START') ) {
        define('PH_DEBUG_START', microtime(true));
    }

    class PH_Performance_Debugger {

        private static $checkpoints = [];
        private static $query_log   = [];
        private static $start;

        public static function init() {
            self::$start = defined('PH_DEBUG_START') ? PH_DEBUG_START : microtime(true);

            // Hook checkpoints throughout WP lifecycle
            foreach ([
                'plugins_loaded'        => 5,
                'setup_theme'           => 5,
                'after_setup_theme'     => 5,
                'init'                  => 5,
                'wp_loaded'             => 5,
                'parse_request'         => 5,
                'send_headers'          => 5,
                'pre_get_posts'         => 999,
                'wp'                    => 5,
                'template_redirect'     => 5,
                'get_header'            => 5,
                'wp_head'               => 999,
                'loop_start'            => 5,
                'loop_end'              => 5,
                'get_footer'            => 5,
                'wp_footer'             => 999,
                'shutdown'              => 999,
            ] as $hook => $priority ) {
                add_action( $hook, function() use ( $hook ) {
                    self::checkpoint( $hook );
                }, $priority );
            }

            // Log slow DB queries (anything over 0.1s)
            add_filter( 'log_query_in_seconds', function() { return 0.1; } );

            if ( defined('SAVEQUERIES') && SAVEQUERIES ) {
                add_action( 'shutdown', [ __CLASS__, 'log_slow_queries' ], 999 );
            }

            // Output report
            add_action( 'shutdown', [ __CLASS__, 'output_report' ], 1000 );
        }

        public static function checkpoint( $label ) {
            self::$checkpoints[] = [
                'label'   => $label,
                'elapsed' => round( ( microtime(true) - self::$start ) * 1000, 2 ), // ms
                'memory'  => round( memory_get_usage(true) / 1024 / 1024, 2 ),      // MB
            ];
        }

        public static function log_slow_queries() {
            global $wpdb;
            if ( empty( $wpdb->queries ) ) return;

            foreach ( $wpdb->queries as $q ) {
                if ( $q[1] > 0.1 ) {
                    self::$query_log[] = [
                        'time' => round( $q[1] * 1000, 2 ) . 'ms',
                        'sql'  => substr( $q[0], 0, 300 ),
                        'caller' => $q[2],
                    ];
                }
            }
        }

        public static function output_report() {
            if ( ! is_user_logged_in() || ! current_user_can('manage_options') ) return;

            $total = round( ( microtime(true) - self::$start ) * 1000, 2 );

            // Calculate time between each checkpoint
            $prev = 0;
            $rows = '';
            foreach ( self::$checkpoints as $cp ) {
                $delta = round( $cp['elapsed'] - $prev, 2 );
                $flag  = $delta > 500 ? ' ⚠️ SLOW' : '';
                $rows .= sprintf(
                    "  [%8.2fms] (+%6.2fms) %-30s  %sMB%s\n",
                    $cp['elapsed'], $delta, $cp['label'], $cp['memory'], $flag
                );
                $prev = $cp['elapsed'];
            }

            $query_rows = '';
            foreach ( self::$query_log as $q ) {
                $query_rows .= sprintf( "  [%s] %s\n  Called by: %s\n\n", $q['time'], $q['sql'], $q['caller'] );
            }

            $report = "\n\n";
            $report .= "=== PH PERFORMANCE DEBUG REPORT ===\n";
            $report .= "Total execution: {$total}ms\n";
            $report .= "Peak memory: " . round( memory_get_peak_usage(true) / 1024 / 1024, 2 ) . "MB\n";
            $report .= "\n--- WP LIFECYCLE TIMINGS ---\n";
            $report .= $rows;

            if ( $query_rows ) {
                $report .= "\n--- SLOW QUERIES (>100ms) ---\n";
                $report .= $query_rows;
            } else {
                $report .= "\n--- SLOW QUERIES: none detected (add SAVEQUERIES to wp-config.php to enable) ---\n";
            }

            $report .= "====================================\n";

            // Output to browser console
            echo "<script>console.log(" . json_encode($report) . ");</script>";

            // Also write to error log
            error_log( $report );
        }
    }

    PH_Performance_Debugger::init();
}


add_filter('frm_load_css', '__return_false');
