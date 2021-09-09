import flatpickr from "flatpickr";
import { Polish } from "flatpickr/dist/l10n/pl.js"

document.addEventListener('DOMContentLoaded', function(){
    flatpickr(".datepickerReport", {
        "locale": Polish,
        altInput: true,
        altFormat: "F j, Y",
        static: true,
        dateFormat: "d-m-Y",
    });
}, false);


window.addEventListener('contentChanged', event => {
    flatpickr(".datepicker", {
        "locale": Polish,
        altInput: true,
        altFormat: "F j, Y",
        static: true,
    });
});
