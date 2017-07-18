<?php
/*
Plugin Name: Globetrotter Affiliate Plugin
Plugin URI: http://www.t-muh.de/globetrotter-affiliate/
Description: Globetrotter Shop-Links automatisch in Affililate-Links umwandeln lassen.
Version: 1.1
Author: Timo Schlueter
Author URI: http://www.t-muh.de
Min WP Version: 2.0
Max WP Version: 3.0
*/
 
/*  Copyright 2009  Timo Schlueter  (email : timo@t-muh.de)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function globetrotter_affiliate($content) {
	$partner_id = get_option("globetrotter_affiliate_partner_id");
	if (empty($partner_id)) {
		$content = str_replace("http://www.globetrotter.de/de/shop/detail.php?", "http://www.globetrotter.de/partner/partner.php?ident=1cd606bc26cb75a5&page=/de/shop/detail.php?", $content);
		$content = str_replace("http://globetrotter.de/de/shop/detail.php?", "http://www.globetrotter.de/partner/partner.php?ident=1cd606bc26cb75a5&page=/de/shop/detail.php?", $content);
	} else {
		$content = str_replace("http://www.globetrotter.de/de/shop/detail.php?", "http://www.globetrotter.de/partner/partner.php?ident=$partner_id&page=/de/shop/detail.php?", $content);
		$content = str_replace("http://globetrotter.de/de/shop/detail.php?", "http://www.globetrotter.de/partner/partner.php?ident=$partner_id&page=/de/shop/detail.php?", $content);
	}
	return $content;
}

function globetrotter_affiliate_footer() {
	$ad = get_option("globetrotter_affiliate_ad");
	if($ad == "TRUE" || empty($ad)) {
		echo '<a href="http://www.walking-away.de">Wandern und Trekking</a>';
	} else {
		/* Do nothing */
	}
}

function globetrotter_affiliate_options() {	
	$partner_id = get_option("globetrotter_affiliate_partner_id");
	$ad = get_option("globetrotter_affiliate_ad");
?>

<div class="wrap">
	
	<h2><?php _e('Globetrotter Affiliate Plugin', 'globetrotter_affiliate'); ?></h2>
	
	<?php if (empty($partner_id)) : ?>
		<div id="message" class="error"><p><?php _e('Bitte geben Sie Ihre Partner-ID an.', 'globetrotter_affiliate') ?></p></div>
	<? endif; ?>
	
	<?php if (isset($_POST['partner_id']) || isset($_POST['ad'])) : ?>
		<?php update_option("globetrotter_affiliate_partner_id", $_POST['partner_id']); ?>
		<?php update_option("globetrotter_affiliate_ad", $_POST['ad']); ?>
		<div id="message" class="updated fade"><p><?php _e('Einstellungen wurden gespeichert.', 'globetrotter_affiliate') ?></p></div>
	<?php endif; ?>
		
	<div id="poststuff" class="metabox-holder has-right-sidebar">
		<div class="inner-sidebar">
			<div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position: relative;">
				<div class="postbox">
					<h3 class="hndle"><span><?php _e('Links', 'globetrotter_affiliate') ?></span></h3>
					<div class="inside">
						<ul>
							<li><a href="http://www.globetrotter.com">Globetrotter</a></li>
							<li><a href="http://www.walking-away.de">Wandern und Trekking</a></li>
							<li><a href="http://www.t-muh.de">Timo Schl&uuml;ter</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">
				<div class="meta-box-sortabless">
					<div class="postbox">
						<h3 class="hndle"><span><?php _e('Informationen', 'globetrotter_affiliate'); ?></span></h3>
						<div class="inside">
							<?php _e('Links, die zum Globetrotter Online-Shop fuehren, werden mit Hilfe dieses Plugins automatisch erkannt und in gueltige Affiliate-Links mit einer angegeben Partner-ID umgewandelt.', 'globetrotter_affiliate'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">
				<div class="meta-box-sortabless">
					<div class="postbox">
						<h3 class="hndle"><span><?php _e('Einstellungen', 'globetrotter_affiliate'); ?></span></h3>
						<div class="inside">
						<form method="post" action="<?php $_SERVER['REQUEST_URI']; ?>">
						    <?php _e('Anerkennung zeigen:','globetrotter_affiliate'); ?>
						    <select name="ad">
      							<option value="TRUE">Ja</option>
      							<option value="FALSE">Nein</option>
    						</select>
    						<br /><br />
							<?php _e('Partner-ID:','globetrotter_affiliate'); ?> <input name="partner_id" type="text" size="40" value="<?php echo $partner_id ?>"><br /><br />
							<input type="submit" class="button-primary" name="export" value="<?php _e('Speichern', 'globetrotter_affiliate'); ?>">
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<!-- end poststuff -->
	</div>
<!-- end wrap -->
</div>

<?php
}

function globetrotter_affiliate_menu() {
  add_options_page('Globetrotter Affiliate Options', 'Globetrotter Affiliate', 8, __FILE__, 'globetrotter_affiliate_options');
}

/* Several Actions */
add_action('admin_menu', 'globetrotter_affiliate_menu');
add_action('wp_footer', 'globetrotter_affiliate_footer');

/* Several Filter */
add_filter('the_content', 'globetrotter_affiliate');

?>
