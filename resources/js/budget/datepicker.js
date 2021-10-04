import flatpickr from "flatpickr";
import { Polish } from "flatpickr/dist/l10n/pl.js"

document.addEventListener('livewire:load', function () {
    flatpickr(".datepickerReport", {
        "locale": Polish,
        altInput: true,
        altFormat: "F j, Y",
        static: true,
        dateFormat: "Y-m-d",
    });
})


window.addEventListener('contentChanged', event => {
    console.log('contentChanged');
    flatpickr(".datepicker, .datepickerReport", {
        "locale": Polish,
        altInput: true,
        altFormat: "F j, Y",
        static: true,
        dateFormat: "Y-m-d",
    });
});
