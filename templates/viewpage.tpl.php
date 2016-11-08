
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
if (!isset($isLLB)) {
 $isLLB = 0;
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



$resourceStatus = 'Private';
$resourceStatusDesc = 'Private - You are the only person who can view this resource.';
$isChecked_Private = 'checked';
$isChecked_Published = '';
$isChecked_Searchable = '';
$searchablePending = '';
if ($node->status == 1) {
  $resourceStatus = 'Published';
  $resourceStatusDesc = 'Published - Anyone with the url may view this resource.';
  $isChecked_Private = '';
  $isChecked_Published = 'checked';
  $isChecked_Searchable = '';
}
if ($field_public_status == 'Pending') {
  $resourceStatus = 'Pending';
  $resourceStatusDesc = 'Searchable (Pending Approval) - Anyone with the url may view this resource. You have submitted this item for review and inclusion in the public database.';
  $isChecked_Private = '';
  $isChecked_Published = '';
  $isChecked_Searchable = 'checked';
  $searchablePending = ' (Currently Pending Approval)';
}
if ($field_public_status == 'Public') {
  $resourceStatus = 'Searchable';
  $resourceStatusDesc = 'Searchable - This resource is searchable by other users.';
  $isChecked_Private = '';
  $isChecked_Published = '';
  $isChecked_Searchable = 'checked';
}

$resourceStausSelector = '<table cellpadding="5"><tr><td valign="baseline"><input type="radio" name="status" value="private" onClick="openConfirmPrivate();" ' . $isChecked_Private .  '></td><td>Private - You are the only person who can view this resource.</td></tr><tr><td valign="baseline"><input type="radio" name="status" value="published" onClick="openConfirmPublished();" ' . $isChecked_Published .  '></td><td>Published - Anyone with the url may view this resource.</td></tr><tr><td valign="baseline"><input type="radio" name="status" value="searchable" onClick="openConfirmSearchable();" ' . $isChecked_Searchable .  '></td><td>Searchable' . $searchablePending . ' - This resource is searchable by other users.</td></tr></table>';

$confirmPrivateDialog = '<div id="confirmPrivate" style="margin-top:10px;padding-top:10px;border-top: 1px solid #ccc;display:none;">Are you sure you wish unpublish this resource?<br><br><div align="center"><a class="btn btn-primary" href="' . base_path() . 'node/' . $node -> nid . '/unshare/">Yes</a>&nbsp;&nbsp;<button onclick="closeConfirmPrivate();" class="btn">No</button></div></div>';
$confirmPublishedDialog = '<div id="confirmPublished" style="margin-top:10px;padding-top:10px;border-top: 1px solid #ccc;display:none;">Are you sure you wish to share this resource with anyone with the link?<br><br><div align="center"><a class="btn btn-primary" href="' . base_path() . 'node/' . $node -> nid . '/share/">Yes</a>&nbsp;&nbsp;<button onclick="closeConfirmPublished();" class="btn">No</button></div></div>';
$confirmSearchableDialog = '<div id="confirmSearchable" style="margin-top:10px;padding-top:10px;border-top: 1px solid #ccc;display:none;">Are you sure you wish to submit this resource for review and inclusion in the public database?<br><br><div align="center"><a class="btn btn-primary" href="' . base_path() . 'node/' . $node -> nid . '/submitpublic/">Yes</a>&nbsp;&nbsp;<button onclick="closeConfirmSearchable();" class="btn">No</button></div></div>';

$resourceStausSelector = $resourceStausSelector . $confirmPrivateDialog . $confirmPublishedDialog . $confirmSearchableDialog;

if ($node->status == 1) {
  $social_share_output = '';
  $social_share_block = module_invoke('epe_wp', 'block_view', 'epe_wp_social_share');
  if($social_share_block) $social_share_output = '<br/>' . $social_share_block['content'];
  $resourceStausSelector = $resourceStausSelector . '<br><br>Your resource is shared and is visible to anyone with the link.<br><br>Link to share:<br><input type="text" class="input" style="width:100%;" value="'. $node_detail_url .'">' . $social_share_output; 
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

.resource-links ul li a.links,
.flag-favorite-resource a {
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
/* fix inconsistent popover width  */
.resource-links .popover { width: 276px; }

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
      <li>
      <!-- <a href="<?php echo base_path() . "node/" . $node -> nid ?>/clone/<?php echo clone_token_to_arg() ?>" class="links copy" title="Copy This Resource">COPY</a> -->
      <?php 
      echo l(t('COPY'), $node->nid . '/clone/' .  clone_token_to_arg(),
        array(
          'attributes'=>array(
            'data-placement'=>'bottom',
            'rel'=>'tooltip',
            'class'=>array('links','copy'),
            'id'=>'copy-btn',
            'title'=>'Copy This Resource',
            'trigger'=>'manual'
          ),
          'external'=>true
        )      
      ); 
      ?>      
      </li>
  <?php endif; ?>
<?php endif; ?>

<?php if ($field_public_status == 'Public' && $hasAccess_Edit == 1): ?>
    <li><!-- <a href="#" class="links edit popover-link" id="edit-btn" title="Edit This Resource">EDIT</a> -->
      <?php 
      echo l(t('EDIT'),'#',
        array(
          'attributes'=>array(
            'data-placement'=>'bottom',
            'rel'=>'tooltip',
            'class'=>array('links','edit','popover-link'),
            'id'=>'edit-btn',
            'title'=>'Edit This Resource',
            'trigger'=>'manual'
          ),
          'external'=>true
        )      
      ); 
      ?>
    </li>
<?php elseif ($hasAccess_Edit == 1): ?>
    <li>
    <!-- <a href="<?php echo base_path() . "node/" . $node -> nid ?>/edit/" class="links edit" id="edit-btn" title="Edit This Resource">EDIT</a> -->
    <?php 
      echo l(t('EDIT'), $node->nid . '/edit/',
        array(
          'attributes'=>array(
            'data-placement'=>'bottom',
            'rel'=>'tooltip',
            'class'=>array('links','edit'),
            'id'=>'edit-btn',
            'title'=>'Edit This Resource',
            'trigger'=>'manual'
          ),
          'external'=>true
        )      
      ); 
    ?>    
    </li>
<?php endif; ?>

<?php if ($hasAccess_Delete == 1): ?>
    <li>
    <!-- <a href="#" class="links delete popover-link" id="delete-btn" title="Delete This Resource">DELETE</a> -->
    <?php 
    echo l(t('DELETE'),'#',
      array(
        'attributes'=>array(
          'data-placement'=>'bottom',
          'rel'=>'tooltip',
          'class'=>array('links','delete','popover-link'),
          'id'=>'delete-btn',
          'title'=>'Delete This Resource',
          'trigger'=>'manual'
        ),
        'external'=>true
      )      
    ); 
    ?>
    </li>
<?php endif; ?>

<?php if ($hasAccess_Share == 1): ?>
    <li>
    <!-- <a href="#" class="links publish popover-link" id="changestatus-btn" title="Share This Resource">SHARE</a> -->
    <?php 
    echo l(t('SHARE'),'#',
      array(
        'attributes'=>array(
          'data-placement'=>'bottom',
          'rel'=>'tooltip',
          'class'=>array('links','publish','popover-link'),
          'id'=>'changestatus-btn',
          'title'=>'Share This Resource',
          'trigger'=>'manual'
        ),
        'external'=>true
      )      
    ); 
    ?>    
    </li>
<?php endif; ?>

<?php if ($hasAccess_Feature == 1 && $field_public_status == 'Public'): ?>
    <li>
    <!-- <a href="#" class="links share popover-link" id="feature-btn" title="Feature This Resource">FEATURE</a> -->
    <?php 
    echo l(t('FEATURE'),'#',
      array(
        'attributes'=>array(
          'data-placement'=>'bottom',
          'rel'=>'tooltip',
          'class'=>array('links','share','popover-link'),
          'id'=>'feature-btn',
          'title'=>'Feature This Resource',
          'trigger'=>'manual'
        ),
        'external'=>true
      )      
    ); 
    ?>    
    </li>
<?php endif; ?>

<?php if(user_is_logged_in()): ?>
  <li>
  <?php echo flag_create_link('favorite_resource', $node->nid); ?>
  </li>
<?php endif; ?>
  </ul>
</div>

<?php endif; ?>


<div class="resource-heading">
  <div class="resource-title"><?php print $node -> title ?></div>
  <div class="resource-author"><strong>Created by:</strong> <a href="<?php echo base_path() . "user/" . $node -> uid ?>"><?php print $user_name ?></a></div>
  <?php if( $user->uid == $node->uid): ?>
      <div class="resource-description"><strong>Status:</strong> <?php echo $resourceStatusDesc ?></div>
  <?php endif; ?>


  <?php if( $wasCloned ): ?>
      <div class="resource-description"><strong>Was copied from:</strong> <a href="<?php echo base_path() . "node/" . $original_node -> nid ?>"><?php print $original_node -> title ?></a></div>
  <?php endif; ?>


  <?php if( !empty($node -> body) && !$isLLB): ?>
      <div class="resource-description"><?php print $node -> body['und'][0]['value'] ?> </div>
  <?php endif; ?>

</div>

<script type="text/javascript">

function loadMenu() {
  (function($) {


      $('#changestatus-btn')
        .popover(
          {
            title: '<a style="float:right;margin-top:-9px;" href="#" onclick="closeShareConfirm(); return false;"><i class="icon-remove"></i></button>',
            html: 'true', 
            placement: 'bottom',
            content: function(){
              return '<?php echo $resourceStausSelector ?>';
            }
          }
        )



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
function closeChangeStatusConfirm() {
  jQuery('#changestatus-btn').popover('hide');
}
function closeFeatureConfirm() {
  jQuery('#feature-btn').popover('hide');
}



function closeConfirmPrivate() {
  jQuery('#confirmPrivate').hide();
}

function openConfirmPrivate() {
  jQuery('#confirmPrivate').show();
  closeConfirmPublished();
  closeConfirmSearchable();
}

function closeConfirmPublished() {
  jQuery('#confirmPublished').hide();
}

function openConfirmPublished() {
  jQuery('#confirmPublished').show();
  closeConfirmPrivate();
  closeConfirmSearchable();
}

function closeConfirmSearchable() {
  jQuery('#confirmSearchable').hide();
}

function openConfirmSearchable() {
  jQuery('#confirmSearchable').show();
  closeConfirmPublished();
  closeConfirmPrivate();
}


</script>

<?php drupal_add_js('jQuery(document).ready(function () { loadMenu(); });', array('type' => 'inline', 'scope' => 'footer', 'weight' => 5)); ?>

<?php drupal_add_js(drupal_get_path('theme','epe_theme') . '/js/resource-toolbar.tooltip.js'); ?>

