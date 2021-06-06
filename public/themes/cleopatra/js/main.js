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
        url: `${base_url}/panel/notifications/open/${id}`,
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

let loadNotifications = () => {
    $.ajax({
        type: "POST",
        url: `${base_url}/panel/notifications/load`,
        dataType: 'json',
        success: function (data) {
            let notSeenCount = 0;
            $("#notification_container").html('');
            for (i in data) {
                notSeenCount += data[i]['seen'] ? 0 : 1;
                $("#notification_container").append(`
                <a onclick='openNotification(this, ${data[i]['id']} );' class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 transition-all duration-300 ease-in-out" href="#">
                    <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-300">
                        <i class="${data[i]['icon']} text-sm"></i>
                    </div>

                    <div class="flex-1 flex flex-rowbg-green-100">
                        <div class="flex-1">
                            <h1 id='notification_${data[i]['id']}_title' class="text-sm font-semibold ${!data[i]['seen'] ? 'text-red-400' : ''}">${data[i]['title']}</h1>
                            <p class="text-xs text-gray-500">${data[i]['message']}</p>
                        </div>
                        <div class="text-right text-xs text-gray-500">
                            <p>${data[i]['time']}</p>
                        </div>
                    </div>

                </a>
                `);
            }
            $("#notification_count").html( notSeenCount );
        }
    })
}

setInterval(() => {
    loadNotifications();
}, 60000);

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