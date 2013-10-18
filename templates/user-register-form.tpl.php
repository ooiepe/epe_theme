
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

				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus egestas ac eros sit amet rutrum. Cras bibendum viverra elit, vel malesuada neque eleifend vitae. Quisque varius congue commodo. Nulla ultricies felis volutpat quam sollicitudin, ut blandit elit pretium. Morbi a pharetra quam. Phasellus ac felis turpis. Sed posuere enim ultrices, volutpat lorem eget, pellentesque elit. Cras et nibh a velit imperdiet tempor at non augue. Phasellus et sem at felis viverra suscipit. Nulla eu mauris rhoncus, volutpat diam nec, gravida tellus. Nulla libero ipsum, tincidunt vel tellus sit amet, semper gravida odio.</p>

				<p>Vivamus vehicula fermentum imperdiet. Vestibulum erat risus, varius nec magna id, tempus rhoncus orci. Maecenas vel varius massa. Vivamus mattis luctus consequat. Maecenas urna lectus, eleifend at mauris eu, ultricies auctor purus. Aenean gravida purus at adipiscing suscipit. Donec varius interdum nulla at commodo.</p>

		</div>
	</div>

	<div style="float: right; width: 600px; padding: 0px;">
		<div class="account-info" style="padding: 20px 30px 20px 0px;">

			<h4>Account Information</h4>

			<?php 
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





