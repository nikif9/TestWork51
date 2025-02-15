jQuery(document).ready(function($) {
    // При вводе текста в поле поиска отправляем AJAX-запрос.
    $('#city-search-input').on('keyup', function() {
        var query = $(this).val();
        $.ajax({
            url: childThemeAjax.ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'city_search',
                query: query,
                nonce: childThemeAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    var results = response.data;
                    var $resultsContainer = $('#city-search-results');
                    $resultsContainer.empty();
                    if (results.length) {
                        $.each(results, function(index, city) {
                            $resultsContainer.append('<div>' + city.title + '</div>');
                        });
                    } else {
                        $resultsContainer.append('<div>No cities found.</div>');
                    }
                }
            }
        });
    });
});
