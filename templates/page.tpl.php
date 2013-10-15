
<style type="text/css">

.login {
  float: right;
        clear: all;
        padding-bottom: 11px;

}

.login ul {
    list-style-type: none;
      clear: all;

}

.login ul li {
  float: left;
    padding-left: 30px;
}

.login ul li a {
    color: white;

    text-decoration: none;
}

.search {
  float: right;
  clear: all;
  padding: 0px;

}

.search input {
  margin-bottom: 0px;
}

.search form {
  margin-bottom: 0px;
}


</style>




<div class="newwrapper">
        <div class="epeheader">
            <div class="bg">
                <div class="inner">
                    <a href="<?php echo base_path() ?>"><img src="<?php echo base_path() . drupal_get_path('theme', 'bootstrap') ?>/images/logo.png" border="0" alt="OOI Ocean Education Portal" class="logo"></a>
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
function doSearch() {
  document.location = '<?php echo base_path() ?>resource-browser#/search/' + document.getElementById('searchCriteria').value;

}
</script>

                        <div class="search"><form action="./" onsubmit="doSearch();return false;"><input id="searchCriteria" type="text" placeholder="Search"></form></div>                      
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

      <div style="float:right;padding-top:10px;"><a href="<?php echo base_path() ?>help">Help</a></div>
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

    <section class="<?php print _bootstrap_content_span($columns); ?>">  
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlighted hero-unit"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>

      <?php //if (!empty($breadcrumb)): print $breadcrumb; endif;?>
      <a id="main-content"></a>
      <?php print render($title_prefix); ?>
      <?php if (!empty($title)): ?>
        <h1 class="page-header"><?php print $title; ?></h1>
      <?php endif; ?>
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
      <?php print render($page['content']); ?>
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
<div class="ffooter">
  <?php print render($page['footer']); ?>
</div>
