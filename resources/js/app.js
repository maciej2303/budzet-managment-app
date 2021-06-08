require('./bootstrap');

require('alpinejs');

import flatpickr from "flatpickr";
import { Polish } from "flatpickr/dist/l10n/pl.js"
flatpickr(".datepicker", {
    "locale": Polish,
    altInput: true,
    altFormat: "F j, Y",
    dateFormat: "d-m-Y",
    defultDate: "today",
    static: true,
});
