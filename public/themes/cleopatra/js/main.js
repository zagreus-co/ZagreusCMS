$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'application/json'
    }
});

let toggleSubMenu = (self, menu) => {
    let icon = $(self).find('.fa-angle-right')
    if (icon.hasClass('transform') && icon.hasClass('rotate-90')) {
        icon.removeClass('transform');
        icon.removeClass('rotate-90');
        $(menu).addClass('hidden');
        return 0;
    }
    $(menu).removeClass('hidden');
    icon.addClass('transform');
    icon.addClass('rotate-90');   
}

let openNotification = (self, id) => {
    $(self).css('opacity', '0.4');
    $.ajax({
        type: "POST",
        url: `/panel/notifications/open/${id}`,
        dataType: 'json',
        success: function (data) {
            swal(data.message);
            $(`#notification_${id}_title`).removeClass('text-red-400')
            $(self).css('opacity', '1');
        },
        error: function (data) {
            swal(data.responseJSON.message);
            $(self).css('opacity', '1');
        }
    })
}

let fireDelete = (self, url) => {
    swal({
        title: "Are you sure to delete this row?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: [
                "Cancel", 
                "Accept and delete"
            ],
        })
        .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: 'POST',
                url: url,
                data: JSON.stringify({
                    _method: 'DELETE'
                }),
                dataType: 'json',
                success: function (data) {
                    location.reload();
                },
                error: function (data) {
                    swal(data.responseJSON.message);
                }
            });
        }
    });
}