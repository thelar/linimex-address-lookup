//IIFE function - http://benalman.com/news/2010/11/immediately-invoked-function-expression/
(function($){
    $('#lmx-address-lookup').submit(function(){
        console.log('lookup form submitted');
        var city = $('#city').val();
        var street = $('#street').val();
        var postcode = $('#postcode').val();

        var data = {
            action: 'address_lookup',
            city: city,
            street: street,
            postcode: postcode,
            nonce: the_ajax_script.ajax_nonce
        };

        $.post(the_ajax_script.ajaxurl, data, function(response){
            var r = JSON.parse(response);
            var title;
            var body = '';
            if(r.status!=='OK'){
                alert(r.message);
            }else{
                //all good
                console.log(JSON.parse(response));
                $('.modal-body .list').empty().show();
                $('.modal-body .form').hide();
                $('#modal-submit').addClass('disabled').prop('disabled', true);

                if(r.locations.length){
                    title = r.locations.length + ' location(s) found:';


                    //Draw list
                    var $title = $('<strong>Select a location</strong>');
                    var list = '<div class="list-group">';
                    list+= '</div>';
                    var $list = $(list);
                    $(r.locations).each(function(index, element){
                        var $item =  $('<a href="#" class="list-group-item list-group-item-action" data-city="' + element.city + '" data-number="' + element.location_premises_number + '" data-postcode="' + element.postal_zip_code + '" data-street="' + element.location_street_name + '">' + element.address + '</a>');
                        $item.bind('click', function(){
                            display_form($(this));
                        });
                        $list.append($item);
                    });
                    var $item = $('<a href="#" class="list-group-item list-group-item-action"><strong>Different location...</strong></a>');
                    $item.bind('click', function(){
                        display_form();
                    });
                    $list.append($item);

                    $('.modal-body .list').append($title);
                    $('.modal-body .list').append($list);


                }else{
                    title = 'No locations found';
                    display_form();
                }
                $('.modal-title').text(title);
                $('#lookup-completion').modal('show');
            }

        });

        return false;
    });

    function display_form($el=null){
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

        //Enable submit
        $('#modal-submit').removeClass('disabled').prop('disabled', false);


        $('.modal-body .list').slideUp('fast', function(){
            $('.modal-body .form').slideDown('fast');
        });
    }
})(jQuery);