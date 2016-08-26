
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




.profile-links {
  float: right;
}


.profile-links ul {
    list-style-type: none;
}

.profile-links ul li {
    float: left;
    padding-left: 20px;
}

.profile-links ul li a.links {
    color: #356281;
    text-decoration: none;
    background-position: left center;
    background-repeat: no-repeat;
    padding-left: 30px;
    height: 22px;
    display: block;
}
.profile-links ul li a.edit {
    background-image: url(<?php echo base_path() . path_to_theme() ?>/images/icon_edit.jpg);
}

.profile-heading {
  padding-bottom: 20px;
}

.profile-title {
  color: #aa5f0c;
  font-weight: bold;
  font-size: 24px;
  padding-bottom: 10px;
}

td img { max-width: 133px; }
td.views-field-php-1 { width: 140px; }
td.views-field-body { width: 570px; }
</style>


<?php

$profile_visibility = 'Private';
if (isset($user_profile['field_account_country']['#object']->field_account_profile_visibility['und'][0]['value'])) {
  $profile_visibility = $user_profile['field_account_country']['#object']->field_account_profile_visibility['und'][0]['value'];
}

$full_name = '';
if(isset($user_profile['field_account_fname'][0]['#markup']) && isset($user_profile['field_account_lname'][0]['#markup']))
	$full_name = trim($user_profile['field_account_fname'][0]['#markup'] . ' ' . $user_profile['field_account_lname'][0]['#markup']);



$account = menu_get_object('user');

if (empty($full_name)) {
	$full_name = $account->name;
}


$hasAccess_Edit = 0;
if ($router_item = menu_get_item("user/" . $account -> uid . "/edit/")) {
  if ($router_item['access']) {
    $hasAccess_Edit = 1;
  }
}

$editLabel = 'EDIT YOUR PROFILE';
if ($account->uid != $user->uid) {
  $editLabel = 'EDIT THIS PROFILE';
}

 ?>




<div class="profile-links">
  <ul>

	<?php if ($hasAccess_Edit == 1): ?>
		<li><a href="<?php echo base_path() . "user/" . $account -> uid . "/edit/" ?>" class="links edit"  id="edit-btn"><?php print $editLabel ?></a></li>
	<?php endif; ?>


  </ul>
</div>



<div class="profile-heading">
  <div class="profile-title">Member Profile</div>
</div>

<!-- <div style="background-color: #c8d5de;padding:23px;margin-bottom:20px;">
<div style="border: 1px solid #0195bd;background-color: #fff;padding:20px 31px;"> -->


<?php

    if ($profile_visibility == 'Private' && $hasAccess_Edit == 0) {
      print 'This user has chosen to keep their profile private.';
    } else if ($profile_visibility == 'Authenticated' && $user->uid == 0  && $hasAccess_Edit == 0) {
      print 'This user has chosen to only share their information with registered users.';
    } else {
      print '<h4>' . $full_name . '</h4>';

      if (!empty($user_profile['field_account_organization'][0]['#markup'])) {
        print $user_profile['field_account_organization'][0]['#markup'] . '<br>';
      }

      if (!empty($user_profile['field_account_location'][0]['#markup']) && !empty($user_profile['field_account_country'][0]['#markup'])) {
        print $user_profile['field_account_location'][0]['#markup'] . ' - ' . $user_profile['field_account_country'][0]['#markup'] . '<br>';
      } else if (!empty($user_profile['field_account_location'][0]['#markup']) && !empty($user_profile['field_account_country'][0]['#markup'])) {
        print $user_profile['field_account_location'][0]['#markup'] . ' - ' . $user_profile['field_account_country'][0]['#markup'] . '<br>';
      } else if (!empty($user_profile['field_account_country'][0]['#markup'])) {
        print $user_profile['field_account_country'][0]['#markup'] . '<br>';
      }

      if (!empty($user_profile['field_account_job_role'][0]['#markup'])) {
        print 'Job Role: ' . $user_profile['field_account_job_role'][0]['#markup'] . '<br>';
      }

      if (!empty($user_profile['field_account_description'][0]['#markup'])) {
        print '<br>' . $user_profile['field_account_description'][0]['#markup'] . '';
      }

    }

 ?>

<?php if(module_exists('epe_wp')): ?>
<div class="published-resources-list">
<h4>My Published Resources</h4>
<?php echo views_embed_view('user_resources',$display_id='public'); ?>
</div>
<?php  endif; ?>


<!-- </div>
</div>
 -->


