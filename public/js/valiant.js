$.extend(true, $.fn.dataTable.defaults, {
    autoWidth: false,
    stateSave: true,
    stateDuration: 0,
    stateLoadCallback: function () {
        return JSON.parse(localStorage.getItem($(this).attr('id')));
    },
    stateSaveCallback: function (settings, data) {
        localStorage.setItem($(this).attr('id'), JSON.stringify(data));
    },
    drawCallback: function () {
        let api = this.api();
        if (api.page.info().page > 0 && api.rows({page: 'current'}).count() === 0) {
            api.page('previous').state.save();
            location.reload();
        }
    }
});

$(document).ready(function () {
    $(document).on('click', '[data-ajax-post]', function () {
        if ($(this).attr('data-confirm') && !confirm($(this).data('confirm'))) return;
        $.post($(this).data('ajax-post'), {_token: $(this).data('ajax-token')}, 'json');
    });

    $(document).on('click', '[data-confirm]:not([data-ajax-post])', function (event) {
        if (!confirm($(this).data('confirm'))) event.preventDefault();
    });

    $(document).on('submit', '[data-ajax-form]', function (event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: new FormData($(this)[0]),
            contentType: false,
            processData: false,
            error: function (response) {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').html(null).removeClass('d-block');

                $.each(response.responseJSON.errors, function (key, value) {
                    $('[data-error-input="' + key + '"]').addClass('is-invalid');
                    $('[data-error-feedback="' + key + '"]').html('<strong>' + value[0] + '</strong>').addClass('d-block');
                });

                $(document).Toasts('create', {class: 'bg-danger', title: 'Error', body: response.responseJSON.message, autohide: true, delay: 3000});
            }
        });
    });

    $(document).ajaxComplete(function (event, request) {
        if (request.hasOwnProperty('responseJSON')) {
            let json = request.responseJSON;

            if (json.hasOwnProperty('redirect')) $(location).attr('href', json.redirect);
            if (json.hasOwnProperty('reload_page')) location.reload();
            if (json.hasOwnProperty('reload_table')) $($.fn.dataTable.tables()).DataTable().ajax.reload();
            if (json.hasOwnProperty('show_modal')) $(json.show_modal).modal('show');
            if (json.hasOwnProperty('dismiss_modal')) $('[data-ajax-modal]').modal('toggle');
            if (json.hasOwnProperty('status')) $(document).Toasts('create', {class: 'bg-success', title: 'Success', body: json.status, autohide: true, delay: 3000});
            if (json.hasOwnProperty('jquery')) $(json.jquery.selector)[json.jquery.method](json.jquery.content);
        }
    });

    $(document).on('click', '[data-show-modal]', function () {
        $.get($(this).data('show-modal'), function (data) {
            $(data).modal('show');
        });
    });

    $(document).on('shown.bs.modal', '[data-ajax-modal]', function () {
        $(this).find('script').each(function () {
            eval($(this).text());
        });
    });

    $(document).on('hidden.bs.modal', '[data-ajax-modal]', function () {
        $(this).remove();
    });

    $(document).on('click', '[data-checkbox-ids-all]', function () {
        $('[data-checkbox-id]').prop('checked', this.checked).trigger('change');
    });

    $(document).on('change', '[data-checkbox-id]', function () {
        let row = $(this).closest('tr');
        this.checked ? row.addClass('checked') : row.removeClass('checked');
        $('[data-checkbox-ids]').val($('[data-checkbox-id]:checked').map(function () {
            return this.value;
        }).get().join(','));
    });

    $(document).on('input', '.custom-file-input', function () {
        let files = [];
        for (let i = 0; i < $(this)[0].files.length; i++) files.push($(this)[0].files[i].name);
        $(this).next('.custom-file-label').html(files.join(', '));
    });

    let user_timezone = $('[data-user-timezone]');
    if (user_timezone.length) user_timezone.val(Intl.DateTimeFormat().resolvedOptions().timeZone);
});
