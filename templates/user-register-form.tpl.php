
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
	ccolor: #fff;
	padding-top: 20px;
	padding-right: 20px;
}

.account-info h4 {

	color: #a77d29;
}

</style>




<div class="form-title">Create a New Account</div>

<!-- <div style="background-color: #c8d5de;padding:23px;margin-bottom:20px;">
<div style="border: 1px solid #0195bd;background-color: #fff;padding:0px;"> -->

	<div style="float: left;width:320px; height:900px;">
		<div class="welcome">
				<p>

All of the public content on the Ocean Education Portal can be accessed without a log in.<br><br>

<h4>Why should I join?</h4>

By creating an account, you can create your own content, which includes customizing Visualization Tools, designing your own Concept maps, and constructing activities using the Data Investigation builder.<br><br>

All items you create will remain private until you choose to share them with others. When you share an item, you have the option of making it available in the public database for others to find, after they are approved by a site moderator. Approved items are displayed in the Resource Browser with the name of the author included.<br><br>

Registered users also have the ability to comment on all published resources, and can bookmark items as “favorites” to make them easy to find. <br><br>

				</p>
		</div>
	</div>

	<div style="float: right; width: 560px; padding: 0px;">
		<div class="account-info" style="padding: 0px 30px 20px 60px;border-left: 1px solid #cadfe7;">

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


<!-- </div>
</div>
 -->
<?php
  /* form identifier */
  echo render($form['form_build_id']);
  echo render($form['form_id']);
  echo render($form['form_token']);
?>





