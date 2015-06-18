
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



<?php $queryString = drupal_get_query_parameters(); ?>



<div class="form-title">Edit Your Profile</div>


<?php if (isset($queryString['pass-reset-token'])): ?>
	<h4>Account Information</h4>
	<?php 
		print render($form['account']['current_pass']);
		print render($form['account']['name']);
		print render($form['account']['mail']);
		print render($form['account']['pass']);
	?>
	<div style="padding-top: 15px; margin-bottom: 15px; border-bottom: 1px solid #338ea9; clear:both;"></div>
<?php endif; ?>

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


<?php if (!isset($queryString['pass-reset-token'])): ?>
	<div style="padding-top: 15px; margin-bottom: 15px; border-bottom: 1px solid #338ea9; clear:both;"></div>
	<h4>Account Information</h4>
	<?php 
		print render($form['account']['current_pass']);
		print render($form['account']['name']);
		print render($form['account']['mail']);
		print render($form['account']['pass']);
	?>
<?php endif; ?>


	<div align="center"><?php echo render($form['actions']); ?></div>


<?php
  /* form identifier */
  echo render($form['form_build_id']);
  echo render($form['form_id']);
  echo render($form['form_token']);
?>


