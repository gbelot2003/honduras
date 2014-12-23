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

	$form['icons_handler'] = array(
      '#type' => 'vertical_tabs',
      '#weight' => -10,
    );

	$form['zurb_foundation']['icons_handler']['Social Media'] = array(
      '#type' => 'fieldset',
      '#title' => t("Add Media URL's"),
	);

	$form['zurb_foundation']['icons_handler']['Social Media']['icon_using'] = array(
		'#type' => 'checkbox',
		'#title' => 'Enable Icons Social',
		'#description' => 'Will you use the Icon Social Url manager?',
		'#default_value' => theme_get_setting('icon_using')
	);


	$form['zurb_foundation']['icons_handler']['Social Media']['content'] = array(
	 	'#type' => 'container',
	 	'#states' => array(
	 		'checked' => array(
	 			'#edit-icon-using' => array('expanded' => true),
	 		),
	 	),
	);

	$form['zurb_foundation']['icons_handler']['Social Media']['content']['facebook'] = array(
		'#type' => 'textfield',
		'#title' => t('Facebook Url'),
		'#description' => t('Add here the Facebook url for honduras.travel, please use full URL <strong>https://facebook.com/url</strong>'),
		'#default_value' => theme_get_setting('facebook')
	);

	$form['zurb_foundation']['icons_handler']['Social Media']['content']['twitter'] = array(
		'#type' => 'textfield',
		'#title' => t('Twitter Url'),
		'#description' => t('Add here the twitter url for honduras.travel'),
		'#default_value' => theme_get_setting('twitter')
	);

	$form['zurb_foundation']['icons_handler']['Social Media']['content']['instagram'] = array(
		'#type' => 'textfield',
		'#title' => t('Instagram Url'),
		'#description' => t('Add here the Instagram url for honduras.travel'),
		'#default_value' => theme_get_setting('instagram')
	);

	$form['zurb_foundation']['icons_handler']['Social Media']['content']['pinterest'] = array(
		'#type' => 'textfield',
		'#title' => t('Pinterest Url'),
		'#description' => t('Add here the Pinterest url for honduras.travel'),
		'#default_value' => theme_get_setting('pinterest')
	);

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
}
