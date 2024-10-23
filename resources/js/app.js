import './bootstrap';
import './forms';
import './flowbite.min';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

import Alpine from 'alpinejs';

window.Cropper = Cropper;
window.toastr = toastr;
window.Swal = Swal;
window.Alpine = Alpine;

Alpine.start();

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

