(function ($, Drupal) {

  Drupal.behaviors.honduras = {
    attach: function(context, settings) {
    	$(document).ready(function(){
    		$('#block-locale-language a:contains("Español")').addClass('esp');
    		$('#block-locale-language a:contains("English")').addClass('eng');
    	});
    }
  };

})(jQuery, Drupal);
