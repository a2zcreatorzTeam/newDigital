(function (window, document) {
    'use strict';

    function parseDateOnly(value) {
        if (!value) {
            return null;
        }

        var text = String(value).trim();
        var match = text.match(/^(\d{4})-(\d{1,2})-(\d{1,2})/);
        var year;
        var month;
        var day;

        if (match) {
            year = parseInt(match[1], 10);
            month = parseInt(match[2], 10);
            day = parseInt(match[3], 10);
        } else {
            match = text.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})/);
            if (!match) {
                return null;
            }
            day = parseInt(match[1], 10);
            month = parseInt(match[2], 10);
            year = parseInt(match[3], 10);
        }

        var date = new Date(year, month - 1, day);
        if (date.getFullYear() !== year || date.getMonth() !== month - 1 || date.getDate() !== day) {
            return null;
        }

        return date;
    }

    function daysInMonth(year, monthIndex) {
        return new Date(year, monthIndex + 1, 0).getDate();
    }

    function addYearsClamped(date, years) {
        var year = date.getFullYear() + years;
        var month = date.getMonth();
        var day = Math.min(date.getDate(), daysInMonth(year, month));

        return new Date(year, month, day);
    }

    /**
     * Age nearest birthday using a 6-month threshold after the last birthday.
     */
    function ageNearestBirthday(dobValue, asOf) {
        var dob = parseDateOnly(dobValue);
        if (!dob) {
            return '';
        }

        var today = asOf ? parseDateOnly(asOf) : new Date();
        if (!today) {
            today = new Date();
        }
        today = new Date(today.getFullYear(), today.getMonth(), today.getDate());

        if (today < dob) {
            return 0;
        }

        var years = today.getFullYear() - dob.getFullYear();
        var lastBirthday = addYearsClamped(dob, years);
        if (lastBirthday > today) {
            years -= 1;
            lastBirthday = addYearsClamped(dob, years);
        }

        var months = (today.getFullYear() - lastBirthday.getFullYear()) * 12
            + (today.getMonth() - lastBirthday.getMonth());

        if (today.getDate() < lastBirthday.getDate()) {
            months -= 1;
        }

        if (months >= 6) {
            years += 1;
        }

        return years;
    }

    function applyAgeFromDob(dobValue, sourceName) {
        var age = ageNearestBirthday(dobValue);
        if (age === '') {
            return '';
        }

        var isLifeProposed = sourceName === 'life_proposed_dob';
        var ageName = isLifeProposed ? 'life_proposed_age' : 'age_nearest_date';
        var fields = isLifeProposed
            ? document.querySelectorAll('input[name="life_proposed_age"], [data-pp-name="life_proposed_age"]')
            : document.querySelectorAll('input[name="age_nearest_date"], #age_birth, [data-pp-name="age_nearest_date"]');
        Array.prototype.forEach.call(fields, function (el) {
            el.value = age;
        });

        var displays = document.querySelectorAll('[data-pp-display="' + ageName + '"]');
        Array.prototype.forEach.call(displays, function (el) {
            el.textContent = String(age);
            el.classList.remove('policy-preview__muted');
        });

        if (!isLifeProposed) {
            var dobFields = document.querySelectorAll('input[name="date_of_birth"], [data-pp-name="date_of_birth"]');
            Array.prototype.forEach.call(dobFields, function (el) {
                if (age !== '' && age < 18) {
                    el.setCustomValidity('Proposer must be 18 years or older.');
                } else {
                    el.setCustomValidity('');
                }
            });
        }

        return age;
    }

    function isDobField(target) {
        if (!target || target.tagName !== 'INPUT') {
            return false;
        }

        var name = target.getAttribute('name') || target.getAttribute('data-pp-name') || '';
        return name === 'date_of_birth' || name === 'life_proposed_dob';
    }

    function onDobEvent(event) {
        if (!isDobField(event.target)) {
            return;
        }

        applyAgeFromDob(event.target.value, event.target.getAttribute('name') || event.target.getAttribute('data-pp-name'));
    }

    document.addEventListener('change', onDobEvent, true);
    document.addEventListener('input', onDobEvent, true);

    function refreshExistingDobFields() {
        var fields = document.querySelectorAll('input[name="date_of_birth"], input[name="life_proposed_dob"]');
        Array.prototype.forEach.call(fields, function (el) {
            if (el.value) {
                applyAgeFromDob(el.value, el.getAttribute('name'));
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', refreshExistingDobFields);
    } else {
        refreshExistingDobFields();
    }

    window.ageNearestBirthday = ageNearestBirthday;
    window.applyAgeFromDob = applyAgeFromDob;
})(window, document);
