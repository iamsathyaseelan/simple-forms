(function ($) {
    $(document).ready(function () {
        $('form[name="simple_form"]').submit(function (event) {
            // Prevent the default form submission
            event.preventDefault();
            const button = $('button');
            // Find the paragraph with class "form-response" and display the response
            const formResult = $('.form-response');

            button.attr('disabled', true);
            formResult.text('');

            // Post form data to the form action URL
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    formResult.text(response?.message);
                    formResult.css('color', 'green');
                    button.attr('disabled', false);
                },
                error: function (response) {
                    // Handle errors if needed
                    formResult.text(response?.responseJSON?.message);
                    formResult.css('color', 'red');
                    button.attr('disabled', false);
                }
            });
        });

        $('form[name="simple_form_list"]').submit(function (event) {
            // Prevent the default form submission
            event.preventDefault();
            const button = $('.search-button');
            const loadMoreButton = $('.load-more-button');
            // Find the list with class "simple-form-list" and display the response
            const searchResult = $('.simple-form-list');
            const pageInput = $('input[name="page"]');
            console.log(pageInput)

            button.attr('disabled', true);

            // Post form data to the form action URL
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    const result = response?.data ?? [];
                    for (const row of result) {
                        searchResult.append(`<li>${row.name}</li>`)
                    }
                    button.attr('disabled', false);
                    pageInput.val(response?.next_page ?? 1)
                    loadMoreButton.show()
                },
                error: function (response) {
                    // Handle errors if needed
                    button.attr('disabled', false);
                    searchResult.append(`<li style="color: red">No more data found</li>`)
                    loadMoreButton.hide()
                }
            });
        });

        $('.simple-form-keyword').on('keyup', function () {
            // Find the closest form div
            const form = $(this).closest('form');

            form.find('.simple-form-list').text('');
            form.find('input[name="page"]').val(1);
        });

        $('form[name="simple_form_list"]').submit()
    });
})(jQuery)
