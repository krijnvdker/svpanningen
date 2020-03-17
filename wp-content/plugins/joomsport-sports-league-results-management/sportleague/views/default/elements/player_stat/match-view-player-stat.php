<?php
/**
 * WP-JoomSport
 * @author      BearDev
 * @package     JoomSport
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<?php
if (count($rows->lists['m_events_home']) || count($rows->lists['m_events_away'])) {
    ?>
    <div class="center-block jscenter jsMarginBottom30">
        <h3 class="jsInlineBlock"><?php echo __('Player statistic','joomsport-sports-league-results-management');
            ?></h3>
    </div>
    <div class="jsPaddingBottom30">
        <div class="jsOverflowHidden">

            <div class="jsInline">
                <div class="jsDivwMinHg">

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
                <?php
                if($rows->lists['m_events_display'] == 1){
                    ?>
                    <table class="jsTblMatchTab firstTeam">
                        <thead>
                        <tr>
                            <th></th>
                            <th><?php echo __('Quantity','joomsport-sports-league-results-management');
                                ?></th>
                            <th><?php echo __('Event','joomsport-sports-league-results-management');
                                ?></th>
                            <th><?php echo __('Time','joomsport-sports-league-results-management');
                                ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($intP = 0; $intP < count($rows->lists['m_events_home']); ++$intP) {
                            ?>
                            <tr class="jsMatchTRevents">
                                <td class="evPlayerName">
                                    <?php echo $rows->lists['m_events_home'][$intP]->obj->getName(true);
                                    if($rows->lists['m_events_home'][$intP]->plFM){
                                        $assist_players = '';

                                        $assistArr = explode(",", $rows->lists['m_events_home'][$intP]->plFM);
                                        for($intM=0;$intM<count($assistArr);$intM++){
                                            if($intM){$assist_players .= ", ";}
                                            $assist_players .= get_the_title($assistArr[$intM]);
                                        }

                                        echo '<div class="subEvDiv">('.$rows->lists['m_events_home'][$intP]->subEn.': '.$assist_players.')</div>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $rows->lists['m_events_home'][$intP]->ecount;
                                    ?>
                                </td>
                                <td>
                                    <?php echo $rows->lists['m_events_home'][$intP]->objEvent->getEmblem(false);
                                    ?>
                                </td>


                                <td>
                                    <?php
                                    if($rows->lists['m_events_home'][$intP]->minutes_input){
                                        echo $rows->lists['m_events_home'][$intP]->minutes_input;
                                        if(strpos($rows->lists['m_events_home'][$intP]->minutes_input,':') === false){
                                            echo "'";
                                        }
                                    }else{
                                        echo $rows->lists['m_events_home'][$intP]->minutes ? $rows->lists['m_events_home'][$intP]->minutes."'" : '';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php

                        }
                        if (!count($rows->lists['m_events_home'])) {
                            //echo "&nbsp";
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                }
                ?>
            </div>
            <div  class="jsInline">
                <div class="jsDivwMinHg" style="text-align: right;">


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
                <?php
                if($rows->lists['m_events_display'] == 1){
                    ?>
                    <table class="jsTblMatchTab">
                        <thead>
                        <tr>
                            <th><?php echo __('Time','joomsport-sports-league-results-management');
                                ?></th>
                            <th><?php echo __('Event','joomsport-sports-league-results-management');
                                ?></th>
                            <th><?php echo __('Quantity','joomsport-sports-league-results-management');
                                ?></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($intP = 0; $intP < count($rows->lists['m_events_away']); ++$intP) {
                            ?>
                            <tr class="jsMatchTRevents">
                                <td>
                                    <?php
                                    if($rows->lists['m_events_away'][$intP]->minutes_input){
                                        echo $rows->lists['m_events_away'][$intP]->minutes_input;
                                        if(strpos($rows->lists['m_events_away'][$intP]->minutes_input,':') === false){
                                            echo "'";
                                        }
                                    }else{
                                        echo $rows->lists['m_events_away'][$intP]->minutes ? $rows->lists['m_events_away'][$intP]->minutes."'" : '';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $rows->lists['m_events_away'][$intP]->objEvent->getEmblem(false);
                                    ?>
                                </td>
                                <td>
                                    <?php echo $rows->lists['m_events_away'][$intP]->ecount;
                                    ?>
                                </td>
                                <td class="evPlayerName">
                                    <?php echo $rows->lists['m_events_away'][$intP]->obj->getName(true);
                                    if($rows->lists['m_events_away'][$intP]->plFM){
                                        $assist_players = '';

                                        $assistArr = explode(",", $rows->lists['m_events_away'][$intP]->plFM);
                                        for($intM=0;$intM<count($assistArr);$intM++){
                                            if($intM){$assist_players .= ", ";}
                                            $assist_players .= get_the_title($assistArr[$intM]);
                                        }

                                        echo '<div class="subEvDiv">('.$rows->lists['m_events_away'][$intP]->subEn.': '.$assist_players.')</div>';
                                    }
                                    ?>
                                </td>

                            </tr>
                            <?php

                        }
                        if (!count($rows->lists['m_events_away'])) {
                            //echo "&nbsp";
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    if($rows->lists['m_events_display'] == 0){

        ?>
        <table class="jsTblVerticalTimeLine table table-striped">
            <tbody>
            <?php

            for($intE=0;$intE<count($rows->lists['m_events_all']);$intE++){
                $isOpposite = in_array($rows->lists['m_events_all'][$intE]->e_id,$opposite_events);

                ?>
                <tr>

                    <?php
                    if((!$isOpposite && $partic_home->object->ID == $rows->lists['m_events_all'][$intE]->t_id) ||
                        ($isOpposite && $partic_away->object->ID == $rows->lists['m_events_all'][$intE]->t_id)){
                        
                        echo '<td class="jsMatchPlayer">';
                          
                        echo $rows->lists['m_events_all'][$intE]->obj->getName(true);
                        if($rows->lists['m_events_all'][$intE]->plFM){
                            $assist_players = '';

                            $assistArr = explode(",", $rows->lists['m_events_all'][$intE]->plFM);
                            for($intM=0;$intM<count($assistArr);$intM++){
                                if($intM){$assist_players .= ", ";}
                                $assist_players .= get_the_title($assistArr[$intM]);
                            }

                            echo '<div class="subEvDiv">('.$rows->lists['m_events_all'][$intE]->subEn.': '.$assist_players.')</div>';
                        }
                        echo '</td>';
                    }else{
                        echo '<td class="jsMatchPlayer jsHidden">';
                        echo '&nbsp;';
                        echo '</td>';
                    }

                    ?>
                    
                    
                    <?php
                    if((!$isOpposite && $partic_home->object->ID == $rows->lists['m_events_all'][$intE]->t_id) ||
                        ($isOpposite && $partic_away->object->ID == $rows->lists['m_events_all'][$intE]->t_id)){
                        echo '<td class="jsMatchEvent">';

                        echo $rows->lists['m_events_all'][$intE]->objEvent->getEmblem(false);
                        echo '</td>';
                    }else{
                        echo '<td class="jsMatchEvent jsHidden">';

                        echo '&nbsp;';
                        echo '</td>';
                    }

                    ?>
                    
                    <td class="jstimeevent">
                        <?php
                        if($rows->lists['m_events_all'][$intE]->minutes_input){
                            echo $rows->lists['m_events_all'][$intE]->minutes_input;
                            if(strpos($rows->lists['m_events_all'][$intE]->minutes_input,':') === false){
                                echo "'";
                            }
                        }else{
                            echo $rows->lists['m_events_all'][$intE]->minutes ? $rows->lists['m_events_all'][$intE]->minutes."'" : '';
                        }
                        ?>
                    </td>
                    
                    <?php
                    if((!$isOpposite && $partic_away->object->ID == $rows->lists['m_events_all'][$intE]->t_id) ||
                        ($isOpposite && $partic_home->object->ID == $rows->lists['m_events_all'][$intE]->t_id)){
                        echo '<td class="jsMatchEvent">';
                        echo $rows->lists['m_events_all'][$intE]->objEvent->getEmblem(false);
                        echo '</td>';
                    }else{
                        echo '<td class="jsMatchEvent jsHidden">';
                        echo '&nbsp;';
                        echo '</td>';
                    }

                    ?>

                    
                    
                    <?php
                    if((!$isOpposite && $partic_away->object->ID == $rows->lists['m_events_all'][$intE]->t_id) ||
                        ($isOpposite && $partic_home->object->ID == $rows->lists['m_events_all'][$intE]->t_id)){
                        echo '<td class="jsMatchPlayer">';
                        echo $rows->lists['m_events_all'][$intE]->obj->getName(true);
                        if($rows->lists['m_events_all'][$intE]->plFM){
                            $assist_players = '';

                            $assistArr = explode(",", $rows->lists['m_events_all'][$intE]->plFM);
                            for($intM=0;$intM<count($assistArr);$intM++){
                                if($intM){$assist_players .= ", ";}
                                $assist_players .= get_the_title($assistArr[$intM]);
                            }

                            echo '<div class="subEvDiv">('.$rows->lists['m_events_all'][$intE]->subEn.': '.$assist_players.')</div>';
                        }
                        echo '</td>';
                    }else{
                        echo '<td class="jsMatchPlayer jsHidden">';
                        echo '&nbsp;';
                        echo '</td>';
                    }

                    ?>

                    
                </tr>

                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    }
}
?>