$(document).on('ajaxComplete ready', function () {

    // Initialize tag inputs.
    $('select[data-provides="anomaly.field_type.relationship"]:not([data-initialized])').each(function () {

        $(this)
            .attr('data-initialized', '')
            .select2({
                containerCssClass: 'form-control custom-select select2-override',
                dropdownCssClass: 'select2-option-override'
            });
    });
});
