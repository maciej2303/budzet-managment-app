import flatpickr from "flatpickr";
import { Polish } from "flatpickr/dist/l10n/pl.js"

document.addEventListener('DOMContentLoaded', function(){
    flatpickr(".datepickerReport", {
        "locale": Polish,
        altInput: true,
        altFormat: "F j, Y",
        static: true,
        dateFormat: "Y-m-d",
    });
}, false);


window.addEventListener('contentChanged', event => {
    console.log('dupa');
    flatpickr(".datepicker, .datepickerReport", {
        "locale": Polish,
        altInput: true,
        altFormat: "F j, Y",
        static: true,
        dateFormat: "Y-m-d",
    });
});
