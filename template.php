<?php


/**
 * Implements hook_theme().
 */

function honduras_theme() {
  $return = array();

  $return['honduras_menu_link'] = array(
    'variables' => array('link' => NULL),
    'function' => 'theme_honduras_menu_link',
  );
  return $return;
}

/**
 * Implements template_preprocess_html().
 *
 */

function honduras_preprocess_html(&$variables) {
    /**
     * Add Color module hooks
     */
    if (module_exists('color')) {
      _color_page_alter($variables);
    }
    
    // Add conditional CSS for IE. To use uncomment below and add IE css file
    drupal_add_css(path_to_theme() . '/css/ie.css', array('weight' => CSS_THEME, 'browsers' => array('!IE' => FALSE), 'preprocess' => FALSE));
    // Need legacy support for IE downgrade to Foundation 2 or use JS file below
    drupal_add_js('http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js', 'external');
}


/**
 * Implements hook_preprocess_page
 */

function honduras_preprocess_page(&$variables) {
    /**
     * Add Color module hooks
     */
    if (module_exists('color')) {
      _color_page_alter($variables);
    }
  
  /*
  * Adding jquery.lazy for image rendering
  */
  drupal_add_js(drupal_get_path('theme', 'honduras') .'/js/bejavior/jquery.lazy.js');

  /*
  * Adding social media links for themes headers
  */
  
  $variables['icon_using']  = variable_get('icon_using');
  $variables['facebook']  = variable_get('facebook');  
  $variables['twitter']  = variable_get('twitter');  
  $variables['pinterest']  = variable_get('pinterest');  
  $variables['instagram']  = variable_get('instagram');  

  if($variables['icon_using'] === 1){

      if(!empty($variables['facebook'])){
        $variables['facebook_url']    = "<a id='facebook_icon' href='" . variable_get('facebook') ."' target='_blank'>facebook</a>";
      }
      
      if(!empty($variables['twitter'])){
        $variables['twitter_url']     = "<a id='twitter_icon' href='" . variable_get('twitter')."' target='_blank'>twitter</a>";
      }

      if(!empty($variables['pinterest'])){
        $variables['pinterest_url']   = "<a id='pinterest_icon' href='" . variable_get('pinterest')."' target='_blank'>pinterest</a>";
      }

      if(!empty($variables['instagram'])){
        $variables['instagram_url']   = "<a id='instagram_icon' href='" . variable_get('instagram')."' target='_blank'>instagram</a>";
      }

  } else {
      $variables['icon_using']  = NULL;
      $variables['facebook_url']  = NULL;
      $variables['twitter_url']   = NULL;
      $variables['pinterest_url'] = NULL;
      $variables['instagram_url'] = NULL;
  }
}


/**
 * Implements theme_links() targeting the main menu specifically.
 * Formats links for Top Bar http://foundation.zurb.com/docs/components/top-bar.html
 */
function honduras_links__topbar_main_menu($variables) {
  // We need to fetch the links ourselves because we need the entire tree.
  $links = menu_tree_output(menu_tree_all_data(variable_get('menu_main_links_source', 'main-menu')));
  
  $i = 1;
  foreach ($links as $key => $value) {
    if(is_numeric($key)){
      $links[$key]['#attributes']['class'][] = 'color-'. $i;
      $i++;
    }
  }
  $output = _honduras_links($links);
    $variables['attributes']['class'][] = 'right';

  return '<ul' . drupal_attributes($variables['attributes']) . '>' . $output . '</ul>';
}


function _honduras_links($links) {
  $output = '';

  foreach (element_children($links) as $key) {
    $output .= _honduras_render_link($links[$key]);
  }

  return $output;
}

/**
 * Implements theme_links() targeting the secondary menu specifically.
 * Formats links for Top Bar http://foundation.zurb.com/docs/components/top-bar.html
 */
function honduras_links__topbar_secondary_menu($variables) {
  // We need to fetch the links ourselves because we need the entire tree.
  $links = menu_tree_output(menu_tree_all_data(variable_get('menu_secondary_links_source', 'user-menu')));
  $output = _zurb_foundation_links($links);
  $variables['attributes']['class'][] = 'left';

  return '<ul' . drupal_attributes($variables['attributes']) . '>' . $output . '</ul>';
}


/**
 * Helper function to recursively render sub-menus.
 *
 * @param array
 *   An array of menu links.
 *
 * @return string
 *   A rendered list of links, with no <ul> or <ol> wrapper.
 *
 * @see _zurb_foundation_links()
 */
function _honduras_render_link($link) {
  $output = '';

  // This is a duplicate link that won't get the dropdown class and will only
  // show up in small-screen.
  $small_link = $link;

  if (!empty($link['#below'])) {
    $link['#attributes']['class'][] = 'has-dropdown';
  }

  // Render top level and make sure we have an actual link.
  if (!empty($link['#href'])) {
    $rendered_link = NULL;

    // Foundation offers some of the same functionality as Special Menu Items;
    // ie: Dividers and Labels in the top bar. So let's make sure that we
    // render them the Foundation way.
    if (module_exists('special_menu_items')) {
      if ($link['#href'] === '<nolink>') {
        $rendered_link = '<label>' . $link['#title'] . '</label>';
      }
      else if ($link['#href'] === '<separator>') {
        $link['#attributes']['class'][] = 'divider';
        $rendered_link = '';
      }
    }

    if (!isset($rendered_link)) {
      $rendered_link = theme('honduras_menu_link', array('link' => $link));
    }

    // Test for localization options and apply them if they exist.
    if (isset($link['#localized_options']['attributes']) && is_array($link['#localized_options']['attributes'])) {
      $link['#attributes'] = array_merge($link['#attributes'], $link['#localized_options']['attributes']);
    }
    $output .= '<li' . drupal_attributes($link['#attributes']) . '>' . $rendered_link;

    if (!empty($link['#below'])) {
      // Add repeated link under the dropdown for small-screen.
      $small_link['#attributes']['class'][] = 'show-for-small';
      $sub_menu = '<li' . drupal_attributes($small_link['#attributes']) . '>' . l($link['#title'], $link['#href'], $link['#localized_options']);

      // Build sub nav recursively.
      foreach ($link['#below'] as $sub_link) {
        if (!empty($sub_link['#href'])) {
          $sub_menu .= _zurb_foundation_render_link($sub_link);
        }
      }

      $output .= '<ul class="dropdown">' . $sub_menu . '</ul>';
    }

    $output .=  '</li>';
  }

  return $output;
}

/**
 * Theme function to render a single top bar menu link.
 */
function theme_honduras_menu_link($variables) {
  $link = $variables['link'];
  
  if( $link['#original_link']['plid'] == 0  &&  isset( $link['#localized_options']['menu_icon_awesome'] ) ){
    $link['#localized_options']['html'] = TRUE;
    $link['#localized_options']['attributes']['class'][] = 'has-icon';

    return l( '<i class="fa ' . $link['#localized_options']['menu_icon_awesome'] . '"></i>' 
           . $link['#title'], $link['#href'], $link['#localized_options']);
  
  }else{
    return l( $link['#title'], $link['#href'], $link['#localized_options'] );
  }

}


/**
 * Implements template_preprocess_page
 *
 */




/**
 * Implements template_preprocess_node
 *
 */
//function honduras_preprocess_node(&$variables) {
//}

/**
 * Implements hook_preprocess_block()
 */
//function honduras_preprocess_block(&$variables) {
//  // Add wrapping div with global class to all block content sections.
//  $variables['content_attributes_array']['class'][] = 'block-content';
//
//  // Convenience variable for classes based on block ID
//  $block_id = $variables['block']->module . '-' . $variables['block']->delta;
//
//  // Add classes based on a specific block
//  switch ($block_id) {
//    // System Navigation block
//    case 'system-navigation':
//      // Custom class for entire block
//      $variables['classes_array'][] = 'system-nav';
//      // Custom class for block title
//      $variables['title_attributes_array']['class'][] = 'system-nav-title';
//      // Wrapping div with custom class for block content
//      $variables['content_attributes_array']['class'] = 'system-nav-content';
//      break;
//
//    // User Login block
//    case 'user-login':
//      // Hide title
//      $variables['title_attributes_array']['class'][] = 'element-invisible';
//      break;
//
//    // Example of adding Foundation classes
//    case 'block-foo': // Target the block ID
//      // Set grid column or mobile classes or anything else you want.
//      $variables['classes_array'][] = 'six columns';
//      break;
//  }
//
//  // Add template suggestions for blocks from specific modules.
//  switch($variables['elements']['#block']->module) {
//    case 'menu':
//      $variables['theme_hook_suggestions'][] = 'block__nav';
//    break;
//  }
//}

//function honduras_preprocess_views_view(&$variables) {
//}

/**
 * Implements template_preprocess_panels_pane().
 *
 */
//function honduras_preprocess_panels_pane(&$variables) {
//}

/**
 * Implements template_preprocess_views_views_fields().
 *
 */
//function honduras_preprocess_views_view_fields(&$variables) {
//}

/**
 * Implements theme_form_element_label()
 * Use foundation tooltips
 */
//function honduras_form_element_label($variables) {
//  if (!empty($variables['element']['#title'])) {
//    $variables['element']['#title'] = '<span class="secondary label">' . $variables['element']['#title'] . '</span>';
//  }
//  if (!empty($variables['element']['#description'])) {
//    $variables['element']['#description'] = ' <span data-tooltip="top" class="has-tip tip-top" data-width="250" title="' . $variables['element']['#description'] . '">' . t('More information?') . '</span>';
//  }
//  return theme_form_element_label($variables);
//}

/**
 * Implements hook_preprocess_button().
 */
//function honduras_preprocess_button(&$variables) {
//  $variables['element']['#attributes']['class'][] = 'button';
//  if (isset($variables['element']['#parents'][0]) && $variables['element']['#parents'][0] == 'submit') {
//    $variables['element']['#attributes']['class'][] = 'secondary';
//  }
//}

/**
 * Implements hook_form_alter()
 * Example of using foundation sexy buttons
 */
//function honduras_form_alter(&$form, &$form_state, $form_id) {
//  // Sexy submit buttons
//  if (!empty($form['actions']) && !empty($form['actions']['submit'])) {
//    $classes = (is_array($form['actions']['submit']['#attributes']['class']))
//      ? $form['actions']['submit']['#attributes']['class']
//      : array();
//    $classes = array_merge($classes, array('secondary', 'button', 'radius'));
//    $form['actions']['submit']['#attributes']['class'] = $classes;
//  }
//}

/**
 * Implements hook_form_FORM_ID_alter()
 * Example of using foundation sexy buttons on comment form
 */
//function honduras_form_comment_form_alter(&$form, &$form_state) {
  // Sexy preview buttons
//  $classes = (is_array($form['actions']['preview']['#attributes']['class']))
//    ? $form['actions']['preview']['#attributes']['class']
//    : array();
//  $classes = array_merge($classes, array('secondary', 'button', 'radius'));
//  $form['actions']['preview']['#attributes']['class'] = $classes;
//}


/**
 * Implements template_preprocess_panels_pane().
 */
// function zurb_foundation_preprocess_panels_pane(&$variables) {
// }

/**
* Implements template_preprocess_views_views_fields().
*/
/* Delete me to enable
function THEMENAME_preprocess_views_view_fields(&$variables) {
 if ($variables['view']->name == 'nodequeue_1') {

   // Check if we have both an image and a summary
   if (isset($variables['fields']['field_image'])) {

     // If a combined field has been created, unset it and just show image
     if (isset($variables['fields']['nothing'])) {
       unset($variables['fields']['nothing']);
     }

   } elseif (isset($variables['fields']['title'])) {
     unset ($variables['fields']['title']);
   }

   // Always unset the separate summary if set
   if (isset($variables['fields']['field_summary'])) {
     unset($variables['fields']['field_summary']);
   }
 }
}

// */

/**
 * Implements hook_css_alter().
 */
//function honduras_css_alter(&$css) {
//  // Always remove base theme CSS.
//  $theme_path = drupal_get_path('theme', 'zurb_foundation');
//
//  foreach($css as $path => $values) {
//    if(strpos($path, $theme_path) === 0) {
//      unset($css[$path]);
//    }
//  }
//}

/**
 * Implements hook_js_alter().
 */
//function honduras_js_alter(&$js) {
//  // Always remove base theme JS.
//  $theme_path = drupal_get_path('theme', 'zurb_foundation');
//
//  foreach($js as $path => $values) {
//    if(strpos($path, $theme_path) === 0) {
//      unset($js[$path]);
//    }
//  }
//}
