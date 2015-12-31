$(function () {

    // Initialize relationship pickers
    $('.relationship-field_type').each(function () {

        var wrapper = $(this);
        var field = wrapper.data('field');
        var modal = $('#' + field + '-modal');

        modal.on('click', '[data-entry]', function (e) {

            e.preventDefault();

            wrapper.find('.selected').load(APPLICATION_URL + '/streams/relationship-field_type/selected/' + $(this).data('key') + '?uploaded=' + $(this).data('entry'), function () {
                modal.modal('hide');
            });

            $('[name="' + field + '"]').val($(this).data('entry'));

            $(wrapper).find('[data-dismiss="relationship"]').removeClass('hidden');
        });

        $(wrapper).on('click', '[data-dismiss="relationship"]', function (e) {

            e.preventDefault();

            $('[name="' + field + '"]').val('');

            wrapper.find('.selected').html('');

            $(this).addClass('hidden');
        });
    });
});
