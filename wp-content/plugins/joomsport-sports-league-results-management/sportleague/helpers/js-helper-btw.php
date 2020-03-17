<?php
/**
 * WP-JoomSport
 * @author      BearDev
 * @package     JoomSport
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class jsHelperBtw
{
    public static function matches($team1, $team2, $homeOnly = 0){
        global $wpdb;
        if($homeOnly){
            $selteam = array('relation' => 'AND',
                array(
                    'key' => '_joomsport_home_team',
                    'value' => $team1
                ),

                array(
                    'key' => '_joomsport_away_team',
                    'value' => $team2
                )
            );
        }else{
            $selteam = array('relation' => 'OR',
                array('relation' => 'AND',
                    array(
                        'key' => '_joomsport_home_team',
                        'value' => $team1
                    ),

                    array(
                        'key' => '_joomsport_away_team',
                        'value' => $team2
                    )
                ),
                array('relation' => 'AND',
                    array(
                        'key' => '_joomsport_home_team',
                        'value' => $team2
                    ),

                    array(
                        'key' => '_joomsport_away_team',
                        'value' => $team1
                    )
                ),
            );
        }


        $matches = new WP_Query(array(
                'posts_per_page' => -1,
                'offset'           => 0,
                'post_type'        => 'joomsport_match',
                'post_status'      => 'publish',
                'order'     => 'DESC',

                'meta_query' => array(
                    array('relation' => 'AND',
                        array('key'     => '_joomsport_seasonid'),
                        array('key'     => '_joomsport_match_date'),
                        array('key'     => '_joomsport_match_time')),
                    $selteam

                )
            )
        );

        return $matches->posts;
    }
}
