import flatpickr from "flatpickr";
import { Polish } from "flatpickr/dist/l10n/pl.js"

window.addEventListener('contentChanged', event => {
    console.log('dupa');
    flatpickr(".datepicker", {
        "locale": Polish,
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "d-m-Y",
        defultDate: "today",
        static: true,
    });
});
