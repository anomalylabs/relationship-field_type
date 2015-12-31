$(function () {

    // Initialize file pickers
    $('.file-field_type').each(function () {

        var wrapper = $(this);
        var field = wrapper.data('field');
        var modal = $('#' + field + '-modal');

        modal.on('click', '[data-file]', function (e) {

            e.preventDefault();

            modal.find('.modal-content').append('<div class="modal-loading"><div class="active loader"></div></div>');

            wrapper.find('.selected').load(APPLICATION_URL + '/streams/file-field_type/selected?uploaded=' + $(this).data('file'), function () {
                modal.modal('hide');
            });

            $('[name="' + field + '"]').val($(this).data('file'));
        });

        $(wrapper).on('click', '[data-dismiss="file"]', function (e) {

            e.preventDefault();

            $('[name="' + field + '"]').val('');

            wrapper.find('.selected').load(APPLICATION_URL + '/streams/file-field_type/selected', function () {
                modal.modal('hide');
            });
        });
    });
});
