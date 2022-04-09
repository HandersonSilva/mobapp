import Swal from 'sweetalert2';

export const _alert = (params) => {
    Swal.fire({
        title: params.title,
        text: params.text,
        icon: params.icon,
        confirmButtonText: params.confirmButtonText,
        allowOutsideClick: true
    }).then((result) => {
        if (result.value) {
            if (params.callback && typeof (params.callback) === "function") {
                params.callback();
            }
        }
    })
}