



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
function doSearch() {
  document.location = '<?php echo base_path() ?>resource-browser#/search/?type=ev&search=' + document.getElementById('searchCriteria').value;

}
</script>

                        <div class="search"><form action="./" onsubmit="doSearch();return false;"><input id="searchCriteria" type="text" placeholder="Search Resources"></form></div>                      
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
      <div class="section-content">
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
