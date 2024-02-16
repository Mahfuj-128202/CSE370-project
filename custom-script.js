$(document).ready(function () {
    $('#search').keyup(function () {
        var query = $(this).val();
        if (query != '') {
            $.ajax({
                url: 'search.php',
                method: 'POST',
                data: { search: query },
                dataType: 'json',
                success: function (data) {
                    $('#suggestions').empty();
                    if (data.length > 0) {
                        $.each(data, function (key, value) {
                            $('#suggestions').append('<div><span>' + value.name + '</span></div>');
                        });
                    } else {
                        $('#suggestions').html('<div>No results found.</div>');
                    }
                }

            });
        } else {
            $('#suggestions').html('');
        }
    });
});
