


<div class="newwrapper">
        <div class="epeheader">
            <div class="bg">
                <div class="inner">
                    <a href="<?php echo base_path() ?>"><img src="<?php echo base_path() . drupal_get_path('theme', 'epe_theme') ?>/images/logo.png" border="0" alt="OOI Ocean Education Portal" class="logo"></a>
                    <div class="searchandlogin">
                        <div class="login">


                        <?php if (user_is_logged_in()): ?>
                          <ul>
                            <li><a href="<?php echo base_path() ?>user">My Profile</a></li>
                            <li><a href="<?php echo base_path() ?>user/logout">Logout</a></li>
                          </ul>
                        <?php else: ?>
                          <ul>
                            <li><a href="<?php echo base_path() ?>user/register">Sign Up</a></li>
                            <li><a href="<?php echo base_path() ?>user">Log In</a></li>
                          </ul>
                        <?php endif; ?>


                        </div>
                        <div style="clear:both;"></div>

<script type="text/javascript">
function doSiteSearch() {
  document.location = '<?php echo base_path() ?>resource-browser#/search/?type=ev&search=' + document.getElementById('searchCriteria').value;

}
</script>

                        <div class="search"><form action="./" onsubmit="doSiteSearch();return false;"><input id="searchCriteria" type="text" placeholder="Search Resources"></form></div>
                    </div>



                    <div class="topnav">
      <?php
      $block = module_invoke('epe_wp', 'block_view', 'epe_wp_top_menu_links');
      print $block['content'];
      ?>
                    </div>
                </div>
            </div>
        </div>

<header id="navbar" role="banner" class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <?php
      $block = module_invoke('menu_block', 'block_view', '1');
      print drupal_render($block['content']);
      ?>
      <div class="help-link"><a href="<?php echo base_path() ?>help">Knowledge Base</a></div>
    </div>
  </div>
</header>

<div class="main-container container">

  <header role="banner" id="page-header">
    <?php if (!empty($site_slogan)): ?>
      <p class="lead"><?php print $site_slogan; ?></p>
    <?php endif; ?>

    <?php print render($page['header']); ?>
  </header> <!-- /#header -->

  <div class="row-fluid">

    <?php if (!empty($page['sidebar_first'])): ?>
      <aside class="span3" role="complementary">
        <?php print render($page['sidebar_first']); ?>
      </aside>  <!-- /#sidebar-first -->
    <?php endif; ?>

    <section class="<?php print _epe_theme_content_span($columns); ?>">
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>

      <?php //if (!empty($breadcrumb)): print $breadcrumb; endif;?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php /*if (!empty($title)): ?>
        <h1 class="page-header"><?php print $title; ?></h1>
      <?php endif;*/ ?>
      <?php print render($title_suffix); ?>
      <?php print $messages; ?>
      <?php if (!empty($tabs)): ?>
        <div class="node-tabs">
        <?php print render($tabs); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <div class="well"><?php print render($page['help']); ?></div>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php //print render($page['content']); ?>


<div id="home-content" class="content">
  <div id="welcome-rotator">
    <div id="welcome"><?php echo file_get_contents(drupal_get_path('theme','epe_theme') . '/templates/content/homepage/main.html'); ?></div>
    <div id="rotator">
      <?php
        $block = module_invoke('bean', 'block_view', 'homepage-rotator');
        if(!empty($block['content']['bean']['homepage-rotator']['field_rotator_content_fields']['#items'])) {
          print render($block['content']);  
        } else {        
      ?>
      <?php if(file_exists(drupal_get_path('theme','epe_theme') . '/templates/content/homepage/carousel.json')): ?>
        <?php $carousel = json_decode(file_get_contents(drupal_get_path('theme','epe_theme') . '/templates/content/homepage/carousel.json')); ?>
        <div id="epe-home-carousel" class="carousel slide pull-right"><!-- class of slide for animation -->
          <div class="carousel-inner">
            <?php foreach($carousel as $key=>$slide): ?>
              <?php $slideclasses = array('item'); ?>
              <?php if($key == 0): array_push($slideclasses, "active"); endif; ?>
              <div class="<?php echo implode(' ', $slideclasses); ?>">
                <img src="<?php echo drupal_get_path('theme','epe_theme') . '/templates/content/homepage/images/' . $slide->image; ?>" />
                <?php if(isset($slide->caption) && $slide->caption != ''): ?>
                  <div class="carousel-caption">
                    <p><?php echo $slide->caption; ?></p>
                  </div>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          </div><!-- /.carousel-inner -->
          <!--  Next and Previous controls below href values must reference the id for this carousel -->
          <a class="carousel-control left" href="#epe-home-carousel" data-slide="prev">&lsaquo;</a>
          <a class="carousel-control right" href="#epe-home-carousel" data-slide="next">&rsaquo;</a>
          <ol class="carousel-indicators">
          <?php foreach($carousel as $key=>$slide): ?>
          <li data-target="#epe-home-carousel" data-slide-to="<?php echo $key; ?>" <?php if($key == 0): echo 'class="active"'; endif; ?>></li>
          <?php endforeach; ?>
          </ol>
        </div><!-- /.carousel -->
      <?php endif; ?>
      <?php } //end check bean ?>
    </div> <!-- /rotator -->
    <br style="clear:both;">
  </div> <!-- /welcome-rotator -->

  <div id="tool-intros" class="control-group">
    <div class="span4">
    <?php echo file_get_contents(drupal_get_path('theme','epe_theme') . '/templates/content/homepage/block-left.html'); ?>
    </div>
    <div class="span4" style="margin-left:51px;">
    <?php echo file_get_contents(drupal_get_path('theme','epe_theme') . '/templates/content/homepage/block-center.html'); ?>
    </div>
    <div class="span4" style="margin-left:51px;">
    <?php echo file_get_contents(drupal_get_path('theme','epe_theme') . '/templates/content/homepage/block-right.html'); ?>
    </div>
    <br clear="all">
  </div>
</div> <!-- /.content -->


<?php
drupal_add_js(drupal_get_path('module','epe_cm') . '/js/mmr.js');
?>

<script>
var $ = jQuery;
window.onload = function () {


                jQuery('#term').typeahead({
                    minLength: 2, 
                    source: function(q, cb) {
                        console.log(q);
                        findKeyWordMatches("Name", q);
                        var arrMatches = [];
                        for (var k=0; k<keywordMatches.length; k++ ){
                            arrMatches.push(keywordMatches[k].formatted);
                        };
                        cb(arrMatches);
                    }, 
                    matcher: function (item) {
                        // all matches are true cause we've already filtered
                        return true;
                    }, 
                    updater: function (item) {
                        //alert(item);

                        document.location = '<?php echo base_path() ?>vocab?term=' + item;
                        // this is the item they have selected, we now have to do something with it
                        return item;
                    }
                });
             loadVocabStyles("<?php echo drupal_get_path('module','epe_cm') ?>/xml/vocab_css.xml");
};

</script>

<div id="home-vocab" class="content">
  <div  class="inner">
    <p>
      <?php echo file_get_contents(drupal_get_path('theme','epe_theme') . '/templates/content/homepage/vocab.html'); ?>
    </p>
    <div class="explore-button">
      <a href="./vocab"><img src="<?php echo base_path() . drupal_get_path('theme', 'epe_theme') ?>/images/home_start_exploring_btn.png" border="0"></a>
    </div>
    <div class="search">
      <form name="vocab" action="<?php echo base_path() ?>vocab" method="get">
      <input type="text" id="term" name="term" autocomplete="off" placeholder="Search Vocabulary">
      <img src="<?php echo base_path() . drupal_get_path('theme', 'epe_theme') ?>/images/home_explore_search_btn.png" onClick="document.forms['vocab'].submit();">
      </form>
    </div>
    <div class="or">
      OR
    </div>
  </div>
</div>


<style type="text/css">
#home-featured {
  padding: 14px 10px 60px 10px;

}
#home-featured h2 {
  font-size: 24px;
  font-weight: normal;
}
#home-featured ul {
  list-style: none;
  margin: 32px 0 0 0;
}
#home-featured ul li {
  float: left;
  width: 195px;
  border-left: 1px solid #cadfe7;
  padding-left: 21px;
  margin-left: 20px;
  height: 100%;
}

#home-featured ul li.first {
  padding-left: 0px;
  margin-left: 0px;
  border-left: none;
}


#home-featured ul li img {
  border: 2px solid #0884b3;
}

#home-featured ul li .title {
  font-weight: bold;
  color: #277d9d;
  padding-top: 14px;
  line-height: 16px;
}
#home-featured ul li .author {
  font-weight: bold;
  margin-top: -4px;
}

#home-featured ul li .summary {
  padding-top: 13px;
  font-size: 13px;
  line-height: 16px;
  height: 100px;
  position: relative;
  overflow: hidden;
}


#home-featured ul li .summary .after {
    background-image: -webkit-linear-gradient(rgba(255, 255, 255, 0), white);
    background-image:    -moz-linear-gradient(rgba(255, 255, 255, 0), white);
    background-image:     -ms-linear-gradient(rgba(255, 255, 255, 0), white);
    background-image:      -o-linear-gradient(rgba(255, 255, 255, 0), white);
    background-image:         linear-gradient(rgba(255, 255, 255, 0), white);
    bottom: 0;
    left: 0;
    height: 20px;
    position: absolute;
    right: 0;
}


#home-featured-wrapper {
  float: left;
  width: 698px;
  margin-left: 42px;
}

#home-updates-wrapper {
  float: right;
  width: 200px;
  margin-right: 20px;
  padding-top: 14px;
  padding-right: 20px;
}

#home-updates-wrapper h2 {
  font-size: 24px;
  font-weight: normal;
}

#home-updates-wrapper p {
  border-left: 1px solid #cadfe7;
  margin-top: 25px;
  margin-left: -20px;
  padding-left: 20px;
}



</style>
<!--
<div id="home-featured">
  <h2>Featured Resources</h2>
  <ul>
    <li class="first">
      <a href=""><img src="<?php echo base_path() . path_to_theme() ?>/images/sample_thumb_1.jpg" width="190" height="141"></a>
      <div class="title">Sandy Wave Heights and Wind Speed</div>      
      <div class="author">by Sage Lichtenwalner</div>      
      <div class="summary">Suspendisse potenti. Donec ac tempus velit.Suspendisse potenti. Donec ac tempus velit.Suspendisse potenti. Donec ac tempus velit.Suspendisse potenti. Donec ac tempus velit. </div>      
    </li>
    <li>
      <a href=""><img src="<?php echo base_path() . path_to_theme() ?>/images/sample_thumb_2.jpg" width="190" height="141"></a>
      <div class="title">RU23 - Hurricane Sandy</div>      
      <div class="author">by Sage Lichtenwalner</div>      
      <div class="summary">Pellentesque potenti. Donec ac tempus velit. </div>      
    </li>
    <li>
      <a href=""><img src="<?php echo base_path() . path_to_theme() ?>/images/sample_thumb_3.jpg" width="190" height="141"></a>
      <div class="title">Title of the item</div>      
      <div class="author">by Joe Wieclawek</div>      
      <div class="summary">Suspendisse potenti. Donec ac tempus velit. </div>      
    </li>
    <li>
      <a href=""><img src="<?php echo base_path() . path_to_theme() ?>/images/sample_thumb_4.jpg" width="190" height="141"></a>
      <div class="title">Title of the item</div>      
      <div class="author">by Joe Wieclawek</div>      
      <div class="summary">Suspendisse potenti. Donec ac tempus velit. </div>      
    </li>
  </ul>
  <br clear="all">
</div>
-->


    <div id="home-featured-wrapper">
    <div class="control-group">
      <div class="span12">
        <div id="home-featured">
      <?php
        $block = module_invoke('epe_wp','block_view','epe_db_featured');
        echo '<h2>' . render($block['title']) . '</h2>';
        echo render($block['content']);
      ?>
        <br clear="all">
        </div>
      </div>
    </div>
    </div>
    <div id="home-updates-wrapper">
      <?php echo file_get_contents(drupal_get_path('theme','epe_theme') . '/templates/content/homepage/updates.html'); ?>
    </div>

    </section>

    <?php if (!empty($page['sidebar_second'])): ?>
      <aside class="span3" role="complementary">
        <?php print render($page['sidebar_second']); ?>
      </aside>  <!-- /#sidebar-second -->
    <?php endif; ?>

  </div>
</div>

        <div class="push"></div>
</div>
<div class="epe-footer">
  <?php //print render($page['footer']); ?>

  <div class="inner" style="padding-top:20px;">
    <div class="disclaimer-block">Funding for the Ocean Observatories Initiative is provided by the National Science Foundation through a Cooperative Agreement with the Consortium for Ocean Leadership. Any opinions, findings, and conclusions or recommendations expressed in this material are those of the author(s) and do not necessarily reflect the views of the National Science Foundation.  </div>

    <div class="logo-block"><a href="http://www.nsf.gov/"><img src="<?php echo base_path() . drupal_get_path('theme', 'epe_theme') ?>/images/nsf_logo.png" border="0" alt="National Science Foundation" class="logo" align="right"></a><div>&copy; <?php echo date("Y") ?> OOI - All Rights Reserved<br><a href="<?php echo base_path() ?>privacy">Privacy</a> | <a href="<?php echo base_path() ?>termsofuse">Terms of Use</a> | <a href="<?php echo base_path() ?>copyright">Copyright Policy</a> | <a href="<?php echo base_path() ?>contact">Contact</a></div></div>

  </div>

</div>
