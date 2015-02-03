(function ($, Drupal) {

  Drupal.behaviors.honduras = {
    attach: function(context, settings) {
    	$(document).ready(function(){
    		/**
    		 * Some styling classes
    		 */

    		$('#block-locale-language a:contains("Español")').addClass('esp');
    		$('#block-locale-language a:contains("English")').addClass('eng');

        });

        $(document).ready(function(){
            /**
            ** Add ico classes to views hotels taxonomy
            */
            $('.field-name-field-ref-servicios li').addClass('list-inline');
            $('.field-name-field-ref-servicios a:contains("Air Conditioning")').append("<i class='icon fa-air'></i>");
            $('.field-name-field-ref-servicios a:contains("Aire Acondicionado")').append("<i class='icon fa-air'></i>");

            $('.field-name-field-ref-servicios a:contains("Bar/Restaurant")').append("<i class='icon fa-bar'></i>");
            $('.field-name-field-ref-servicios a:contains("Bar/Restaurante")').append("<i class='icon fa-bar'></i>");

            $('.field-name-field-ref-servicios a:contains("Boat Tours")').append("<i class='icon fa-boat'></i>");
            $('.field-name-field-ref-servicios a:contains("Paseos en Lancha")').append("<i class='icon fa-boat'></i>");

            $('.field-name-field-ref-servicios a:contains("Laundry")').append("<i class='icon fa-laundry'></i>");
            $('.field-name-field-ref-servicios a:contains("Lavanderia")').append("<i class='icon fa-laundry'></i>");

            $('.field-name-field-ref-servicios a:contains("Meeting Room")').append("<i class='icon fa-meeting'></i>");
            $('.field-name-field-ref-servicios a:contains("Salón de Reuniones")').append("<i class='icon fa-meeting'></i>");

            $('.field-name-field-ref-servicios a:contains("Parking")').append("<i class='icon fa-parking'></i>");
            $('.field-name-field-ref-servicios a:contains("Parqueo")').append("<i class='icon fa-parking'></i>");

            $('.field-name-field-ref-servicios a:contains("Pool")').append("<i class='icon fa-pool'></i>");
            $('.field-name-field-ref-servicios a:contains("Pisina")').append("<i class='icon fa-pool'></i>");

            $('.field-name-field-ref-servicios a:contains("Room Service")').append("<i class='icon fa-room'></i>");
            $('.field-name-field-ref-servicios a:contains("Servicio a la Habitación")').append("<i class='icon fa-room'></i>");

            $('.field-name-field-ref-servicios a:contains("Store")').append("<i class='icon fa-store'></i>");
            $('.field-name-field-ref-servicios a:contains("Tienda")').append("<i class='icon fa-store'></i>");

            $('.field-name-field-ref-servicios a:contains("Terrace View")').append("<i class='icon fa-terrace'></i>");
            $('.field-name-field-ref-servicios a:contains("Terraza con vista")').append("<i class='icon fa-terrace'></i>");

            $('.field-name-field-ref-servicios a:contains("Wi-Fi")').append("<i class='icon fa-wifi'></i>");

            var ids = '. a';
            $(ids).click(function(event) {event.preventDefault();});
        });
    }
  };

})(jQuery, Drupal);
