
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

.welcome {
	color: #fff;
	padding: 20px;
}

.account-info h4 {

	color: #a77d29;
}

</style>




<div class="form-title">New User Registration</div>

<div style="background-color: #c8d5de;padding:23px;margin-bottom:20px;">
<div style="border: 1px solid #0195bd;background-color: #fff;padding:0px;">

	<div style="background-color: #07698e;float: left;width:320px; height:900px;">
		<div class="welcome">
			<h4>Welcome</h4>

				<p>This is the user registration page to create a new account. The form requires a username, email, and password (designated by you). To complete the process, you will need to enter the CAPTCHA phrase displayed at bottom. This precaution is employed to prevent automated spam submissions.</p><p>Having an account will allow you create new resources using the site&rsquo;s tools (i.e., data visualizers, concept map and lesson builders). You will also be able to upload some types of resources from your own computer. All of these will items will remain private unless you elect to publish them. &nbsp;</p><p>After being reviewed and approved by moderator, your published resources will display your &ldquo;Username&rdquo; and will be visible to anyone viewing that resource. Registered users can comment on all published resources.</p>
		</div>
	</div>

	<div style="float: right; width: 600px; padding: 0px;">
		<div class="account-info" style="padding: 20px 30px 20px 0px;">

			<h4>Account Information</h4>

			<?php
        print render($form['field_account_fname']);
        print render($form['field_account_lname']);
        print render($form['field_account_organization']);
				print render($form['account']['name']);
				print render($form['account']['mail']);
				print render($form['account']['pass']);
			 ?>

	 		<div style="margin: 20px 0px; text-align:left;border: 1px solid #6a8da0; padding: 10px;">
				<?php print render($form['captcha']); ?>
			</div>

	 		<div align="center"><?php echo render($form['actions']); ?></div>

		</div>


	</div>


	<div style="clear:both;"></div>


</div>
</div>

<?php
  /* form identifier */
  echo render($form['form_build_id']);
  echo render($form['form_id']);
  echo render($form['form_token']);
?>





