<?php
wp_enqueue_script('custom-js', get_template_directory_uri().'/js/custom-js.js');

// Add the Meta Box  
function add_custom_meta_box() {  
    add_meta_box(  
        'custom_meta_box', // $id  
        'Custom Meta Box', // $title   
        'show_custom_meta_box', // $callback  
        'post', // $page  
        'normal', // $context  
        'high'); // $priority  
}  
add_action('add_meta_boxes', 'add_custom_meta_box');  

// Field Array  
$prefix = 'custom_';  
$custom_meta_fields = array(
    array(  
        'name'  => 'Image',  
        'desc'  => 'A description for the field.',  
        'id'    => $prefix.'image',  
        'type'  => 'image'  
    )  
);


// The Callback  
function show_custom_meta_box() {  
global $custom_meta_fields, $post;  
// Use nonce for verification  
echo '';  

    // Begin the field table and loop  
    echo '';  
    foreach ($custom_meta_fields as $field) {  
        // get value of this field if it exists for this post  
        $meta = get_post_meta($post->ID, $field['id'], true);  
        // begin a table row with  
        echo ' 
                '.$field['label'].' 
                ';  
                switch($field['type']) {  
                    // case items will go here 
                        // image  
                        case 'image':  
                            $image = get_template_directory_uri().'/images/image.png';    
                            echo ''.$image.'';  
                            if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }                 
                            echo    ' 
                                        
 
                                             
                                             Remove Image 
                                            '.$field['desc'].'';  
                        break;  
                } //end switch  
        echo '';  
    } // end foreach  
    echo ''; // end table  
}

// Save the Data  
function save_custom_meta($post_id) {  
    global $custom_meta_fields;  

    // verify nonce  
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))   
        return $post_id;  
    // check autosave  
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)  
        return $post_id;  
    // check permissions  
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can('edit_page', $post_id))  
            return $post_id;  
        } elseif (!current_user_can('edit_post', $post_id)) {  
            return $post_id;  
    }  

    // loop through fields and save the data  
    foreach ($custom_meta_fields as $field) {  
        $old = get_post_meta($post_id, $field['id'], true);  
        $new = $_POST[$field['id']];  
        if ($new && $new != $old) {  
            update_post_meta($post_id, $field['id'], $new);  
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id, $field['id'], $old);  
        }  
    } // end foreach  
}  
add_action('save_post', 'save_custom_meta');
