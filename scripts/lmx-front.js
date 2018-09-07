//IIFE function - http://benalman.com/news/2010/11/immediately-invoked-function-expression/
(function($){
    $('#lmx-address-lookup').submit(function(){
        console.log('lookup form submitted');

        var $loader = $('#lmx-address-lookup-loader');
        $loader.removeClass('d-none').addClass('d-inline');
        var city = $('#city').val();
        var street = $('#street').val();
        var postcode = $('#postcode').val();
        var place = $('#autocomplete').attr('data-place-id');

        var data = {
            action: 'address_lookup',
            city: city,
            street: street,
            postcode: postcode,
            nonce: the_ajax_script.ajax_nonce,
            place: place
        };

        $.post(the_ajax_script.ajaxurl, data, function(response){
            var r = JSON.parse(response);
            var title;
            var body = '';
            var para = 'Great news. Flexfibre is available in your building. Please fill in the form below or call +44 203 819 0999 to be one of the first to enjoy the business internet of the future.';
            var not_found_para = 'At the moment, it looks like you won’t be able to benefit from our full Flexfibre service. But we do have a range of other offerings that may work for you. Please fill in the form below or call +44 20 3962 7555  to discuss your options.';
            if(r.status!=='OK'){
                alert(r.message);
            }else{
                //all good
                console.log(JSON.parse(response));
                $('.modal-body .list').empty().show();
                $('.modal-body .form').hide();
                $('#modal-submit').addClass('disabled').prop('disabled', true);
                $('.modal-para').hide();

                if(r.locations && r.locations.length>0){
                    title = r.locations.length + ' location(s) found';


                    //Draw list
                    var $title = $('<strong>Select a location</strong>');
                    var list = '<div class="list-group">';
                    list+= '</div>';
                    var $list = $(list);
                    $(r.locations).each(function(index, element){
                        console.log(element.location_street_name);
                        var $item =  $('<a href="#" class="list-group-item list-group-item-action" data-city="' + element.city + '" data-number="' + element.premise_number + '" data-postcode="' + element.postcode + '" data-street="' + element.street_name + '">' + element.address + '</a>');
                        $item.bind('click', function(){
                            display_form(para, $(this));
                        });
                        $list.append($item);
                    });
                    var $item = $('<a href="#" class="list-group-item list-group-item-action"><strong>Different location...</strong></a>');
                    $item.bind('click', function(){
                        display_form(not_found_para);
                    });
                    $list.append($item);

                    $('.modal-body .list').append($title);
                    $('.modal-body .list').append($list);


                }else{
                    title = 'No locations found';
                    para = 'At the moment, it looks like you won’t be able to benefit from our full Flexfibre service. But we do have a range of other offerings that may work for you. Please fill in the form below or call +44 20 3962 7555  to discuss your options.';
                    display_form(not_found_para);
                }

                $('.modal-title').text(title);
                $('#lookup-completion').modal('show');
            }
            console.log($loader);
            $loader.addClass('d-none').removeClass('d-inline');
        });


        return false;
    });

    function display_form(para, $el=null){
        if($el){
            var street = $el.data('street');
            var postcode = $el.data('postcode');
            var number = $el.data('number');
            var city = $el.data('city');

            $('#modal-street').val(street);
            $('#modal-postcode').val(postcode);
            $('#modal-number').val(number);
            $('#modal-city').val(city);
        }else{
            console.log('no el');
            $('#modal-street').val('');
            $('#modal-postcode').val('');
            $('#modal-number').val('');
            $('#modal-city').val('');
        }

        //Display the para
        $('.modal-para').text(para).show();

        //Enable submit
        $('#modal-submit').removeClass('disabled').prop('disabled', false);


        $('.modal-body .list').slideUp('fast', function(){
            $('.modal-body .form').slideDown('fast');
        });
    }




})(jQuery);


// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        {types: ['geocode'], componentRestrictions: {country: 'uk'}});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    google.maps.event.addDomListener(document.getElementById('autocomplete'), 'keydown', function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
        }
    });
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    jQuery('#autocomplete').attr('data-place-id', place.place_id);

    console.log(place.place_id);
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}