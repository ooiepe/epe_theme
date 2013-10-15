<?php

/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode; for example, "full", "teaser".
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined; for example, $node->body becomes $body. When needing to
 * access a field's raw values, developers/themers are strongly encouraged to
 * use these variables. Otherwise they will have to explicitly specify the
 * desired field language; for example, $node->body['en'], thus overriding any
 * language negotiation rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */

// add EduVis javascript framework

$epe_ev_path = drupal_get_path('module', 'epe_ev');

// include php file for epe_ev functions.
include($_SERVER["DOCUMENT_ROOT"] . $GLOBALS["base_path"] . $epe_ev_path . "/inc/epe_ev_lib.php");

// set path to EduVis framework
$EduVis_path = $GLOBALS['base_url'] . '/'. $epe_ev_path .'/EduVis/';

// add EduVis framework to page
drupal_add_js( $EduVis_path . "EduVis.js" );

// initialize the tool array
$ev_tool = array();

// dont show anythign in teaser mode
if(!$teaser){
  
  // get the configuration from the instance node
  $ev_tool["instance_configuration"] = epe_getFieldValue( "field_instance_configuration", $node );

  // get the tool details (name, path_css, path_js) from the instance parent reference "field_parent_tool"
  $ev_tool["tool"] = epe_getParentFieldValues( "field_parent_tool", array("field_tool_name"), $node );

}

//
//<article id="node-<?php print $node->nid; ?
//>" class="<?php print $classes; ?
//> clearfix"<?php print $attributes; ?
//>>

// get paths array
$EduVis_Paths = epe_EduVis_Paths();

?>

<?php include 'viewpage.tpl.php' ?>

<div style="background-color: #c8d5de;padding:23px;margin-bottom:20px;">
  <div style="border: 1px solid #0195bd;background-color: #fff;padding:20px 31px;">
  <!-- content -->

    <div id="vistool"></div>

    <!-- comments -->
    <?php print render($content['comments']); ?>

  </div>
</div>

<!-- </article> -->

<script type="text/javascript">

(function(){

  EduVis.Environment.setPaths( 
    '<?php echo $EduVis_Paths["EduVis"]["root"];?>', // eduvis
    '<?php echo $EduVis_Paths["EduVis"]["tools"];?>', // tools
    '<?php echo $EduVis_Paths["EduVis"]["resources"];?>' // resources
  );

  EduVis.tool.load(
    { 
      "name" : '<?php print $ev_tool['tool']['field_tool_name'];?>', 
      "tool_container_div": "vistool",
      "instance_config": <?php 
            if(isset($ev_tool['instance_configuration']))
              print $ev_tool["instance_configuration"] . "\n";
            else
              print "{}";
          
          ?>
    }
  );

}());

</script>