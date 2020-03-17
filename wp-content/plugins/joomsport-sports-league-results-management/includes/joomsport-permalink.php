<?php
/**
 * WP-JoomSport
 * @author      BearDev
 * @package     JoomSport
 */



add_filter('the_title', 'jоomsport_filter_seasontitle', 10, 2);
function jоomsport_filter_seasontitle($title, $id) {
    global $wpdb, $post_type, $post;
    /*if( is_admin() || !in_the_loop() ){
        return $title;
    }*/
    if(!$post){
        return $title;
    }
    if($title != $post->post_title){
        return $title;
    }
    if($id != $post->ID){
        return $title;
    }
    if($post_type == 'joomsport_season'){
        $terms = wp_get_object_terms( $post->ID, 'joomsport_tournament' );
        if( $terms ){
            
            $post_name .= $terms[0]->name;
        }
        $post_name .= " ".$title;
        //remove_filter( 'the_title', 'jоomsport_filter_seasontitle' );
        return $post_name;
    }
    return $title;
}
add_filter( 'document_title_parts', function( $title_parts_array ) {
    global $wpdb, $post_type, $post;
    
    if(!$post){
        return $title_parts_array;
    }
    if($post_type == 'joomsport_season'){
        $terms = wp_get_object_terms( $post->ID, 'joomsport_tournament' );
        if( $terms ){
            
            $post_name .= $terms[0]->name;
        }
        //$post_name .= " ".$title;
        $title_parts_array['title'] =  $post_name ." ".$title_parts_array['title'];
    }
    
    return $title_parts_array;
} );
add_filter( 'pre_get_document_title', function( $title )
  {
    global $wpdb, $post_type, $post;
    if(!$title){
        return '';
    }
    if(!$post){
        return $title;
    }
    if($post_type == 'joomsport_season'){
        $terms = wp_get_object_terms( $post->ID, 'joomsport_tournament' );
        if( $terms ){
            
            $post_name .= $terms[0]->name;
        }
        $title =  $post_name ." ".$title;
    }
    
    return $title;
  }, 999, 1 );