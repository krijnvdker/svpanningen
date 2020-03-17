<?php
/**
 * WP-JoomSport
 * @author      BearDev
 * @package     JoomSport
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( has_post_thumbnail() ) {
    echo '<style>';
    echo 'img[src="'. get_the_post_thumbnail_url() .'"] { display:none; visibility:hidden;}';
    echo '</style>';
}
?>
<div>
    <div>
        <div>
            <?php
                //var_dump($rows);
                $tabs = $rows->getTabs();
                jsHelperTabs::draw($tabs, $rows);
            ?>
        </div>
    </div>
</div>
