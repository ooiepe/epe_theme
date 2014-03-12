<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>




<?php
$isDBFiles = 1;
include 'viewpage.tpl.php';
?>



<div style="background-color: #c8d5de;padding:23px;margin-bottom:20px;" class="clearfix">
<div style="border: 1px solid #0195bd;background-color: #fff;padding:20px 31px;" class="clearfix">

<style type="text/css">
.field-label {
  display: none;
}
</style>

<?php print render($content['field_audio_resource_file']) ?>








  <?php
    // Hide comments, tags, and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_tags']);
    //print render($content);
  ?>

  <?php if (!empty($content['field_tags']) || !empty($content['links'])): ?>
    <footer>
      <?php print render($content['field_tags']); ?>
      <?php print render($content['links']); ?>
    </footer>
  <?php endif; ?>


</div>
</div>

  <?php print render($content['comments']); ?>

</article> <!-- /.node -->



