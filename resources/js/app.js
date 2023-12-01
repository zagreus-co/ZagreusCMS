import './bootstrap';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from "@ryangjchandler/alpine-clipboard"
import Swal from 'sweetalert2/dist/sweetalert2.all.js';

window.Swal = Swal

Alpine.plugin(Clipboard)
Livewire.start();

Livewire.on('livewire:toast', (data) => {
    data = data[0];
    Swal.fire({
        icon: data.type,
        title: data.message,
        toast: true,
        position: 'top-end',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false
    });
})

Livewire.on('livewire:alert', (data) => {
    data = data[0];
    if (data.event === undefined) return alert("Event is not defined in the data you passed.");

    Swal.fire({
        icon: data.icon ?? 'warning',
        title: data.title ?? '',
        text: data.text ?? "Are you sure you want to delete this data?",
        allowEnterKey: true,
        allowEscapeKey: true,
        focusConfirm: true,
        showCancelButton: true,
        confirmButtonText: "Accept & Delete",
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#ef5858',
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            Livewire.dispatch(data.event, { deletable: data.deletable });
        }
    })
})