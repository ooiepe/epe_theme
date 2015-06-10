
<script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-tooltip.js"></script>
<script src="http://getbootstrap.com/2.3.2/assets/js/bootstrap-popover.js"></script>


<?php
$node_detail_url = $GLOBALS['base_url'] . "/node/" . $node -> nid;

if(isset($custom_node_detail_url) && valid_url($custom_node_detail_url)) {
  $node_detail_url = $custom_node_detail_url;
}

// determine if this resource is used in a concept map or lesson
$results = db_select('resources_assoc', 'ra')
             ->fields('ra', array('parent'))
             ->condition('child', $node->nid)
             ->execute();
$isUsedByOtherResources = 0;
if ($results->rowCount() > 0)
  $isUsedByOtherResources = 1;


$user_data = user_load($node->uid);

$user_name = $user_data->name;
if (!empty($user_data->field_account_fname['und'][0]['value']) && !empty($user_data->field_account_lname['und'][0]['value'])) {
  $user_name = $user_data->field_account_fname['und'][0]['value'] . " " . $user_data->field_account_lname['und'][0]['value'];
} elseif (!empty($user_data->field_account_fname['und'][0]['value'])) {
  $user_name = $user_data->field_account_fname['und'][0]['value'];
} elseif (!empty($user_data->field_account_lname['und'][0]['value'])) {
  $user_name = $user_data->field_account_lname['und'][0]['value'];
}

?>


<style>
.node-tabs, .action-links {
  display: none;
}
.page-header {
  display: none;

}

</style>

<?php

if (!isset($isDBFiles)) {
 $isDBFiles = 0;
}
if (!isset($hideActionButtons)) {
 $hideActionButtons = 0;
}

if (!isset($showContent)) {
 $showContent = true;
}

$hasAccess_Feature = 0;
if ($router_item = menu_get_item("node/" . $node -> nid . "/feature/")) {
  if ($router_item['access']) {
    $hasAccess_Feature = 1;
  }
}



$hasAccess_Clone = 0;
if ($isDBFiles == 0) {
  if ($router_item = menu_get_item("node/" . $node -> nid . "/clone/" . clone_token_to_arg())) {
    if ($router_item['access']) {
      $hasAccess_Clone = 1;
    }
  }
}

$hasAccess_Edit = 0;
if ($router_item = menu_get_item("node/" . $node -> nid . "/edit/")) {
  if ($router_item['access']) {
    $hasAccess_Edit = 1;
  }
}

$hasAccess_Delete = 0;
if ($router_item = menu_get_item("node/" . $node -> nid . "/delete/")) {
  if ($router_item['access']) {
    $hasAccess_Delete = 1;
  }
}

// checking diff url if files
if ($isDBFiles == 1) {

  $hasAccess_Publish = 0;
  if ($router_item = menu_get_item("node/" . $node -> nid . "/edit/")) {
    if ($router_item['access']) {
      $hasAccess_Publish = 1;
    }
  }

  $hasAccess_Share = 0;
  if ($router_item = menu_get_item("node/" . $node -> nid . "/edit/")) {
    if ($router_item['access']) {
      $hasAccess_Share = 1;
    }
  }

} else {

  $hasAccess_Publish = 0;
  if ($router_item = menu_get_item("node/" . $node -> nid . "/edit/")) {
    if ($router_item['access']) {
      $hasAccess_Publish = 1;
    }
  }

  $hasAccess_Share = 0;
  if ($router_item = menu_get_item("node/" . $node -> nid . "/edit/")) {
    if ($router_item['access']) {
      $hasAccess_Share = 1;
    }
  }

}

$hasAccess_ApprovePublish = 0;
if ($router_item = menu_get_item("node/" . $node -> nid . "/approvepublic/")) {
  if ($router_item['access']) {
    $hasAccess_ApprovePublish = 1;
  }
}



$field_public_status = 'Private';
if (!empty($node->field_public_status['und'][0]['value'])) {
  $field_public_status = $node->field_public_status['und'][0]['value'];
}

$field_featured_status = 'Not-Featured';
if (!empty($node->field_featured_status['und'][0]['value'])) {
  $field_featured_status = $node->field_featured_status['und'][0]['value'];
}

$wasCloned = 0;
if (!empty($node->field_source_nid['und'][0]['value'])) {
  if ($node->field_source_nid['und'][0]['value'] > 0) {
    $wasCloned = 1;
    $original_node = node_load($node->field_source_nid['und'][0]['value']);
  }
}



?>



<style>



.resource-links {
  float: right;
}


.resource-links ul {
    list-style-type: none;
}

.resource-links ul li {
    float: left;
    padding-left: 20px;
}

.resource-links ul li a.links {
    color: #356281;
    text-decoration: none;
    background-position: left center;
    background-repeat: no-repeat;
    padding-left: 30px;
    height: 22px;
    display: block;
}

.resource-links ul li a.copy {
    background-image: url(<?php echo base_path() . path_to_theme() ?>/images/icon_copy.jpg);
}
.resource-links ul li a.edit {
    background-image: url(<?php echo base_path() . path_to_theme() ?>/images/icon_edit.jpg);
}
.resource-links ul li a.delete {
    background-image: url(<?php echo base_path() . path_to_theme() ?>/images/icon_delete.jpg);
}
.resource-links ul li a.publish {
    background-image: url(<?php echo base_path() . path_to_theme() ?>/images/icon_publish.jpg);
}
.resource-links ul li a.share {
    background-image: url(<?php echo base_path() . path_to_theme() ?>/images/icon_share.jpg);
}


.resource-heading {
  padding-bottom: 20px;
}

.resource-title {
  color: #aa5f0c;
  font-weight: bold;
  font-size: 24px;
  padding-bottom: 10px;
  line-height: 24px;
}

.resource-author {
  color: #000;
}


#comments .title {
  color: #aa5f0c;
  font-weight: bold;
  font-size: 24px;
  padding-bottom: 10px;

}

#comments .form-item-subject, #comments #edit-preview, #comments .form-type-item, #comment-form .form-item-subject, #comment-form #edit-preview, #comment-form .form-type-item {
  display: none;
}



</style>


<?php if ($hasAccess_ApprovePublish == 1 && $field_public_status == 'Pending'): ?>
    <div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Please Review</h4>
    This item has been submitted for review and inclusion in the public database. Please review this item and approve or reject as appropriate.<br><br>
    <a class="btn btn-success" href="<?php echo base_path() . "node/" . $node -> nid ?>/approvepublic/">Approve</a> <a class="btn btn-danger" href="<?php echo base_path() . "node/" . $node -> nid ?>/rejectpublic/">Reject</a>

    </div>
<?php endif; ?>






<?php if ($hideActionButtons == 0): ?>


<div class="resource-links">
  <ul>

<?php if ($isDBFiles == 0): ?>
  <?php if ($hasAccess_Clone == 1): ?>
      <li><a href="<?php echo base_path() . "node/" . $node -> nid ?>/clone/<?php echo clone_token_to_arg() ?>" class="links copy">COPY</a></li>
  <?php endif; ?>
<?php endif; ?>

<?php if ($field_public_status == 'Public' && $hasAccess_Edit == 1): ?>
    <li><a href="#" class="links edit popover-link" id="edit-btn">EDIT</a></li>
<?php elseif ($hasAccess_Edit == 1): ?>
    <li><a href="<?php echo base_path() . "node/" . $node -> nid ?>/edit/" class="links edit"  id="edit-btn">EDIT</a></li>
<?php endif; ?>

<?php if ($hasAccess_Delete == 1): ?>
    <li><a href="#" class="links delete popover-link" id="delete-btn">DELETE</a></li>
<?php endif; ?>

<?php if ($hasAccess_Publish == 1): ?>
    <li><a href="#" class="links publish popover-link" id="publish-btn">PUBLISH</a></li>
<?php endif; ?>

<?php if ($hasAccess_Share == 1): ?>
    <li><a href="#" class="links share popover-link" id="share-btn">SHARE</a></li>
<?php endif; ?>

<?php if ($hasAccess_Feature == 1 && $field_public_status == 'Public'): ?>
    <li><a href="#" class="links share popover-link" id="feature-btn">FEATURE</a></li>
<?php endif; ?>

  </ul>
</div>

<?php endif; ?>


<div class="resource-heading">
  <div class="resource-title"><?php print $node -> title ?></div>
  <div class="resource-author"><strong>Created by:</strong> <a href="<?php echo base_path() . "user/" . $node -> uid ?>"><?php print $user_name ?></a></div>



  <?php if( $wasCloned ): ?>
      <div class="resource-description"><strong>Was copied from:</strong> <a href="<?php echo base_path() . "node/" . $original_node -> nid ?>"><?php print $original_node -> title ?></a></div>
  <?php endif; ?>


  <?php if( !empty($node -> body) ): ?>
      <div class="resource-description"><?php print $node -> body['und'][0]['value'] ?> </div>
  <?php endif; ?>

</div>

<script type="text/javascript">

function loadMenu() {
  (function($) {

<?php if ($field_public_status == 'Public' && $hasAccess_Edit == 1): ?>
    $('#edit-btn')
      .popover(
        {
          title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeEditConfirm(); return false;"><i class="icon-remove"></i></button>',
          html: 'true',
          placement: 'bottom',
          content: 'Your resource is currently visible in the public database.<br><br>Please unpublish this resource before editing.<br><br><div align="center"><button onclick="closeEditConfirm();" class="btn">OK</button></div>'
        }
      );
<?php endif; ?>

<?php if ($isUsedByOtherResources == 1 && $hasAccess_Delete == 1): ?>
    $('#delete-btn')
      .popover(
        {
          title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeDeleteConfirm(); return false;"><i class="icon-remove"></i></button>', 
          html: 'true', 
          placement: 'bottom', 
          content: 'Your resource is currently being used by other resources and cannot be deleted.<br><br><div align="center"><button onclick="closeDeleteConfirm();" class="btn">OK</button></div>'
        }
      );
<?php elseif ($field_public_status == 'Public' && $hasAccess_Delete == 1): ?>
    $('#delete-btn')
      .popover(
        {
          title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeDeleteConfirm(); return false;"><i class="icon-remove"></i></button>', 
          html: 'true', 
          placement: 'bottom', 
          content: 'Your resource is currently visible in the public database.<br><br>Please unpublish this resource before deleting.<br><br><div align="center"><button onclick="closeDeleteConfirm();" class="btn">OK</button></div>'
        }
      );
<?php elseif ($hasAccess_Delete == 1): ?>
    $('#delete-btn')
      .popover(
        {
          title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeDeleteConfirm(); return false;"><i class="icon-remove"></i></button>',
          html: 'true',
          placement: 'bottom',
          content: 'Are you sure you wish to delete this resource?<br><br><div align="center"><a class="btn btn-primary" href="<?php echo base_path() . "node/" . $node -> nid ?>/deleteresource/">Yes</a>&nbsp;&nbsp;<button onclick="closeDeleteConfirm();" class="btn">No</button></div>'
        }
      );
<?php endif; ?>

<?php if ($isUsedByOtherResources == 1 && $hasAccess_Share == 1): ?>
    $('#share-btn')
      .popover(
        {
          title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeShareConfirm(); return false;"><i class="icon-remove"></i></button>', 
          html: 'true', 
          placement: 'bottom', 
          content: function(){
            $(this).tooltip('hide');
            return 'Your resource is shared and is visible to anyone with the link.<br><br>Link to share:<br><input type="text" class="input" style="width:100%;" value="<?php echo $node_detail_url; ?>"><br><br>Your resource is currently being used by other resources and cannot be unshared.';
          }
        }
      )
      .tooltip(
        {
          placement: 'bottom', 
          title: 'Sharing allows a resource to be visible to anyone with the link'
        }
      );
<?php elseif ($node->status == 0 && $hasAccess_Share == 1): ?>
      $('#share-btn')
        .popover(
          {
            title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeShareConfirm(); return false;"><i class="icon-remove"></i></button>',
            html: 'true', 
            placement: 'bottom', 
            content: function(){
              $(this).tooltip('hide');
              return 'Do you wish to share this resource with anyone with the link?<br><br><div align="center"><a class="btn btn-primary" href="<?php echo base_path() . "node/" . $node -> nid ?>/share/">Yes</a>&nbsp;&nbsp;<button onclick="closeShareConfirm();" class="btn">No</button></div>';
            }            
          }
        )
        .tooltip(
          {
            placement: 'bottom',
            title: 'Sharing allows a resource to be visible to anyone with the link'
          }
        );
<?php elseif ($node->status == 1 && $field_public_status == 'Public' && $hasAccess_Share == 1): ?>
      $('#share-btn')
        .popover(
          {
            title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeShareConfirm(); return false;"><i class="icon-remove"></i></button>',
            html: 'true', 
            placement: 'bottom',
            content: function(){
              $(this).tooltip('hide');
              return 'Your resource is shared and is visible to anyone with the link.<br><br>Link to share:<br><input type="text" class="input" style="width:100%;" value="<?php echo $node_detail_url; ?>"><br><br>Your resource is currently visible in the public database.<br><br>Please unpublish this resource before unsharing.';
            }
          }
        )
        .tooltip(
          {
            placement: 'bottom',
            title: 'Sharing allows a resource to be visible to anyone with the link'
          }
        );
<?php elseif ($hasAccess_Share == 1): ?>
      $('#share-btn')
        .popover(
          {
            title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeShareConfirm(); return false;"><i class="icon-remove"></i></button>',
            html: 'true', 
            placement: 'bottom', 
            content: function(){
              $(this).tooltip('hide');
              <?php
              $social_share_output = '';
              $social_share_block = module_invoke('epe_wp', 'block_view', 'epe_wp_social_share');
              if($social_share_block) $social_share_output = '<br/>' . $social_share_block['content'];
              $tooltip_content = 'Your resource is shared and is visible to anyone with the link.<br><br>Link to share:<br><input type="text" class="input" style="width:100%;" value="'. $node_detail_url .'"><br><br>You may unshare your resource at any time.<br><br><div align="center"><a class="btn btn-primary" href="'. base_path() . 'node/' . $node->nid .'/unshare/">Unshare</a></div><br>Note: Others may be using your resource and care should be taken when Unpublishing.</div>' . $social_share_output; 
              ?>
              return '<?php echo $tooltip_content; ?>';
            }
          }
        )
        .tooltip(
          {
            placement: 'bottom',
            title: 'Sharing allows a resource to be visible to anyone with the link'
          }
        );
<?php endif; ?>

<?php if ($field_public_status == 'Private' && $hasAccess_Publish == 1): ?>
      $('#publish-btn')
        .popover(
          {
            title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closePublishConfirm(); return false;"><i class="icon-remove"></i></button>', 
            html: 'true', 
            placement: 'bottom', 
            content: function(){
              $(this).tooltip('hide');
              return 'Do you wish to submit this resource for review and inclusion in the public database?<br><br><div align="center"><a class="btn btn-primary" href="<?php echo base_path() . "node/" . $node -> nid ?>/submitpublic/">Yes</a>&nbsp;&nbsp;<button onclick="closePublishConfirm();" class="btn">No</button></div>';
            }
          }
        )
        .tooltip(
          {
            placement: 'bottom', 
            title: 'Publishing submits a resource for review and inclusion in the public database'
          }
        );
<?php elseif ($field_public_status == 'Pending' && $hasAccess_Publish == 1): ?>
      $('#publish-btn')
        .popover(
          {
            title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closePublishConfirm(); return false;"><i class="icon-remove"></i></button>',
            html: 'true',
            placement: 'bottom', 
            content: function(){
              $(this).tooltip('hide');
              return 'This resource is currently under review for inclusion in the public database.<br><br>You may withdraw this item from review at any time.<br><br><div align="center"><a class="btn btn-primary" href="<?php echo base_path() . "node/" . $node -> nid ?>/unsubmitpublic/">Unpublish</a></div>';
            }
          }
        )
        .tooltip(
          {
            placement: 'bottom', 
            title: 'Publishing submits a resource for review and inclusion in the public database'
          }
        );
<?php elseif ($field_public_status == 'Public' && $hasAccess_Publish == 1): ?>
      $('#publish-btn')
        .popover(
          {
            title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closePublishConfirm(); return false;"><i class="icon-remove"></i></button>', 
            html: 'true', 
            placement: 'bottom', 
            content: function(){
              $(this).tooltip('hide');
              return 'This resource is visible in the public database.<br><br>You may withdraw this item from review at any time.<br><br><div align="center"><a class="btn btn-primary" href="<?php echo base_path() . "node/" . $node -> nid ?>/unsubmitpublic/">Unpublish</a></div><br>Note: Others may be using your resource and care should be taken when Unpublishing.</div>';
            }
          }
        )
        .tooltip(
          {
            placement: 'bottom', 
            title: 'Publishing submits a resource for review and inclusion in the public database'
          }
        );
<?php endif; ?>


<?php if ($node->status == 1 && $field_public_status == 'Public' && $hasAccess_Feature == 1): ?>
  <?php if ($field_featured_status == 'Featured'): ?>
        $('#feature-btn')
          .popover(
            {
              title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeFeatureConfirm(); return false;"><i class="icon-remove"></i></button>',
              html: 'true',
              placement: 'bottom',
              content: 'This resource is currently featured.<br><br>You may unfeature this item at any time.<br><br><div align="center"><a class="btn btn-primary" href="<?php echo base_path() . "node/" . $node -> nid ?>/unfeature/">Unfeature</a></div><br>Note: Others may be using this resource and care should be taken when Unfeaturing.</div>'
            }
          );
  <?php else: ?>
        $('#feature-btn')
          .popover(
            {
              title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeFeatureConfirm(); return false;"><i class="icon-remove"></i></button>', 
              html: 'true', 
              placement: 'bottom', 
              content: 'Do you wish to feature this resource?<br><br><div align="center"><a class="btn btn-primary" href="<?php echo base_path() . "node/" . $node -> nid ?>/feature/">Yes</a>&nbsp;&nbsp;<button onclick="closeFeatureConfirm();" class="btn">No</button></div>'
            }
          );
  <?php endif; ?>
<?php endif; ?>



$('body').on('click', function (e) {
    $('.popover-link').each(function () {
        //the 'is' for buttons that trigger popups
        //the 'has' for icons within a button that triggers a popup
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});


  })(jQuery);
}

function closeEditConfirm() {
  jQuery('#edit-btn').popover('hide');
}
function closeDeleteConfirm() {
  jQuery('#delete-btn').popover('hide');
}
function closeShareConfirm() {
  jQuery('#share-btn').popover('hide');
}
function closePublishConfirm() {
  jQuery('#publish-btn').popover('hide');
}
function closeFeatureConfirm() {
  jQuery('#feature-btn').popover('hide');
}


</script>

<?php drupal_add_js('jQuery(document).ready(function () { loadMenu(); });', array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)); ?>

