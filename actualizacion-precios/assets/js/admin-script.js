jQuery(document).ready(function($) {
    $('#apbp-update-prices-form').on('submit', function(e) {
        e.preventDefault();
        var percentage = parseFloat($('#percentage').val());
        var excludeProducts = $('#exclude_products').val();

        $('#apbp-progress-bar').show();
        $('#apbp-result-message').text('Actualizando precios...');

        $.ajax({
            url: apbp_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'apbp_update_prices',
                nonce: apbp_ajax.nonce,
                percentage: percentage,
                exclude_products: excludeProducts
            },
            success: function(response) {
                if (response.success) {
                    $('#apbp-result-message').text(response.data.message);
                } else {
                    $('#apbp-result-message').text('Error: ' + response.data);
                }
                $('#apbp-progress-bar').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
                $('#apbp-result-message').text('Error de conexión: ' + textStatus + ' - ' + errorThrown);
                $('#apbp-progress-bar').hide();
            }
        });
    });
});