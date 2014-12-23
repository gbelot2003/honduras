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

	$form['zurb_foundation']['icons_handler']['Social Media']['facebook'] = array(
		'#type' => 'textfield',
		'#title' => t('Facebook Url'),
		'#description' => t('Add here the Facebook url for honduras.travel'),
		'#default_value' => theme_get_setting('facebook')
	);

	$form['zurb_foundation']['icons_handler']['Social Media']['twitter'] = array(
		'#type' => 'textfield',
		'#title' => t('Twitter Url'),
		'#description' => t('Add here the twitter url for honduras.travel'),
		'#default_value' => theme_get_setting('twitter')
	);

	$form['zurb_foundation']['icons_handler']['Social Media']['instagram'] = array(
		'#type' => 'textfield',
		'#title' => t('Instagram Url'),
		'#description' => t('Add here the Instagram url for honduras.travel'),
		'#default_value' => theme_get_setting('instagram')
	);

	$form['zurb_foundation']['icons_handler']['Social Media']['pinterest'] = array(
		'#type' => 'textfield',
		'#title' => t('Pinterest Url'),
		'#description' => t('Add here the Pinterest url for honduras.travel'),
		'#default_value' => theme_get_setting('pinterest')
	);

	$form['#submit'][] = 'honduras_form_system_theme_settings_submit';

	return $form;
}

function honduras_form_system_theme_settings_submit(&$form, &$form_state){

	if(!$form_state['value']['Facebook']){
		variable_set('Facebook', $form_state['values']['facebook']);
		variable_set('twitter', $form_state['values']['twitter']);
		variable_set('twitter', $form_state['values']['instagram']);
		variable_set('twitter', $form_state['values']['pinterest']);

	} else {
		drupal_set_message(t('No data has been send, you posibli have a Problem with the post data'));
	}
}
