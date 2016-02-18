$(function () {

    // Initialize relationship pickers
    $('[data-provides="anomaly.field_type.relationship"]').each(function () {

        var input = $(this);
        var field = input.data('field_name');
        var wrapper = input.closest('.form-group');
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
