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
            $('.field-name-field-ref-servicios a:contains("Air Conditioning")').prepend("<i class='icon fa-air'></i>");
            $('.field-name-field-ref-servicios a:contains("Aire Acondicionado")').prepend("<i class='icon fa-air'></i>");

            $('.field-name-field-ref-servicios a:contains("Bar/Restaurant")').prepend("<i class='icon fa-bar'></i>");
            $('.field-name-field-ref-servicios a:contains("Bar/Restaurante")').prepend("<i class='icon fa-bar'></i>");

            $('.field-name-field-ref-servicios a:contains("Boat Tours")').prepend("<i class='icon fa-boat'></i>");
            $('.field-name-field-ref-servicios a:contains("Paseos en Lancha")').prepend("<i class='icon fa-boat'></i>");

            $('.field-name-field-ref-servicios a:contains("Laundry")').prepend("<i class='icon fa-laundry'></i>");
            $('.field-name-field-ref-servicios a:contains("Lavanderia")').prepend("<i class='icon fa-laundry'></i>");

            $('.field-name-field-ref-servicios a:contains("Meeting Room")').prepend("<i class='icon fa-meeting'></i>");
            $('.field-name-field-ref-servicios a:contains("Salón de Reuniones")').prepend("<i class='icon fa-meeting'></i>");

            $('.field-name-field-ref-servicios a:contains("Parking")').prepend("<i class='icon fa-parking'></i>");
            $('.field-name-field-ref-servicios a:contains("Parqueo")').prepend("<i class='icon fa-parking'></i>");

            $('.field-name-field-ref-servicios a:contains("Pool")').prepend("<i class='icon fa-pool'></i>");
            $('.field-name-field-ref-servicios a:contains("Pisina")').prepend("<i class='icon fa-pool'></i>");

            $('.field-name-field-ref-servicios a:contains("Room Service")').prepend("<i class='icon fa-room'></i>");
            $('.field-name-field-ref-servicios a:contains("Servicio a la Habitación")').prepend("<i class='icon fa-room'></i>");

            $('.field-name-field-ref-servicios a:contains("Store")').prepend("<i class='icon fa-store'></i>");
            $('.field-name-field-ref-servicios a:contains("Tienda")').prepend("<i class='icon fa-store'></i>");

            $('.field-name-field-ref-servicios a:contains("Terrace View")').prepend("<i class='icon fa-terrace'></i>");
            $('.field-name-field-ref-servicios a:contains("Terraza con vista")').prepend("<i class='icon fa-terrace'></i>");

            $('.field-name-field-ref-servicios a:contains("Wi-Fi")').prepend("<i class='icon fa-wifi'></i>");

            var ids = '.field-name-field-ref-servicios a';
            $(ids).click(function(event) {event.preventDefault();});
        });

        $(document).ready(function(){
            $('.card .overlay a:first-child').addClass('expand');
            if (Modernizr.touch) {
                // show the close overlay button
                $(".close-overlay").removeClass("hidden");
                // handle the adding of hover class when clicked
                $(".img").click(function(e){
                    if (!$(this).hasClass("hover")) {
                        $(this).addClass("hover");
                    }
                });
                // handle the closing of the overlay
                $(".close-overlay").click(function(e){
                    e.preventDefault();
                    e.stopPropagation();

                    if ($(this).closest(".img").hasClass("hover")) {
                        $(this).closest(".img").removeClass("hover");
                    }
                });
            } else {
                // handle the mouseenter functionality
                $(".img").mouseenter(function(){
                    $(this).addClass("hover");
                })
                    // handle the mouseleave functionality
                    .mouseleave(function(){
                        $(this).removeClass("hover");
                    });
            }
        });
    }
  };

})(jQuery, Drupal);
