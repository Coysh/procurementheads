<?php
/*
Plugin Name: Heads Group - JobAdder Integration for procurementheads.com
Description: Parses JobAdder xml to populate appointment fields.
Author: Created By Arc
Author URI: https://createdbyarc.com

Version: 0.1
*/

//creates a basic page for the xml data to be posted to 
function hrheads_createPage(){
    
    $check_page_exist = get_page_by_title('JobAdder : Import - DO NOT DELETE', 'OBJECT', 'page');
    // Check if the page already exists
    if(empty($check_page_exist)) {
        $page_id = wp_insert_post(
            array(
            'comment_status' => 'close',
            'ping_status'    => 'close',
            'post_author'    => 1,
            'post_title'     => 'JobAdder : Import - DO NOT DELETE',
            'post_name'      => 'jobadder-import',
            'post_status'    => 'publish',
            'post_content'   => '',
            'post_type'      => 'page',
            
            )
        );
    }

}
register_activation_hook(__FILE__, 'hrheads_createPage');

//add taxonomy
function hrheads_taxonomies() {

    //register assignment categories taxonomy
    $args = array(
        'hierarchical'  => true,
        'has_archive'   =>  false,
        'query_var'     => 'assignment-category',
        'rewrite'       => array(
            'slug'      => 'assignment/category'
        ),
        'labels'            => array(
            'name'          => 'Assignment Categories',
            'singular_name' => 'Assignment Category',
            'edit_item'     => 'Edit Assignment Category',
            'update_item'   => 'Update Assignment Category',
            'add_new_item'  => 'Add Assignment Category',
            'new_item_name' => 'Add New Assignment Category',
            'all_items'     => 'All Assignment Category',
            'search_items'  => 'Search Assignment Category',
            'popular_items' => 'Popular Assignment Category',
            'separate_items_with_commas' => 'Separate Assignment Categories with Commas',
            'add_or_remove_items' => 'Add or Remove Assignment Categories',
            'choose_from_most_used' => 'Choose from most used categories',
        ),
        'show_admin_column' => true
    );

    flush_rewrite_rules();
    register_taxonomy( 'assignment_category', 'jobs', $args );  

    //register location taxonomy
    $args = array(
        'hierarchical'  => true,
        'has_archive'   =>  false,
        'query_var'     => 'assignment-location',
        'rewrite'       => array(
            'slug'      => 'assignment/location'
        ),
        'labels'            => array(
            'name'          => 'Assignment Locations',
            'singular_name' => 'Assignment Location',
            'edit_item'     => 'Edit Assignment Location',
            'update_item'   => 'Update Assignment Location',
            'add_new_item'  => 'Add Assignment Location',
            'new_item_name' => 'Add New Assignment Location',
            'all_items'     => 'All Assignment Location',
            'search_items'  => 'Search Assignment Location',
            'popular_items' => 'Popular Assignment Location',
            'separate_items_with_commas' => 'Separate Locations with Commas',
            'add_or_remove_items' => 'Add or Remove Assignment Locations',
            'choose_from_most_used' => 'Choose from most used locations',
        ),
        'show_admin_column' => true
    );

    flush_rewrite_rules();
    register_taxonomy( 'assignment_location', 'jobs', $args );      

    //register work type taxonomy
    $args = array(
        'hierarchical'  => true,
        'has_archive'   =>  false,
        'query_var'     => 'assignment-work-type',
        'rewrite'       => array(
            'slug'      => 'assignment/work-type'
        ),
        'labels'            => array(
            'name'          => 'Assignment Work Types',
            'singular_name' => 'Assignment Work Type',
            'edit_item'     => 'Edit Assignment Work Type',
            'update_item'   => 'Update Assignment Work Type',
            'add_new_item'  => 'Add Assignment Work Type',
            'new_item_name' => 'Add New Assignment Work Type',
            'all_items'     => 'All Assignment Work Type',
            'search_items'  => 'Search Assignment Work Type',
            'popular_items' => 'Popular Assignment Work Type',
            'separate_items_with_commas' => 'Separate Work Types with Commas',
            'add_or_remove_items' => 'Add or Remove Assignment Work Types',
            'choose_from_most_used' => 'Choose from most used Work Types',
        ),
        'show_admin_column' => true
    );

    flush_rewrite_rules();
    register_taxonomy( 'assignment_work_types', 'jobs', $args );          
    
}
//add_action( 'init', 'hrheads_taxonomies' );


function hrheads_parseXml(){

    global $wp;

    $current_slug = add_query_arg( array(), $wp->request );

    if($current_slug === 'jobadder-import'):

        //Make sure that this is a POST request.
        if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
            //If it isn't, send back a 405 Method Not Allowed header.
           header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
            exit;
        }
        hrheads_log(0, '-' . 'this is a POST request');

        //Get the raw POST data from PHP's input stream.
        //This raw data should contain XML.
        //Save it to the plugin directory.
        $postData = trim(file_get_contents('php://input'));
        $time = time();   
		$date = new DateTime();
		$date = $date->format("d-m-y");
        $filename = plugin_dir_path( __FILE__). 'xml/' . $date .'-'$time . '.jobadder.xml';
        //$filename = plugin_dir_path( __FILE__). 'xml/1622019611.jobadder.xml';
        $file = file_put_contents($filename, $postData);

        //get the file for parsing
        $postData = trim(file_get_contents($filename));
		exit;
        
        //Use internal errors for better error handling.
        libxml_use_internal_errors(true);

        //Parse the POST data as XML.
        $xml = simplexml_load_string($postData);

        
        //If the XML could not be parsed properly.
        if($xml === false) {
            //Send a 400 Bad Request error.
            header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request", true, 400);
            //Print out details about the error and kill the script.
            foreach(libxml_get_errors() as $xmlError) {
                hrheads_log(0, '-' . $xmlError->message);
            }
            exit;
        }

        //all good, start with the import     
        foreach($xml->Fields->Field as $field):

            if($field->attributes()->name == 'Category'):
                
                hrheads_log(0, '-----Doing Categories-----');

                foreach($field->Values->Value as $value):
                    
                    //Accounting, Admin, Advertising etc
                    $term_name = wp_strip_all_tags($value->attributes()->name);
       
                    $parent_term_id = term_exists($term_name);
                    if(!$parent_term_id):
                        $parent_term_id = wp_insert_term( $term_name, 'assignment_category',    array('slug' => sanitize_title($term_name)) ); 
                        hrheads_log(0, '-' . $term_name . ' : Not exists, created new term : ' . $parent_term_id['term_id']);   
                    else:  
                        hrheads_log(0, '-' . $term_name . ' : Exists, do nothing : '. $parent_term_id);                          
                    endif;

                    //get sub categories
                    foreach($value as $sub_value):
                                          
                        if($sub_value->attributes()->name == 'Sub Category'):

                            //get sub categories
                            foreach($sub_value->Values->Value as $sub_sub_value):
                                $child_term_name = wp_strip_all_tags($sub_sub_value->attributes()->name);

                                $child_term_id = term_exists($child_term_name);

                                if(!$child_term_id):
                                    $child_term_id = wp_insert_term( $child_term_name, 'assignment_category',    array('slug' => sanitize_title($child_term_name), 'parent' => $parent_term_id) );    
                                    hrheads_log(0, '--' . $child_term_name . ' : Not exists, created new child term : ' . $child_term_id['term_id'] . ' : parent=' . $parent_term_id);   
                                else:
                                    hrheads_log(0, '--' . $child_term_name . ' : Exists, do nothing : ' . $child_term_id);   
                                endif;

                            endforeach;
                        endif;   
                        
                    endforeach;  
                   
                endforeach;

            endif;
            
            if($field->attributes()->name == 'Location'):
                hrheads_log(0, '-----Doing Locations-----');
                foreach($field->Values->Value as $value):

                    $term_name = wp_strip_all_tags($value->attributes()->name);

                    $parent_term_id = term_exists($term_name, 'jobs_category');

                    if(!$parent_term_id):
                        $parent_term_id = wp_insert_term( $term_name, 'jobs_category',    array('parent' => 17, 'slug' => sanitize_title($term_name)) ); 
                        hrheads_log(0, '-' . $term_name . ' : Not exists, created new term : ' . $parent_term_id['term_id']);   
                    else:  
                        hrheads_log(0, '-' . $term_name . ' : Exists, do nothing : '. $parent_term_id);                          
                    endif;

                endforeach;
            endif;    
            
            if($field->attributes()->name == 'Work Type'):
                hrheads_log(0, '-----Doing Work Types-----');
                foreach($field->Values->Value as $value):

                    $term_name = wp_strip_all_tags($value->attributes()->name);
                    $parent_term_id = term_exists($term_name, 'jobs_category');

                    if(!$parent_term_id):
                        $parent_term_id = wp_insert_term( $term_name, 'jobs_category',    array('parent' => 26,'slug' => sanitize_title($term_name)) ); 
                        hrheads_log(0, '-' . $term_name . ' : Not exists, created new term : ' . $parent_term_id['term_id']);   
                    else:  
                        hrheads_log(0, '-' . $term_name . ' : Exists, do nothing : '. $parent_term_id);                          
                    endif;

                endforeach;
            endif;             
        endforeach;

        //do jobs
        hrheads_log(0, '-----Doing Jobs-----');
        
        //set all jobs to draft
        global $wpdb;

        $sql = "UPDATE wp_posts 
                SET post_status = 'draft' 
                WHERE post_type IN ('jobs')
                AND post_status = 'publish'";

        $wpdb->get_results($sql);


        foreach($xml->Job as $job):

            hrheads_log(0, '-' . $job->attributes()->jid);  
            
            $j['jid'] = (int) $job->attributes()->jid;           
            $j['title'] = (string) $job->Title;
            $j['description'] = (string) $job->Description;
            $j['summary'] = (string) $job->Summary;
            $j['reference'] = $job->attributes()->reference;
            $j['date_posted'] = $job->attributes()->datePosted;
            $j['date_updated'] = $job->attributes()->dateUpdated;
            $j['bullet_points'] = $job->BulletPoints->BulletPoint;
            $j['classifications'] = $job->Classifications;
            $j['apply_url'] = (string) $job->Apply->Url;
            $j['apply_email'] = $job->Apply->EmailTo;
            

            
            foreach($job->Fields->Field as $field):
                if($field->attributes()->name == 'Video'):
                    $j['video'] = (string) $field;
                endif;
                
                if($field->attributes()->name == 'Salary text'):
                    $j['salary'] = (string) $field;
                endif;                
            endforeach;               

            //build the classication array for this job
            hrheads_log(0, '-----Doing Classifications-----');  
            
            $assignment_categories = array();
            $assignment_locations = array();
            $assignment_work_types = array();

            foreach($j['classifications']->Classification as $classification):
                        
                if($classification->attributes()->name == 'Category'):
                    $term = get_term_by('name', $classification, 'jobs_category');
                    hrheads_log(0, '- Found term: -' . $term->name );  
                    if($term->term_id):
                        $assignment_categories[] = $term->term_id;
                    endif;
                endif;
                
                if($classification->attributes()->name == 'Sub Category'):
                    $term = get_term_by('name', (string) $classification, 'jobs_category');
                    if($term->term_id):
                        hrheads_log(0, '- Found term: -' . $term->name );  
                        $assignment_categories[] = $term->term_id;
                    endif;
                endif;   

                if($classification->attributes()->name == 'Location'):
                    $term = get_term_by('name', (string) $classification, 'jobs_category');
                    if($term->term_id):
                        hrheads_log(0, '- Found term: -' . $term->name );  
                        $assignment_locations[] = $term->term_id;
                    endif;                            
                endif;                                              
                
                if($classification->attributes()->name == 'Work Type'):
                    $term = get_term_by('name', (string) $classification, 'jobs_category');
                    if($term->term_id):
                        hrheads_log(0, '- Found term: -' . $term->name );  
                        $assignment_work_types[] = $term->term_id;
                    endif;                             
                endif;                         

            endforeach;
            
         
            
            //other values for this job
            $metaValues = array();
            
            //if($j['salary']->MinValue && $j['salary']->MaxValue):
            //    $metaValues['salary'] = (string) $j['salary']->MinValue . ' - ' . $j['salary']->MaxValue;
            //endif;

            if($j['salary']):
                $metaValues['custom_salary_display'] = (string) $j['salary'];
            endif;
            
            if($j['summary'] ):
                $metaValues['stand_first'] = $j['summary'];
            endif; 

            if($j['location'] ):
                $metaValues['location'] = $j['location'];
            endif;   

            if($j['jid'] ):
                $metaValues['jid'] = $j['jid'];
            endif; 

            if($j['video'] ):
                $metaValues['video'] = $j['video'];
            endif;  
            
            if($j['apply_url'] ):
                $metaValues['apply_url'] = $j['apply_url'];
            endif;             
            

            $user = get_user_by( 'email', $j['apply_email'] );

             //look up the assignment by jid
             $user_args = array(
                'post_type' => 'team',
                'posts_per_page' => 1,
                'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),			                
                'meta_query' => array(
                    array(
                        'key' => 'tm_email',
                        'value' => (string) $j['apply_email'],
                        'compare' => '='
                    )
                ),
            );
            $user_query = new WP_Query($user_args);           
            if($user_query->have_posts()):

                while($user_query->have_posts()):

                    //update the assignment fields
                    $user_query->the_post();
                    $user_id = get_the_ID();         
                                         
                endwhile;
                 
            endif;


            //if($j['choose_member'] ):
                $metaValues['choose_member'] = array($user_id);
            //endif; 

            
            //does this job exist or is it new?

            //look up the assignment by jid
            $assignment_args = array(
                'post_type' => 'jobs',
                'posts_per_page' => 1,
                'post_status' => array('publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit'),			                
                'meta_query' => array(
                    array(
                        'key' => 'jid',
                        'value' => (int) $j['jid'],
                        'type' => 'numeric',
                        'compare' => '='
                    )
                ),
            );
            $assignment_query = new WP_Query($assignment_args);

            if($assignment_query->have_posts()):
                
                // This assignment already exists
                hrheads_log(0, '-' . $j['title'] . ' : Exists, update assignemnt fields : ' . $j['jid']);  
                
                while($assignment_query->have_posts()):

                    //update the assignment fields
                    $assignment_query->the_post();
                    $assignment_post_id = get_the_ID();         
                    
                 
                 
                    $data = array(
                        'ID'            => $assignment_post_id,
                        'post_title'    => $j['title'],
                        'post_content'  => $j['description'],
                        'post_author'   => $user->ID,
                        'post_name'     => sanitize_title($j['title'] . '-' . $j['jid']),
                        'post_category' => array(1), //current
                        'post_status'   => 'publish',
                        'post_date'     => date( 'Y-m-d H:i:s', strtotime($j['date_posted'])),
                        'meta_input'    => $metaValues,
                    );
                    
                    if($j['description'] ):
                        $data['content'] = $j['description'];
                    endif;                     
                  
                    wp_set_post_terms($assignment_post_id, array_merge($assignment_locations, $assignment_work_types), 'jobs_category'); 

                    wp_update_post($data);
                                        
                endwhile;
                 
            else:
                // create new assignment
                hrheads_log(0, '-' . $j['title'] . ' : Not exists, created new Assignment : ' . $j['jid']);   

                $data = array(
                    'post_type'     => 'jobs',
                    'post_author'   => $user->ID,
                    'post_title'    => $j['title'],
                    'post_content'  => $j['description'],
                    'post_name'     => sanitize_title($j['title'] . '-' . $j['jid']),
                    'post_category' => array(1), //current
                    'post_status'   => 'publish',
                    'post_date'     => date( 'Y-m-d H:i:s', strtotime($j['date_posted'])),
                    'meta_input'    => $metaValues,
                );
                
                if($j['description'] ):
                    $data['content'] = $j['description'];
                endif;   

                $new_post_id = wp_insert_post($data);

                hrheads_log(0, '-' . $j['title'] . ' : created : ' . $new_post_id);   

                wp_set_post_terms($assignment_post_id, array_merge($assignment_locations, $assignment_work_types), 'jobs_category');                 

            endif;

        endforeach;

    endif;

    //cleanup
    hrheads_log(0, '-----Doing Cleanup-----');
    hrheads_cleanup('/xml/');
    hrheads_cleanup('/logs/');

  
}

add_action( 'wp', 'hrheads_parseXml' );

//just a little logging
function hrheads_log($type, $msg) {
	global $debug, $log_file_name;

    $debug = true;
    $logs_path = dirname(__FILE__) . '/logs/';  
    $log_file_name = $logs_path . 'log_'.date("Ymd").'.txt';    
	
    $log_entry = date("H:i:s") . ' - ' . $type . ' - ' . $msg;
    
    if ($debug) {
        //echo $log_entry . '<br>' . "\n";
    }
    
    $log_handle = fopen( $log_file_name, 'a+' );
    fwrite( $log_handle, $log_entry . "\n" );
    fclose( $log_handle );
}

function hrheads_cleanup($dir){
    $expire = strtotime('-7 DAYS');
    $path = dirname(__FILE__) . $dir;
    $files = glob($path . '*');
    
    foreach ($files as $file) {
    
        // Skip anything that is not a file
        if (!is_file($file)) {
            //hrheads_log(0, '- not a file - ' . $file); 
            continue;
        }
    
        // Skip any files that have not expired
        if (filemtime($file) > $expire) {
            //hrheads_log(0, '- not expired - ' . filemtime($file) .' > ' . $expire . ' > ' .$file); 
            continue;
        }
        
        hrheads_log(0, '- Deleted - ' . $file);   
        unlink($file);
    }  
}
