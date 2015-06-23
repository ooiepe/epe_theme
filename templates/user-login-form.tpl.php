
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

</style>




<div class="form-title">User Login</div>


<?php $form['name']['#description'] = 'Enter your username'; ?>

  <?php print drupal_render_children($form) ?>

  <br><br><br>
  <a href="<?php echo base_path() ?>user/register">Not registered? Sign up now!</a><br><br>
  <a href="<?php echo base_path() ?>user/password">Forgot your password? Request a new one.</a><br>


