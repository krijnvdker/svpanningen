<?php
/**
 * WP-JoomSport
 * @author      BearDev
 * @package     JoomSport
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$opposite_events = JoomsportSettings::get('opposite_events',array());
if($opposite_events){
    $opposite_events = json_decode($opposite_events,true);
}
//$rows->h2h();

?>
<div class="table-responsive">
    <?php
            $width = JoomsportSettings::get('teamlogo_height');
            $match = $rows;
            if(JoomsportSettings::get('partdisplay_awayfirst',0) == 1){
                $partic_home = $match->getParticipantHome();
                $partic_away = $match->getParticipantAway();
                $tmp = $rows->lists['m_events_away'];
                $rows->lists['m_events_away'] = $rows->lists['m_events_home'];
                $rows->lists['m_events_home'] = $tmp;
                $tmp = $rows->lists['squard1'];
                $rows->lists['squard1'] = $rows->lists['squard2'];
                $rows->lists['squard2'] = $tmp;
                $tmp = $rows->lists['squard1_res'];
                $rows->lists['squard1_res'] = $rows->lists['squard2_res'];
                $rows->lists['squard2_res'] = $tmp;
            }else{
                $partic_home = $match->getParticipantHome();
                $partic_away = $match->getParticipantAway();
            }
            
            ?>
    <div id="jsPlayerStatMatchDiv">
    <?php
    require_once 'player_stat' . DIRECTORY_SEPARATOR . 'match-view-player-stat.php';
    ?>
    </div>
    <?php
    if (count($rows->lists['team_events'])) {
        ?>
    <div class="center-block jscenter jsMarginBottom30">
        <h3 class="jsInlineBlock"><?php echo __('Match statistic','joomsport-sports-league-results-management');
        ?></h3>
    </div>
    <div class="jsPaddingBottom30 jsTeamStat">
        <div class="jsOverflowHidden">
            <div class="jsInline">
                <div>
                    
                    <div class="jstable-cell ">
                    <?php echo $partic_home ? ($partic_home->getEmblem(true, 0, 'emblInline', $width)) : '';
        ?>
                    </div>
                    <div class="jstable-cell ">

                        <?php

                            echo ($partic_home) ? ($partic_home->getName(true)) : '';
        ?>
                    </div>
                </div>
            </div> 
            <div class="jsInline">
                <div style="text-align: right;">
                    
                    
                    <div class="jstable-cell" style="display:inline-block;">

                        <?php

                            echo ($partic_away) ? ($partic_away->getName(true)) : '';
        ?>
                    </div>
                    <div class="jstable-cell" style="display:inline-block;">
                    <?php echo $partic_away ? ($partic_away->getEmblem(true, 0, 'emblInline', $width)) : '';
        ?>
                    </div>
                </div>
            </div>
            <div class="jstable">
                <?php
                for ($intP = 0; $intP < count($rows->lists['team_events']); ++$intP) {
                    $graph_sum = $rows->lists['team_events'][$intP]->home_value + $rows->lists['team_events'][$intP]->away_value;
                    $graph_home_class = ' jsGray';
                    $graph_away_class = ' jsRed';
                    if ($graph_sum) {
                        $graph_home = round(100 * $rows->lists['team_events'][$intP]->home_value / $graph_sum);
                        $graph_away = round(100 * $rows->lists['team_events'][$intP]->away_value / $graph_sum);
                        if ($graph_home > $graph_away) {
                            //$graph_home_class = ' jsRed';
                        } else {
                            //$graph_away_class = ' jsRed';
                        }
                    }
                    if (!$graph_home) {
                        $graph_home_class = '';
                    }
                    if (!$graph_away) {
                        $graph_away_class = '';
                    }
                    ?>
                    <div class="jstable-row jsColTeamEvents">
                        
                        <div class="jstable-cell jsCol5">
                            <div class="teamEventGraph">
                                <div class="teamEventGraphHome<?php echo $graph_home_class?>" style="width:<?php echo $graph_home?>%"><?php echo $rows->lists['team_events'][$intP]->home_value;
                    ?></div>
                            </div>
                            
                        </div>
                        <div class="jstable-cell jsCol6">

                            <div>
                                <?php 
                                echo $rows->lists['team_events'][$intP]->objEvent->getEmblem();
                                echo $rows->lists['team_events'][$intP]->objEvent->getEventName();
                    ?>
                            </div>
 
                        </div>
                        <div class="jstable-cell jsCol5">
                            <div class="teamEventGraph">
                                <div class="teamEventGraphAway<?php echo $graph_away_class?>" style="width:<?php echo $graph_away?>%"><?php echo $rows->lists['team_events'][$intP]->away_value;
                    ?></div>
                            </div>
                            
                        </div>
                        

                    </div>    
                    <?php

                }
        ?>
            </div>
            
        </div>
    </div>
    <?php

    }
    ?>
    <?php

    if (jsHelper::getADF($rows->lists['ef'])) {
        ?>
        <div class="center-block jscenter">
            <h3><?php echo __('Additional information','joomsport-sports-league-results-management');
        ?></h3>
        </div>
        <div class="matchExtraFields jsPaddingBottom30">
            <?php
            $ef = $rows->lists['ef'];
        if (count($ef)) {
            foreach ($ef as $key => $value) {
                if ($value != null) {
                    echo '<div class="JSplaceM">';
                    echo  '<div class="labelEFM">'.$key.'</div>';
                    echo  '<div class="valueEFM">'.$value.'</div>';
                    echo  '</div>';
                }
            }
        }
        ?>
        </div>
    <?php

    }
    do_action( 'js_match_prediction', $match->object->ID);
    ?>
</div>