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
 * [honduras_block_list_alter description]
 * @param  [type] &$blocks [description]
 * @return [type]          [description]
 *
 * Removing content on frontPage
 * 
 */
function honduras_block_list_alter(&$blocks) {
  if (drupal_is_front_page()) {
    foreach ($blocks as $key => $block) {
      if ($block->module == 'system' && $block->delta == 'main') {
        unset($blocks[$key]);
      }
    }

    drupal_set_page_content();
  }
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
 
  /**
   * Setting greed for main page 
   */

  if (drupal_is_front_page()) {
    $variables['main_grid'] = 'large-12';  
    unset($variables['sidebar_first_grid']);
    unset($variables['sidebar_sec_grid']);    
  }
  
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
        $variables['facebook_url']    = "<a id='facebook_icon' title='facebook' href='" . variable_get('facebook') ."' target='_blank'><i class='fa-facebook'></i></a>";
      }
      
      if(!empty($variables['twitter'])){
        $variables['twitter_url']     = "<a id='twitter_icon' title='twitter' href='" . variable_get('twitter')."' target='_blank'><i class='fa-twitter'></i></a>";
      }

      if(!empty($variables['pinterest'])){
        $variables['pinterest_url']   = "<a id='pinterest_icon' title='pinterest' href='" . variable_get('pinterest')."' target='_blank'><i class='fa-pinterest'></i></a>";
      }

      if(!empty($variables['instagram'])){
        $variables['instagram_url']   = "<a id='instagram_icon' title='instagram' href='" . variable_get('instagram')."' target='_blank'><i class='fa-instagram'></i></a>";
      }

  } else {
      $variables['icon_using']  = NULL;
      $variables['facebook_url']  = NULL;
      $variables['twitter_url']   = NULL;
      $variables['pinterest_url'] = NULL;
      $variables['instagram_url'] = NULL;
  }

  /**
   * Remove anoin default taxonomy listing
   */

  if(arg(0) == "taxonomy" && arg(1) == "term") {
    $variables['page']['content']['system_main']['nodes'] = null;
    unset($variables['page']['content']['system_main']['no_content']);
    unset($variables['page']['content']['system_main']['pager']);
  }


  
}

  /**
   * [hook_preprocess_node description]
   * @param  [type] &$variables [description]
   * @return [type]             [description]
   */
  
function honduras_preprocess_node(&$variables){
   
   /**
   * Adding secction clases to body 
   */
  
    $node = $variables["node"];
    if(isset($node->field_turistic_section['und'][0]["taxonomy_term"])){
      foreach ($node->field_turistic_section["und"] as $foo){
        $term = $foo["taxonomy_term"];
        $variables["classes_array"][] = "term-" . str_replace(" ", "-", strtolower($term->name));
      }
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


function honduras_links__system_explore_honduras_menu(&$variables){
  $output = '';

  foreach ($variables['links'] as $link) {
    dpm($links);
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
 * [honduras_links__locale_block description]
 * @param  [type] &$vars [description]
 * @return [type]        [description]
 */

function honduras_links__locale_block(&$variables) {
  // an array of list items
  $items = array();
  foreach($variables['links'] as $language => $info) 
  {
    $name = $info['language']->native;
    $href = isset($info['href']) ? $info['href'] : '';
    $li_classes = array('list-inline');
    $link_classes = array('link-class1');
    $options = array('attributes' => array('class' => $link_classes), 'language' => $info['language'], 'html' => true);
    $link = l($name, $href, $options);
    // display only translated links
    if ($href) $items[] = array('data' => $link, 'class' => $li_classes);
  }
    // output
    $attributes = array('class' => array('horizontal-list-right'));   
    $output = theme_item_list(array('items' => $items, 'title' => '', 'type'  => 'ul', 'attributes' => $attributes ));
    return $output;
}

/**
 * Implement function block_render to enable automaticly languages swich
 */

function block_render($module, $block_id) {
  $block = block_load($module, $block_id);
  $block_content = _block_render_blocks(array($block));
  $build = _block_get_renderable_array($block_content);
  $block_rendered = drupal_render($build);
  return $block_rendered;
}


function honduras_field__taxonomy_term_reference(&$variables){
    global $language;

    if($variables['element']['#field_name'] == 'field_rel_explorar'){
      $fts = $variables['element']['#object']->field_turistic_section['und'][0]['tid'];
      $lang = $language->language;
      $newurl = set_section_value($fts, $lang);

      $output = '';
      // Render the label, if it's not hidden.
      if (!$variables['label_hidden']) {
        $output .= '<h3 class="field-label">' . $variables['label'] . ': </h3>';
      }
      // Render the items.
      $output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links rel-explorar">';
      foreach ($variables['items'] as $delta => $item) {
        // allow html
        $item['#options']['html'] = TRUE;
        
        // set class for span 
        $cclass = trim($item['#title']);
        $iclass = "fa-" . strtolower(str_replace('í', 'i', $cclass));

        // set contextual url
        $explore = 'explore';
        if($variables['element']['#object']->language == 'es'){
          $explore = 'explorar';
        }
        $term = strtolower($cclass);
        $termName = str_replace(' ', '-', $term);


        $item['#href'] = $explore .'/'. $newurl . '/' . $termName;
        // set html
        $item['#title'] = '<i data-tooltip aria-haspopup="true" class="icon '.$iclass.' has-tip" data-options="show_on:large" title="' . $item['#title'] .'"></i>';
        $output .= '<li class="list-inline taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
      }
      
      $output .= '</ul>';
      // Render the top-level DIV.
      $output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '"' . $variables['attributes'] .'>' . $output . '</div>';
      return $output;

    } else {
        $output = '';
        // Render the label, if it's not hidden.
        if (!$variables['label_hidden']) {
          $output .= '<h3 class="field-label">' . $variables['label'] . ': </h3>';
        }
        // Render the items.
        $output .= ($variables['element']['#label_display'] == 'inline') ? '<ul class="links inline">' : '<ul class="links">';
        foreach ($variables['items'] as $delta => $item) {
          // allow html
          $item['#options']['html'] = TRUE;
          // set html
          $output .= '<li class="taxonomy-term-reference-' . $delta . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</li>';
        }
        $output .= '</ul>';
        // Render the top-level DIV.
        $output = '<div class="' . $variables['classes'] . (!in_array('clearfix', $variables['classes_array']) ? ' clearfix' : '') . '"' . $variables['attributes'] .'>' . $output . '</div>';
        return $output;
    }
}

function set_section_value($variable, $lang){

    switch ($variable) {
      case 256:
        if($lang == 'en'){
          $name = 'copan-ruinas-and-west';
        } else {
          $name = 'copán-ruinas-y-occidente';
        }
        return $name;
      break;

      case 253:
        $name = 'atlantida';
        return $name;
      break;

      case 258:
        $name = 'san-pedro-sula';
        return $name;
      break;

      case 259:
        $name = 'tegucigalpa';
          return $name;
      break;

      case 257:
        if($lang == 'en'){
          $name = 'others';
        } else {
          $name = 'otros';
        }

        return $name;
      break;

      case 255:
        if($lang == 'en'){
          $name = 'lake-yojoa';
        } else {
          $name = 'lago-de-yojoa';
        }
        return $name;
      break;

      case 254:
        if($lang == 'en'){
          $name = 'bay-island';
        } else {
          $name = 'islas-de-la-bahia';
        }
        return $name;
      break;

      default:
        $name = 'honduras';
        return $name;
      break;
    }
}

function honduras_url_outbound_alter(&$path, &$options, $original_path) {
    $alias = drupal_get_path_alias($original_path);
    $url = parse_url($alias);
    //dpm($original_path);
    if (isset($url['fragment'])){
        //set path without the fragment
        $path = $url['path'];

        //prevent URL from re-aliasing
        $options['alias'] = TRUE;

        //set fragment
        $options['fragment'] = $url['fragment'];
    }
}
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