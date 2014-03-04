<?php 
/*
* This is a function to change the rewrite slug for the djgig custom post type.
* 
* For example, if you wanted to change the URLs from http://example.com/djgig/mydjgig/
* to http://example.com/shows/myshow/ use the function below.
* 
 */
?>

<?php

function add_custom_rewrite_rule() {

    // First, try to load up the rewrite rules. We do this just in case
    // the default permalink structure is being used.
    if( ($current_rules = get_option('rewrite_rules')) ) {

        // Next, iterate through each custom rule adding a new rule
        // that replaces 'djgig' with 'shows' and give it a higher
        // priority than the existing rule.
        foreach($current_rules as $key => $val) {
            if(strpos($key, 'djgig') !== false) {
                add_rewrite_rule(str_ireplace('djgig', 'shows', $key), $val, 'top');   
            } // end if
        } // end foreach

    } // end if/else

    // ...and we flush the rules
    flush_rewrite_rules();

} // end add_custom_rewrite_rule
add_action('init', 'add_custom_rewrite_rule');

// Note that the djgig URLs will still work so if you want to eliminate that, you will 
// have to use some string replace regex action within your theme.

// Depending on your theme, you can do this at the template level. When you see the call to 'the_title()', you can replace that with $title = get_the_title(), then string replace '/djgig/' in $title with '/films/'.