<?php

// Provide < PHP 5.3 support for the __DIR__ constant.
if (!defined('__DIR__')) {
  define('__DIR__', dirname(__FILE__));
}
require_once __DIR__ . '/includes/bootstrap.inc';
require_once __DIR__ . '/includes/theme.inc';
require_once __DIR__ . '/includes/pager.inc';
require_once __DIR__ . '/includes/form.inc';
require_once __DIR__ . '/includes/admin.inc';
require_once __DIR__ . '/includes/menu.inc';
/**
 * Implements hook_theme().
 */
function epe_theme_theme(&$existing, $type, $theme, $path) {
  return array(
    'user_login' => array(
      'render element' => 'form',
        'path' => drupal_get_path('theme', 'epe_theme') . '/templates',
        'template' => 'user-login-form',
    ),
    'user_pass' => array(
      'render element' => 'form',
        'path' => drupal_get_path('theme', 'epe_theme') . '/templates',
        'template' => 'user-pass-form',
    ),
    'user_profile_form' => array(
      'render element' => 'form',
        'path' => drupal_get_path('theme', 'epe_theme') . '/templates',
        'template' => 'user-profile-form',
    ),
    'user_register_form' => array(
      'render element' => 'form',
        'path' => drupal_get_path('theme', 'epe_theme') . '/templates',
        'template' => 'user-register-form',
    ),
    'contact_site_form' => array(
      'render element' => 'form',
        'path' => drupal_get_path('theme', 'epe_theme') . '/templates',
        'template' => 'contact-site-form',
    ),
    'bootstrap_links' => array(
      'variables' => array(
        'links' => array(),
        'attributes' => array(),
        'heading' => NULL
      ),
    ),
    'bootstrap_btn_dropdown' => array(
      'variables' => array(
        'links' => array(),
        'attributes' => array(),
        'type' => NULL
      ),
    ),
    'bootstrap_modal' => array(
      'variables' => array(
        'heading' => '',
        'body' => '',
        'footer' => '',
        'attributes' => array(),
        'html_heading' => FALSE,
      ),
    ),
    'bootstrap_accordion' => array(
      'variables' => array(
        'id' => '',
        'elements' => array(),
      ),
    ),
    'bootstrap_search_form_wrapper' => array(
      'render element' => 'element',
    ),
    'bootstrap_append_element' => array(
      'render element' => 'element',
    ),
  );
}

/**
 * Override theme_breadrumb().
 *
 * Print breadcrumbs as a list, with separators.
 */
function epe_theme_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    $breadcrumbs = '<ul class="breadcrumb">';

    $count = count($breadcrumb) - 1;
    foreach ($breadcrumb as $key => $value) {
      if ($count != $key) {
        $breadcrumbs .= '<li>' . $value . '<span class="divider">/</span></li>';
      }
      else{
        $breadcrumbs .= '<li>' . $value . '</li>';
      }
    }
    $breadcrumbs .= '</ul>';

    return $breadcrumbs;
  }
}

/**
 * Override or insert variables in the html_tag theme function.
 */
function epe_theme_process_html_tag(&$variables) {
  $tag = &$variables['element'];

  if ($tag['#tag'] == 'style' || $tag['#tag'] == 'script') {
    // Remove redundant type attribute and CDATA comments.
    unset($tag['#attributes']['type'], $tag['#value_prefix'], $tag['#value_suffix']);

    // Remove media="all" but leave others unaffected.
    if (isset($tag['#attributes']['media']) && $tag['#attributes']['media'] === 'all') {
      unset($tag['#attributes']['media']);
    }
  }
}

/**
 * Preprocess variables for page.tpl.php
 *
 * @see page.tpl.php
 */
function epe_theme_preprocess_page(&$variables) {

  

  if (isset($variables['page']['content']['system_main']['#attributes']['class'][0])) {
      if ($variables['page']['content']['system_main']['#attributes']['class'][0] == 'contact-form') {
        drupal_set_title('Contact Us');
      }
  }

  if (isset($variables['page']['content']['system_main']['#attributes']['class'][1])) {
      if ($variables['page']['content']['system_main']['#attributes']['class'][1] == 'node-cm_resource-form' && !isset($variables['page']['content']['system_main']['nid']['#value'])) {
        drupal_set_title('Create a Concept Map');
      }
  }

  if (isset($variables['page']['content']['system_main']['#attributes']['class'][1])) {
      if ($variables['page']['content']['system_main']['#attributes']['class'][1] == 'node-ev_resource-form' && !isset($variables['page']['content']['system_main']['nid']['#value'])) {
        drupal_set_title('Create a Custom Visualization Tool');
      }
  }


// print('<pre>');  
// print_r($variables['page']['content']['system_main']['#attributes']['class'][1]);
// print_r(isset($variables['page']['content']['system_main']['nid']['#value']));
// print_r($variables['page']);
// print('</pre>');


  // Add information about the number of sidebars.
  if (!empty($variables['page']['sidebar_first']) && !empty($variables['page']['sidebar_second'])) {
    $variables['columns'] = 3;
  }
  elseif (!empty($variables['page']['sidebar_first'])) {
    $variables['columns'] = 2;
  }
  elseif (!empty($variables['page']['sidebar_second'])) {
    $variables['columns'] = 2;
  }
  else {
    $variables['columns'] = 1;
  }

  // Primary nav
  $variables['primary_nav'] = FALSE;
  if ($variables['main_menu']) {
    // Build links
    $variables['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
    // Provide default theme wrapper function
    $variables['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
  }

  // Secondary nav
  $variables['secondary_nav'] = FALSE;
  if ($variables['secondary_menu']) {
    // Build links
    $variables['secondary_nav'] = menu_tree(variable_get('menu_secondary_links_source', 'user-menu'));
    // Provide default theme wrapper function
    $variables['secondary_nav']['#theme_wrappers'] = array('menu_tree__secondary');
  }

}

/**
 * theme wrapper function for the primary menu links
 */
function epe_theme_menu_tree__primary(&$variables) {
  return '<ul class="menu nav">' . $variables['tree'] . '</ul>';
}

/**
 * theme wrapper function for the secondary menu links
 */
function epe_theme_menu_tree__secondary(&$variables) {
  return '<ul class="menu nav pull-right">' . $variables['tree'] . '</ul>';
}

/**
 * Returns HTML for a single local action link.
 *
 * This function overrides theme_menu_local_action() to add the icons that ship
 * with Bootstrap to the action links.
 *
 * @param $variables
 *   An associative array containing:
 *   - element: A render element containing:
 *     - #link: A menu link array with "title", "href", "localized_options", and
 *       "icon" keys. If "icon" is not passed, it defaults to "plus-sign".
 *
 * @ingroup themeable
 *
 * @see theme_menu_local_action().
 */
function epe_theme_menu_local_action($variables) {
  $link = $variables['element']['#link'];

  // Build the icon rendering element.
  if (empty($link['icon'])) {
    $link['icon'] = 'plus-sign';
  }
  $icon = '<i class="' . drupal_clean_css_identifier('icon-' . $link['icon']) . '"></i>';

  // Format the action link.
  $output = '<li>';
  if (isset($link['href'])) {
    $options = isset($link['localized_options']) ? $link['localized_options'] : array();

    // If the title is not HTML, sanitize it.
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }

    // Force HTML so we can add the icon rendering element.
    $options['html'] = TRUE;
    $output .= l($icon . $link['title'], $link['href'], $options);
  }
  elseif (!empty($link['localized_options']['html'])) {
    $output .= $icon . $link['title'];
  }
  else {
    $output .= $icon . check_plain($link['title']);
  }
  $output .= "</li>\n";

  return $output;
}




function epe_theme_preprocess_node(&$variables) {
  if ($variables['submitted']) {
    $variables['submitted'] = t('NOTSubmitted by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['date']));
  }

  if($variables['teaser'] || $variables['view_mode'] == 'teaser') {
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__teaser';
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->nid . '__teaser';
  }

  if($variables['view_mode'] == 'llb_instructor') {
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__llb_instructor';
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->nid . '__llb_instructor';
  }
}


/**
 * Preprocess variables for region.tpl.php
 *
 * @see region.tpl.php
 */
function epe_theme_preprocess_region(&$variables, $hook) {
  if ($variables['region'] == 'content') {
    $variables['theme_hook_suggestions'][] = 'region__no_wrapper';
  }

  if ($variables['region'] == "sidebar_first") {
    $variables['classes_array'][] = 'well';
  }
}

/**
 * Preprocess variables for block.tpl.php
 *
 * @see block.tpl.php
 */
function epe_theme_preprocess_block(&$variables, $hook) {
  //$variables['classes_array'][] = 'row';
  // Use a bare template for the page's main content.
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'][] = 'block__no_wrapper';
  }
  $variables['title_attributes_array']['class'][] = 'block-title';
}

/**
 * Override or insert variables into the block templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
function epe_theme_process_block(&$variables, $hook) {
  // Drupal 7 should use a $title variable instead of $block->subject.
  $variables['title'] = $variables['block']->subject;
}

/**
 * Returns the correct span class for a region
 */
function _epe_theme_content_span($columns = 1) {
  $class = FALSE;

  switch($columns) {
    case 1:
      $class = 'span12';
      break;
    case 2:
      $class = 'span9';
      break;
    case 3:
      $class = 'span6';
      break;
  }

  return $class;
}

/**
 * Adds the search form's submit button right after the input element.
 *
 * @ingroup themable
 */
function epe_theme_bootstrap_search_form_wrapper(&$variables) {
  $output = '<div class="input-append">';
  $output .= $variables['element']['#children'];
  $output .= '<button type="submit" class="btn">';
  $output .= '<i class="icon-search"></i>';
  $output .= '<span class="element-invisible">' . t('Search') . '</span>';
  $output .= '</button>';
  $output .= '</div>';
  return $output;
 }


function epe_theme_preprocess_html(&$variables) {
  drupal_add_js(array('epe'=>array('base_path'=>base_path())),'setting');

  drupal_add_js(libraries_get_path('underscore') . '/underscore-min.js',array('every_page'=>TRUE,'external'=>TRUE));
  drupal_add_js(libraries_get_path('jquery.session') . '/jquery.session.js',array('every_page'=>TRUE,'external'=>TRUE));
}


