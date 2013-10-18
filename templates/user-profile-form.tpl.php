
<style>
.node-tabs, .action-links {
  display: none;
}
.page-header {
  display: none;

}

.form-title {
  color: #aa5f0c;
  font-weight: bold;
  font-size: 24px;
  padding: 10px 0px 20px 0px;
}

h4 {

	color: #a77d29;
}

</style>




<div class="form-title">Edit Profile</div>

<div style="background-color: #c8d5de;padding:23px;margin-bottom:20px;">
<div style="border: 1px solid #0195bd;background-color: #fff;padding:20px 31px;">

	<h4>Member Profile</h4>


	<div style="float:left; width: 49%;">

		<?php 





			unset($form['field_account_profile_visibility']['und']['#options']['_none']);
			unset($form['field_account_profile_visibility']['und']['_none']);

			print render($form['field_account_fname']);
			print render($form['field_account_lname']);
			print render($form['field_account_organization']);
			print render($form['field_account_location']);
			print render($form['field_account_country']);
			print render($form['field_account_profile_visibility']);
		?>

	</div>

	<div style="float:right; width: 49%;">
		<?php 
			print render($form['field_account_job_role']);
			print render($form['field_account_description']);
		?>

	</div>




<div style="padding-top: 15px; margin-bottom: 15px; border-bottom: 1px solid #338ea9; clear:both;"></div>


	<h4>Account Information</h4>


	<?php 
		print render($form['account']['current_pass']);
		print render($form['account']['name']);
		print render($form['account']['mail']);
		print render($form['account']['pass']);
	?>



	<div align="center"><?php echo render($form['actions']); ?></div>

	
  <?php //print drupal_render_children($form) ?>

	
</div>
</div>

<?php
  /* form identifier */
  echo render($form['form_build_id']);
  echo render($form['form_id']);
  echo render($form['form_token']);
?>


