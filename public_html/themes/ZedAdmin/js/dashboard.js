// Scroll to active element [zagreus-co/ZedAdmin: issue #2]
const activeElement = document.querySelector("nav ul li.active");
if (activeElement !== null) activeElement.scrollIntoView({ behavior: 'smooth', block: 'end'});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Content-Type': 'application/json'
    }
});

let toggleMenu = (sidebarElement = "aside.sidebar") => {
    document.querySelector(sidebarElement).classList.toggle('hidden');
}

document.addEventListener("click", (event) => {
    const mobile_menu = document.querySelector('aside.sidebar');
    let targetElement = event.target; // Clicked element

    do {
        if (targetElement == document.querySelector('#mobileMenuBtn')) return toggleMenu();
        if (targetElement == mobile_menu) return;
        targetElement = targetElement.parentNode;
    } while (targetElement);
    
    if (!mobile_menu.classList.contains('hidden')) mobile_menu.classList.add('hidden');
});

let fireDelete = (self, url) => {
    swal({
        title: "آیا از حذف این داده مطمعن هستید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: [
                "لفو عملیات", 
                "تایید و حذف"
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