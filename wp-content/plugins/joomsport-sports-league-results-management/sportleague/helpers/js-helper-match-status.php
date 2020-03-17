<?php
/**
 * WP-JoomSport
 * @author      BearDev
 * @package     JoomSport
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class jsHelperMatchStatus
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            global $jsDatabase;
            $query = 'SELECT *'
                .' FROM '.$jsDatabase->db->joomsport_match_statuses;

            static::$instance = $jsDatabase->select($query);
        }
        return static::$instance;
    }
}

class jsHelperPublishedSeasons
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            $argsSeasons = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'orderby'          => 'title',
                'order'            => 'ASC',
                'post_type'        => 'joomsport_season',
                'post_status'      => 'publish'
            );
            static::$instance = get_posts( $argsSeasons );

            
        }
        return static::$instance;
    }
}
class jsHelperAllTeamPosts
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            $argsSeasons = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'post_type'        => 'joomsport_team',
                'post_status'      => 'publish'
            );
            $tm = get_posts( $argsSeasons );
            $teams = array();
            
            for($intA=0;$intA<count($tm);$intA++){
                $teams[$tm[$intA]->ID] = $tm[$intA];
            }
            
            static::$instance = $teams;

            
        }
        return static::$instance;
    }
}

class jsHelperAllPlayersPosts
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            $argsSeasons = array(
                'posts_per_page'   => -1,
                'offset'           => 0,
                'post_type'        => 'joomsport_player',
                'post_status'      => 'publish'
            );
            $tm = get_posts( $argsSeasons );
            $teams = array();
            
            for($intA=0;$intA<count($tm);$intA++){
                $teams[$tm[$intA]->ID] = $tm[$intA];
            }
            
            static::$instance = $teams;

            
        }
        return static::$instance;
    }
}

class jsHelperSeasonMatches
{
    protected static $instance = array();
    
    protected function __construct() {
        
    }
    
    public static function getInstance($args)
    {
        if(isset(static::$instance)){
            for($intA=0;$intA<count(static::$instance);$intA++){
                $Tmp = static::$instance[$intA];
                
                if($Tmp["args"] == $args){
                    return $Tmp["matches"];
                }
                
            }
        }
        //var_dump($args);
        $matches = new WP_Query($args);
        $nArray = array("args" => $args, "matches" => $matches);
        static::$instance[] = $nArray;
        
        return $matches;
        
    }
}

class jsHelperSeasonPartic
{
    protected static $instance = array();
    
    protected function __construct() {
        
    }
    
    public static function getInstance($season_id, $participiants, $t_single)
    {
        if(!isset(static::$instance[$season_id])){
            static::$instance[$season_id] = get_posts(array(
                'post_type' => $t_single?'joomsport_player':'joomsport_team',
                'include' => $participiants,
                'orderby' => 'title',
                'order' => 'ASC')
            );
        }

        
        return static::$instance[$season_id];
        
    }
}

class jsHelperTeamEvents
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            global $wpdb;
            static::$instance = $wpdb->get_results("SELECT * FROM {$wpdb->joomsport_events} WHERE player_event='0' ORDER BY ordering");
            

            
        }
        return static::$instance;
    }
}

class jsHelperEventsResType
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            global $jsDatabase;
            $query = 'SELECT result_type as value, id as name FROM '.$jsDatabase->db->joomsport_events."";
            static::$instance = $jsDatabase->selectKeyPair($query);
            
        }
        return static::$instance;
    }
}
class jsHelperEventsArr
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            global $jsDatabase;
            $query = 'SELECT * FROM '.$jsDatabase->db->joomsport_events."";
            $evs = $jsDatabase->select($query);
            $arr = array();
            for($intA=0;$intA<count($evs);$intA++){
                $arr[$evs[$intA]->id] = $evs[$intA];
            }
            static::$instance = $arr;
            
        }
        return static::$instance;
    }
}

class jsHelperEventsSelvar
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            global $jsDatabase;
            $query = 'SELECT sel_value,id FROM '.$jsDatabase->db->joomsport_ef_select;
            $evs = $jsDatabase->select($query);
            $arr = array();
            for($intA=0;$intA<count($evs);$intA++){
                $arr[$evs[$intA]->id] = $evs[$intA]->sel_value;
            }
            static::$instance = $arr;
            
        }
        return static::$instance;
    }
}

class jsHelperBoxScore
{
    protected static $instance = null;
    
    protected function __construct() {
        
    }
    
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            global $wpdb;
            $cBox = $wpdb->get_results('SELECT * FROM '.$wpdb->joomsport_box) ;
            $arr = array();
            for($intA=0;$intA<count($cBox);$intA++){
                $arr[$cBox[$intA]->id] = $cBox[$intA];
            }
            static::$instance = $arr;
            
        }
        return static::$instance;
    }
}
