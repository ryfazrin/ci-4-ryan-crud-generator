# ci4-crud-genrator
CRUD is very important. However, in making crud requires a lot of time. Though CRUD is basically the same. Codeigniter 4 CRUD Generator comes with a solution.

## Issue

- [ ] Tag Input 'select' is still made manually.
- [ ] Not having an input tag for the 'image data'.
- [x] Error get tables mysql where Database name with character '-' [Here](https://stackoverflow.com/questions/45729380/mysql-select-record-from-database-table-database-name-contain)
- [ ] AJAX request becomes 403 forbidden (does not have csrf) ref: [CI4 Docs](https://codeigniter4.github.io/userguide/general/ajax.html), [stackoverflow](https://stackoverflow.com/questions/38502548/codeigniter-csrf-valid-for-only-one-time-ajax-request) and [makitweb.com](https://makitweb.com/how-to-send-ajax-request-with-csrf-token-in-codeigniter-4/)