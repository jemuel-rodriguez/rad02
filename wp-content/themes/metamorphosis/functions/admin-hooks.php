<?php

/**
 * 
 * TABLE OF CONTENTS
 * 
 * - Hook Definitions
 * 
 */

/**
 * Hook Definitions
 */

// header.php
function prime_head() { do_action( 'prime_head' ); }                    
function prime_top() { do_action( 'prime_top' ); }                  
function prime_header_before() { do_action( 'prime_header_before' ); }          
function prime_header_inside() { do_action( 'prime_header_inside' ); }              
function prime_header_after() { do_action( 'prime_header_after' ); }            
function prime_nav_before() { do_action( 'prime_nav_before' ); }                    
function prime_nav_inside() { do_action( 'prime_nav_inside' ); }                    
function prime_nav_after() { do_action( 'prime_nav_after' ); }      

// Template files: 404, archive, single, page, sidebar, index, search
function prime_content_before() { do_action( 'prime_content_before' ); }                    
function prime_content_after() { do_action( 'prime_content_after' ); }                  
function prime_main_before() { do_action( 'prime_main_before' ); }                  
function prime_main_after() { do_action( 'prime_main_after' ); }                    
function prime_post_before() { do_action( 'prime_post_before' ); }                  
function prime_post_after() { do_action( 'prime_post_after' ); }                    
function prime_post_inside_before() { do_action( 'prime_post_inside_before' ); }                    
function prime_post_inside_after() { do_action( 'prime_post_inside_after' ); }  
function prime_loop_before() { do_action( 'prime_loop_before' ); }  
function prime_loop_after() { do_action( 'prime_loop_after' ); }    

// Tumblog Functionality
function prime_tumblog_content_before() { do_action( 'prime_tumblog_content_before', 'Before' ); }  
function prime_tumblog_content_after() { do_action( 'prime_tumblog_content_after', 'After' ); }

// Sidebar
function prime_sidebar_before() { do_action( 'prime_sidebar_before' ); }                    
function prime_sidebar_inside_before() { do_action( 'prime_sidebar_inside_before' ); }                  
function prime_sidebar_inside_after() { do_action( 'prime_sidebar_inside_after' ); }                    
function prime_sidebar_after() { do_action( 'prime_sidebar_after' ); }                  

// footer.php
function prime_footer_top() { do_action( 'prime_footer_top' ); }                    
function prime_footer_before() { do_action( 'prime_footer_before' ); }                  
function prime_footer_inside() { do_action( 'prime_footer_inside' ); }                  
function prime_footer_after() { do_action( 'prime_footer_after' ); }    
function prime_foot() { do_action( 'prime_foot' ); }                    

?>