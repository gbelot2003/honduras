<?php


/**
 * Implements hook_theme().
 */

function honduras_theme() {
  $return = [];

  $return['honduras_menu_link'] = [
    'variables' => ['link' => NULL],
    'function' => 'theme_honduras_menu_link',
  ];
  return $return;
}

/**
 * Implamentation of hook_preprocess_html
* @param $variables
 */

function honduras_preprocess_html(&$variables, $styles) {

    /**
     * Add Color module hooks
     */

    // Add conditional CSS for IE. To use uncomment below and add IE css file
    drupal_add_css(path_to_theme() . '/css/ie.css', ['weight' => CSS_THEME, 'browsers' => ['!IE' => FALSE], 'preprocess' => FALSE]);
    // Need legacy support for IE downgrade to Foundation 2 or use JS file below
    //drupal_add_js('http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js', 'external');
    drupal_add_js(drupal_get_path('theme', 'honduras') ."/js/materialize.js");

}

/**
 * Implement hook_process_html
 * @param $variables
 */
function honduras_process_html(&$variables){
	$variables['styles'] = preg_replace('/\.css\?[^"]+/','.css', $variables['styles']);
}

/**
 * [honduras_form_alter description]
 * @param  [type] &$form       [description]
 * @param  [type] &$form_state [description]
 * @param  [type] $form_id     [description]
 * @return [type]              [description]
 */
function honduras_form_alter(&$form, &$form_state, $form_id){
  //$form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Buscar';}";
  if ($form_id == 'search_block_form') 
  {
    $form['search_block_form']['#attributes']['placeholder'] = t('Search');
    $form['search_block_form']['#attributes']['title'] = t('Ingresa el texto que deseas buscar');
    $form['actions']['#attributes']['class'][] = 'element-invisible';
    unset($form['actions']['submit']);
    //$form['actions']['submit'] = array('#type' => 'image_button', '#src' => base_path() . path_to_theme() . '/images/search.png');
  }
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
  ** Init Lang Variable
  **/
  global $language;
  $lang = $language->language;
    
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

  /**
  ** Front-page services Links
  **/

  if($lang === 'en'){
    $variables['link_hotels'] = 'with-whom/hotels';
    $variables['link_restaurants'] = 'with-whom/restaurants';
    $variables['link_transports'] = 'with-whom/transports';
    $variables['link_diving'] = 'with-whom/diving-centers';
    $variables['link_tours'] = 'with-whom/tour-operators';
  } else {
    $variables['link_hotels'] = 'es/con-quien/hoteles';
    $variables['link_restaurants'] = 'es/con-quien/restaurantes';
    $variables['link_transports'] = 'es/con-quien/transportes';
    $variables['link_diving'] = '';
    $variables['link_tours'] = 'es/con-quien/tour-operadores';
  }

}

/**
 * [honduras_preprocess_node description]
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
 * Override theme image style to remove query string.
 */
function honduras_image_style($variables) {
// Determine the dimensions of the styled image.
	$dimensions = [
		'width' => $variables['width'],
		'height' => $variables['height'],
	];

	image_style_transform_dimensions($variables['style_name'], $dimensions);

	$variables['width'] = $dimensions['width'];
	$variables['height'] = $dimensions['height'];

// Determine the URL for the styled image.
	$variables['path'] = image_style_url($variables['style_name'], $variables['path']);
// Remove query string for image.
	$variables['path'] = preg_replace('/\?.*/', '', $variables['path']);

	return theme('image', $variables);
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
      $rendered_link = theme('honduras_menu_link', ['link' => $link]);
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
  $items = [];
  foreach($variables['links'] as $language => $info) 
  {
    $name = $info['language']->native;
    $href = isset($info['href']) ? $info['href'] : '';
    $li_classes = ['list-inline'];
    $link_classes = ['link-class1'];
    $options = ['attributes' => ['class' => $link_classes], 'language' => $info['language'], 'html' => true];
    $link = l($name, $href, $options);
    // display only translated links
    if ($href) $items[] = ['data' => $link, 'class' => $li_classes];
  }
    // output
    $attributes = ['class' => ['horizontal-list-right']];
    $output = theme_item_list(['items' => $items, 'title' => '', 'type'  => 'ul', 'attributes' => $attributes ]);
    return $output;
}

/**
 * Implement function block_render to enable automaticly languages swich
 */

function block_render($module, $block_id) {
  $block = block_load($module, $block_id);
  $block_content = _block_render_blocks([$block]);
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
