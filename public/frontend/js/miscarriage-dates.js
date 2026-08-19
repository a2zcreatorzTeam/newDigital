(function (window, document) {
    'use strict';

    function rowHtml(value) {
        var v = value == null ? '' : String(value);
        return '<div class="miscarriage-date-row d-flex align-items-center mb-2" style="gap:8px;">' +
            '<input type="date" name="miscarriage_dates[]" class="form-control jbl-dynamic-input miscarriage-date-input" value="' + v.replace(/"/g, '&quot;') + '">' +
            '<button type="button" class="btn btn-sm btn-primary miscarriage-date-add" title="Add date">+</button>' +
            '<button type="button" class="btn btn-sm btn-secondary miscarriage-date-remove" title="Remove date">-</button>' +
            '</div>';
    }

    function list() {
        return document.getElementById('miscarriage_dates_list');
    }

    function rows() {
        var el = list();
        return el ? el.querySelectorAll('.miscarriage-date-row') : [];
    }

    function syncRemoveButtons() {
        var all = rows();
        all.forEach(function (row) {
            var removeBtn = row.querySelector('.miscarriage-date-remove');
            if (removeBtn) {
                removeBtn.disabled = all.length <= 1;
            }
        });
    }

    function ensureMiscarriageDateRows(values) {
        var el = list();
        if (!el) {
            return;
        }

        var dates = Array.isArray(values) ? values.slice() : [];
        dates = dates.map(function (v) {
            return v == null ? '' : String(v).trim();
        });
        if (!dates.length) {
            dates = [''];
        }

        el.innerHTML = dates.map(rowHtml).join('');
        syncRemoveButtons();
    }

    document.addEventListener('click', function (event) {
        var addBtn = event.target.closest('.miscarriage-date-add');
        var removeBtn = event.target.closest('.miscarriage-date-remove');
        if (!addBtn && !removeBtn) {
            return;
        }

        var el = list();
        if (!el) {
            return;
        }

        event.preventDefault();

        if (addBtn) {
            addBtn.closest('.miscarriage-date-row').insertAdjacentHTML('afterend', rowHtml(''));
        } else if (removeBtn && rows().length > 1) {
            removeBtn.closest('.miscarriage-date-row').remove();
        }

        syncRemoveButtons();
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncRemoveButtons);
    } else {
        syncRemoveButtons();
    }

    window.ensureMiscarriageDateRows = ensureMiscarriageDateRows;
})(window, document);
