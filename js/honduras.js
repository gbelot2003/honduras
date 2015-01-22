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
            $('.views-field-field-ref-servicios li').addClass('list-inline');
            $('.views-field-field-ref-servicios a:contains("Air Conditioning")').empty().append("<i class='icon fa-air'></i>");
            $('.views-field-field-ref-servicios a:contains("Aire Acondicionado")').empty().append("<i class='icon fa-air'></i>");

            $('.views-field-field-ref-servicios a:contains("Bar/Restaurant")').empty().append("<i class='icon fa-bar'></i>");
            $('.views-field-field-ref-servicios a:contains("Bar/Restaurante")').empty().append("<i class='icon fa-bar'></i>");

            $('.views-field-field-ref-servicios a:contains("Boat Tours")').empty().append("<i class='icon fa-boat'></i>");
            $('.views-field-field-ref-servicios a:contains("Paseos en Lancha")').empty().append("<i class='icon fa-boat'></i>");

            $('.views-field-field-ref-servicios a:contains("Laundry")').empty().append("<i class='icon fa-laundry'></i>");
            $('.views-field-field-ref-servicios a:contains("Lavanderia")').empty().append("<i class='icon fa-laundry'></i>");

            $('.views-field-field-ref-servicios a:contains("Meeting Room")').empty().append("<i class='icon fa-meeting'></i>");
            $('.views-field-field-ref-servicios a:contains("Salón de Reuniones")').empty().append("<i class='icon fa-meeting'></i>");

            $('.views-field-field-ref-servicios a:contains("Parking")').empty().append("<i class='icon fa-parking'></i>");
            $('.views-field-field-ref-servicios a:contains("Parqueo")').empty().append("<i class='icon fa-parking'></i>");

            $('.views-field-field-ref-servicios a:contains("Pool")').empty().append("<i class='icon fa-pool'></i>");
            $('.views-field-field-ref-servicios a:contains("Pisina")').empty().append("<i class='icon fa-pool'></i>");

            $('.views-field-field-ref-servicios a:contains("Room Service")').empty().append("<i class='icon fa-room'></i>");
            $('.views-field-field-ref-servicios a:contains("Servicio a la Habitación")').empty().append("<i class='icon fa-room'></i>");

            $('.views-field-field-ref-servicios a:contains("Store")').empty().append("<i class='icon fa-store'></i>");
            $('.views-field-field-ref-servicios a:contains("Tienda")').empty().append("<i class='icon fa-store'></i>");

            $('.views-field-field-ref-servicios a:contains("Terrace View")').empty().append("<i class='icon fa-terrace'></i>");
            $('.views-field-field-ref-servicios a:contains("Terraza con vista")').empty().append("<i class='icon fa-terrace'></i>");

            $('.views-field-field-ref-servicios a:contains("Wi-Fi")').empty().append("<i class='icon fa-wifi'></i>");

            var ids = '.views-field-field-ref-servicios a';
            $(ids).click(function(event) {event.preventDefault();});
        });
    }
  };

})(jQuery, Drupal);
