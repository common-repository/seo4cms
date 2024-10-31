<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="seo4cms-plugin-container">
	<div class="seo4cms-masthead">
		<div class="seo4cms-masthead__inside-container">
			<div class="seo4cms-masthead__logo-container">
				<a href="https://seo.goldorange.app" target="_blank"><img class="seo4cms-masthead__logo" src="<?php echo esc_url( plugins_url( '_inc/img/seo4cms-logo.png', __FILE__ ) ); ?>" alt="SEO4CMS Logo" width="180" border="0" /></a>
			</div>
		</div>
	</div>
	<div class="seo4cms-content">
		<h1>SEO4CMS Plugin Einstellungen</h1>
		<p>Auf dieser Seite musst Du deinen API-Schlüssel und deine Nutzer-ID für dein SEO4CMS-Plugin eingeben.</p>

    <?php
		// Create an nonce, and add it to form to perform an action.
		$nonce = wp_create_nonce( 'seo4cms_nonce' );

    // save changes (when submit button was clicked)
    if(isset($_POST["submit"]) && $_POST["uid"] == '') {
			echo "<div class=\"error\"><p><strong>Hier ist wohl etwas schief gelaufen. Überprüfe bitte deine Eingaben und sende das Formular erneut ab!</strong></p></div>";
		} else {
			if(!current_user_can("manage_options")) {
				echo "<div class=\"error\"><p><strong>Hier ist wohl etwas schief gelaufen. Du hast wohl nicht die notwendigen Rechte, um diese Einstellunge vonehmen zu dürfen. Wende dich bitte an deinen Admin!</strong></p></div>";
			} else {
				if ( empty($_POST) || wp_verify_nonce($_POST['seo4cms_nonce'],'seo4cms_nonce') === false ) {
    			/* failure */
				} else {
				  /* success, processing */
					$key = sanitize_text_field($_POST["key"]);
		      $uid = sanitize_text_field($_POST["uid"]);
		      update_option("seo4cms_plugin_key", $key);
		      update_option("seo4cms_plugin_uid", $uid);
		      // show saved message
		      echo "<div class=\"updated\"><p><strong>Einstellungen gespeichert.</strong></p></div>";
				}
			}
    }
    ?>

		<form method="post">
			<input type="hidden" name="seo4cms_nonce" value="<?php echo $nonce; ?>"/>
			<table class="form-table">
				<tr>
					<th>API-Schlüssel</th>
					<td>
						<input
							type="text"
							id="key"
							name="key"
							class="regular-text"
							value="<?php echo esc_attr(get_option("seo4cms_plugin_key")); ?>"
						>
					</td>
				</tr>
				<tr>
					<th>Nutzer-ID</th>
					<td>
						<input
							type="text"
							id="uid"
							name="uid"
							class="regular-text"
							value="<?php echo esc_attr(get_option("seo4cms_plugin_uid")); ?>"
						>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes') ?>">
			</p>
		</form>

  </div>
</div>
