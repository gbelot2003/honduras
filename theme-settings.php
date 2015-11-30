<?php
/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 */
function honduras_form_system_theme_settings_alter(&$form, &$form_state) {

	$form['icons_handler'] = [
      '#type' => 'vertical_tabs',
      '#weight' => -10,
    ];

	$form['zurb_foundation']['icons_handler']['Social Media'] = [
      '#type' => 'fieldset',
      '#title' => t("Add Media URL's"),
	];

	$form['zurb_foundation']['icons_handler']['Social Media']['icon_using'] = [
		'#type' => 'checkbox',
		'#title' => 'Enable Icons Social',
		'#description' => 'Will you use the Icon Social Url manager?',
		'#default_value' => theme_get_setting('icon_using')
	];


	$form['zurb_foundation']['icons_handler']['Social Media']['content'] = [
	 	'#type' => 'container',
	 	'#states' => [
	 		'checked' => [
	 			'#edit-icon-using' => ['expanded' => true],
	 		],
	 	],
	];

	$form['zurb_foundation']['icons_handler']['Social Media']['content']['facebook'] = [
		'#type' => 'textfield',
		'#title' => t('Facebook Url'),
		'#description' => t('Add here the Facebook url for honduras.travel, please use full URL <strong>https://facebook.com/url</strong>'),
		'#default_value' => theme_get_setting('facebook')
	];

	$form['zurb_foundation']['icons_handler']['Social Media']['content']['twitter'] = [
		'#type' => 'textfield',
		'#title' => t('Twitter Url'),
		'#description' => t('Add here the twitter url for honduras.travel'),
		'#default_value' => theme_get_setting('twitter')
	];

	$form['zurb_foundation']['icons_handler']['Social Media']['content']['instagram'] = [
		'#type' => 'textfield',
		'#title' => t('Instagram Url'),
		'#description' => t('Add here the Instagram url for honduras.travel'),
		'#default_value' => theme_get_setting('instagram')
	];

	$form['zurb_foundation']['icons_handler']['Social Media']['content']['pinterest'] = [
		'#type' => 'textfield',
		'#title' => t('Pinterest Url'),
		'#description' => t('Add here the Pinterest url for honduras.travel'),
		'#default_value' => theme_get_setting('pinterest')
	];

	/**
	** Front Images manager
	**/

	$form['front_images'] = [
		'#type' => 'vertical_tabs',
		'#weight' => -11,
	];

	$form['zurb_foundation']['front_images']['Images Manager'] = [
		'#type' => 'fieldset',
		'#title' => t("Front Images Manager"),
	];

	$form['zurb_foundation']['front_images']['Images Manager']['content']['honduras'] = [
		'#type' => 'textfield',
		'#title' => t('Front Image Url'),
		'#description' => t('Add here the front-page image for honduras.travel'),
		'#default_value' => variable_get('honduras_front')
	];

	$form['zurb_foundation']['front_images']['Images Manager']['content']['atlantida'] = [
		'#type' => 'textfield',
		'#title' => t('Atlantida image Url'),
		'#description' => t('Add here the front-page image for Atlantida'),
		'#default_value' => variable_get('atlantida_front')
	];

	$form['zurb_foundation']['front_images']['Images Manager']['content']['islas'] = [
		'#type' => 'textfield',
		'#title' => t('Islas image Url'),
		'#description' => t('Add here the front-page image for Islas'),
		'#default_value' => variable_get('islas_front')
	];

	$form['zurb_foundation']['front_images']['Images Manager']['content']['occidente'] = [
		'#type' => 'textfield',
		'#title' => t('Occidente image Url'),
		'#description' => t('Add here the front-page image for Occidente'),
		'#default_value' => variable_get('occidente_front')
	];

	$form['zurb_foundation']['front_images']['Images Manager']['content']['otros'] = [
		'#type' => 'textfield',
		'#title' => t('Otros image Url'),
		'#description' => t('Add here the front-page image for Otros'),
		'#default_value' => variable_get('otros_front')
	];

	$form['zurb_foundation']['front_images']['Images Manager']['content']['sanpedro'] = [
		'#type' => 'textfield',
		'#title' => t('San Pedro image Url'),
		'#description' => t('Add here the front-page image for San Pedro Sula'),
		'#default_value' => variable_get('sanpedro_front')
	];

	$form['zurb_foundation']['front_images']['Images Manager']['content']['tegus'] = [
		'#type' => 'textfield',
		'#title' => t('Tegucigalpa image Url'),
		'#description' => t('Add here the front-page image for Tegucigalpa'),
		'#default_value' => variable_get('tegus_front')
	];

	$form['zurb_foundation']['front_images']['Images Manager']['content']['yojoa'] = [
		'#type' => 'textfield',
		'#title' => t('Yojoa lake image Url'),
		'#description' => t('Add here the front-page image for Yojoa'),
		'#default_value' => variable_get('yojoa_front')
	];

	$form['#submit'][] = 'honduras_form_system_theme_settings_submit';

	return $form;
}

function honduras_form_system_theme_settings_submit(&$form, &$form_state){
	
	if (intval($form_state['values']['icon_using'])) {
    	variable_set('icon_using', intval($form_state['values']['icon_using']));
    	drupal_set_message(t('Icons Enabled.'));
    }
	
	if ($form_state['values']['facebook']) {
    	variable_set('facebook', $form_state['values']['facebook']);
    	drupal_set_message(t('Facebook Saved.'));
    } elseif(empty($form_state['values']['facebook'])){
    	variable_set('facebook', NULL);
    }

	if ($form_state['values']['twitter']) {
    	variable_set('twitter', $form_state['values']['twitter']);
    	drupal_set_message(t('Twitter Saved.'));
    } elseif(empty($form_state['values']['twitter'])){
    	variable_set('twitter', NULL);
    }

	if ($form_state['values']['instagram']) {
    	variable_set('instagram', $form_state['values']['instagram']);
    	drupal_set_message(t('Instagram Saved.'));
    } elseif(empty($form_state['values']['instagram'])){
    	variable_set('instagram', NULL);
    }

    if ($form_state['values']['pinterest']) {
    	variable_set('pinterest', $form_state['values']['pinterest']);
    	drupal_set_message(t('Pinterest Saved.'));
    } elseif (empty($form_state['values']['pinterest'])) {
    	variable_set('pinterest', NULL);	
    }

	/**
	 *
	 */

	if ($form_state['values']['honduras']) {
		variable_set('honduras_front', $form_state['values']['honduras']);
		drupal_set_message(t('honduras image saved.'));
	} elseif (empty($form_state['values']['honduras'])) {
		variable_set('honduras_front', 'bgs_2.jpg');
	}

	if ($form_state['values']['atlantida']) {
		variable_set('atlantida_front', $form_state['values']['atlantida']);
		drupal_set_message(t('Atlantida image saved.'));
	} elseif (empty($form_state['values']['atlantida'])) {
		variable_set('atlantida_front', 'bg_atlantida.jpg');
	}

	if ($form_state['values']['islas']) {
		variable_set('islas_front', $form_state['values']['islas']);
		drupal_set_message(t('Islas image saved.'));
	} elseif (empty($form_state['values']['islas'])) {
		variable_set('islas_front', 'bg_islas.jpg');
	}

	if ($form_state['values']['occidente']) {
		variable_set('occidente_front', $form_state['values']['occidente']);
		drupal_set_message(t('Occidente image saved.'));
	} elseif (empty($form_state['values']['occidente'])) {
		variable_set('occidente_front', 'bg_occidente.jpg');
	}

	if ($form_state['values']['otros']) {
		variable_set('otros_front', $form_state['values']['otros']);
		drupal_set_message(t('Otros image saved.'));
	} elseif (empty($form_state['values']['otros'])) {
		variable_set('otros_front', 'bg_occidente.jpg');
	}

	if ($form_state['values']['sanpedro']) {
		variable_set('sanpedro_front', $form_state['values']['sanpedro']);
		drupal_set_message(t('San Pedro Sula image saved.'));
	} elseif (empty($form_state['values']['sanpedro'])) {
		variable_set('sanpedro_front', 'bg_occidente.jpg');
	}

	if ($form_state['values']['tegus']) {
		variable_set('tegus_front', $form_state['values']['tegus']);
		drupal_set_message(t('Tegucigalpa image saved.'));
	} elseif (empty($form_state['values']['tegus'])) {
		variable_set('tegus_front', 'bg_tegus.jpg');
	}

	if ($form_state['values']['yojoa']) {
		variable_set('yojoa_front', $form_state['values']['yojoa']);
		drupal_set_message(t('Yojoa Lake image saved.'));
	} elseif (empty($form_state['values']['yojoa'])) {
		variable_set('yojoa_front', 'bg_yojoa.jpg');
	}
}

