<?php

  // include php file for epe_ev functions.
  include($_SERVER["DOCUMENT_ROOT"] . $GLOBALS["base_path"] . drupal_get_path('module', 'epe_ev') . "/inc/epe_ev_lib.php");

  // set paths for EduVis and epe_ev
  $EduVis_Paths = epe_EduVis_Paths();

  // initialize the tool array
  $ev_tool = array();
   
  // get the tool details (name, path_css, path_js) from the instance parent reference "field_parent_tool"
  $ev_tool["tool"] = epe_getNodeValues( array("field_tool_name"), $node );

  // add EduVis framework to page
  drupal_add_js( $EduVis_Paths["EduVis"]["javascript"]);

?>

<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php 
    $hideActionButtons = 1;
    include 'viewpage.tpl.php' 
  ?>

  <div style="background-color: #c8d5de;padding:23px;margin-bottom:20px;">
    <div style="border: 1px solid #0195bd;background-color: #fff;padding:20px 31px;">

      <div id="vistool"></div>

    </div>
  </div>

<?php

$query = new EntityFieldQuery();
$query->entityCondition('entity_type', 'node')
  ->propertyCondition('type', array('ev_tool_instance'))
  ->propertyCondition('status', 1)
  ->propertyOrderBy('created', 'DESC')
  ->fieldCondition('field_parent_tool', 'value', $node->nid, '=')
  ->range(0, 10);

$result = $query->execute();

// are there any instances
if(count($result)>0){

?>
  <div class="container-fluid" style="margin-bottom:150px">
    <div class="row-fluid">
      
      <div class="resource-title"> Published Instances </div>
      <div class="thumbnails">
  
<?php

  $nids = array_keys($result['node']);
  $nodes = node_load_multiple($nids);

  foreach($nodes as $instance_node){

    //print_r($instance_node->body);
?>
    <div class="span6 thumbnail">
      
      <div class="row-fluid">
        <div class="span4">
          <?php echo render(field_view_field('node',$instance_node, 'field_instance_thumbnail', 
            array('label'=>'hidden','settings' => array('image_style' => 'medium'))));
          ?>
        </div>
        <div class="span8">
          <div>
            <b>Title:</b> <a href="../node/<?php echo $instance_node->nid;?>"><?php echo $instance_node->title;?></a></div>
          <div>
            <?php echo render(field_view_field('node',$instance_node, 'body',array(
                'type' => 'text_summary_or_trimmed', 
                'settings'=>array('trim_length' => 150)
                )));
            ?>
          </div>
          <div>
            <a class="btn" href="../node/<?php echo $instance_node->nid;?>">Preview</a> 
            <a class="btn" href="../node/<?php echo $instance_node->nid;?>/clone">Copy</a>
          </div>
        </div>
      </div>
    </div>

<?php

  }
?>

        </div>
    </div>
  </div>

<?php
}

?>

</article>

<script type="text/javascript">

  (function(EduVis){

    EduVis.Environment.setPaths( 
      '<?php echo $EduVis_Paths["EduVis"]["root"];?>', // eduvis
      '<?php echo $EduVis_Paths["EduVis"]["tools"];?>', // tools
      '<?php echo $EduVis_Paths["EduVis"]["resources"];?>' // resources
    );

    // load EduVis tool into vistool container
    EduVis.tool.load(
      { 
        "name" : "<?php print $ev_tool['tool']['field_tool_name'];?>",
        "tool_container_div": "vistool"
      }
    );

  }(EduVis));

</script>