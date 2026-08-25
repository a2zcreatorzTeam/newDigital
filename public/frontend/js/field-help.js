/**
 * Accessible field-help tooltips for the Policy Buy form.
 *
 * Usage:
 *   FieldHelp.enhance('#msform');
 *   FieldHelp.enhance(element);
 *   Label/control overrides: data-field-help="Custom help text"
 *   Skip: data-field-help="off" or class "field-help-skip"
 */
(function (global) {
    'use strict';

    var ROOT_DEFAULT = '#msform';
    var INSTANCE = 0;
    var openHelp = null;
    var observedRoots = [];
    var docWired = false;
    var initialized = false;

    var CONTROL_SELECTOR = [
        'input:not([type="hidden"]):not([type="submit"]):not([type="button"]):not([type="reset"]):not([type="image"])',
        'select',
        'textarea'
    ].join(',');

    function trim(value) {
        return String(value == null ? '' : value).replace(/\s+/g, ' ').trim();
    }

    function escapeCssIdent(value) {
        if (global.CSS && typeof global.CSS.escape === 'function') {
            return global.CSS.escape(value);
        }
        return String(value).replace(/([^a-zA-Z0-9_-])/g, '\\$1');
    }

    function cleanLabelText(label) {
        if (!label) {
            return '';
        }
        var clone = label.cloneNode(true);
        clone.querySelectorAll('.field-help, .requi, .required-asterisk, .text-danger, script, style').forEach(function (node) {
            node.remove();
        });
        var text = trim(clone.textContent || '');
        text = text.replace(/\s*\/\s*[\u0600-\u06FF].*$/u, '');
        text = text.replace(/\s*\([\u0600-\u06FF][^)]*\)\s*/gu, ' ');
        text = text.replace(/^\d+\.\s*(\([IVX]+\))?\s*/i, '');
        text = text.replace(/^\(([IVX]+)\)\s*/i, '');
        text = text.replace(/\*+\s*$/g, '');
        return trim(text);
    }

    function controlKind(control) {
        if (!control) {
            return 'text';
        }
        var tag = (control.tagName || '').toLowerCase();
        if (tag === 'select') {
            return 'select';
        }
        if (tag === 'textarea') {
            return 'textarea';
        }
        var type = (control.getAttribute('type') || 'text').toLowerCase();
        if (type === 'file') {
            return 'file';
        }
        if (type === 'date' || type === 'datetime-local' || type === 'month' || type === 'time') {
            return 'date';
        }
        if (type === 'checkbox' || type === 'radio') {
            return 'choice';
        }
        if (type === 'number') {
            return 'number';
        }
        return 'text';
    }

    function sentenceFromLabel(labelText, kind) {
        var label = trim(labelText);
        if (!label) {
            return 'Provide the requested information for this field.';
        }
        if (/\?$/.test(label)) {
            return 'Answer: ' + label;
        }
        switch (kind) {
            case 'select':
                return 'Select an option for ' + label + '.';
            case 'date':
                return 'Select the ' + label + '.';
            case 'file':
                return 'Upload the required file for ' + label + '.';
            case 'textarea':
                return 'Enter details for ' + label + '.';
            case 'choice':
                return 'Choose an option for ' + label + '.';
            case 'number':
                return 'Enter the ' + label + '.';
            default:
                return 'Enter the ' + label + '.';
        }
    }

    function resolveHelpText(label, control) {
        var fromControl = control && trim(control.getAttribute('data-field-help') || '');
        if (fromControl && fromControl.toLowerCase() !== 'off') {
            return fromControl;
        }
        var fromLabel = label && trim(label.getAttribute('data-field-help') || '');
        if (fromLabel && fromLabel.toLowerCase() !== 'off') {
            return fromLabel;
        }
        var placeholder = control && trim(control.getAttribute('placeholder') || '');
        var labelText = cleanLabelText(label);
        if (!labelText && placeholder) {
            return placeholder;
        }
        return sentenceFromLabel(labelText || placeholder || 'this field', controlKind(control));
    }

    function shouldSkip(el) {
        if (!el) {
            return true;
        }
        if (el.classList && el.classList.contains('field-help-skip')) {
            return true;
        }
        var flag = trim(el.getAttribute('data-field-help') || '').toLowerCase();
        return flag === 'off' || flag === 'false' || flag === '0';
    }

    function findControlForLabel(label, root) {
        if (!label) {
            return null;
        }
        var forId = label.getAttribute('for');
        if (forId) {
            var byId = document.getElementById(forId) ||
                (root && root.querySelector('#' + escapeCssIdent(forId)));
            if (byId && byId.matches(CONTROL_SELECTOR)) {
                return byId;
            }
        }
        var nested = label.querySelector(CONTROL_SELECTOR);
        if (nested) {
            return nested;
        }
        var parent = label.parentElement;
        if (parent) {
            var sibling = parent.querySelector(CONTROL_SELECTOR);
            if (sibling) {
                return sibling;
            }
        }
        var next = label.nextElementSibling;
        while (next) {
            if (next.matches && next.matches(CONTROL_SELECTOR)) {
                return next;
            }
            var nestedNext = next.querySelector && next.querySelector(CONTROL_SELECTOR);
            if (nestedNext) {
                return nestedNext;
            }
            next = next.nextElementSibling;
        }
        return null;
    }

    function ensureDescribedBy(control, tipId) {
        if (!control || !tipId) {
            return;
        }
        var existing = trim(control.getAttribute('aria-describedby') || '');
        var parts = existing ? existing.split(/\s+/) : [];
        if (parts.indexOf(tipId) === -1) {
            parts.push(tipId);
            control.setAttribute('aria-describedby', parts.join(' '));
        }
        control.setAttribute('data-field-help-bound', tipId);
    }

    function bindRelatedControls(label, primary, tipId) {
        if (!label || !primary || !tipId) {
            return;
        }
        var group = primary.closest('.health-measure-group, .jbl-field, .miscarriage-date-row, .form-group, .detail-box');
        if (!group) {
            return;
        }
        group.querySelectorAll(CONTROL_SELECTOR).forEach(function (el) {
            if (el === primary || shouldSkip(el) || el.getAttribute('data-field-help-bound')) {
                return;
            }
            if (el.classList.contains('health-measure-unit') || (el.name && /_unit$/.test(el.name))) {
                ensureDescribedBy(el, tipId);
            }
        });
    }

    function placeTooltip(wrap) {
        var panel = wrap.querySelector('.field-help__panel');
        if (!panel) {
            return;
        }
        wrap.classList.remove('field-help--below', 'field-help--start', 'field-help--end');
        var wasOpen = wrap.classList.contains('is-open');
        wrap.classList.add('is-open');
        var rect = panel.getBoundingClientRect();
        wrap.classList.toggle('field-help--below', rect.top < 8);
        if (rect.left < 8) {
            wrap.classList.add('field-help--start');
        } else if (rect.right > (global.innerWidth - 8)) {
            wrap.classList.add('field-help--end');
        }
        if (!wasOpen) {
            wrap.classList.remove('is-open');
        }
    }

    function closeHelp(wrap) {
        if (!wrap) {
            return;
        }
        wrap.classList.remove('is-open');
        var trigger = wrap.querySelector('.field-help__trigger');
        if (trigger) {
            trigger.setAttribute('aria-expanded', 'false');
        }
        if (openHelp === wrap) {
            openHelp = null;
        }
    }

    function openHelpPanel(wrap) {
        if (openHelp && openHelp !== wrap) {
            closeHelp(openHelp);
        }
        placeTooltip(wrap);
        wrap.classList.add('is-open');
        var trigger = wrap.querySelector('.field-help__trigger');
        if (trigger) {
            trigger.setAttribute('aria-expanded', 'true');
        }
        openHelp = wrap;
    }

    function attachInteractions(wrap) {
        var trigger = wrap.querySelector('.field-help__trigger');
        if (!trigger || trigger.getAttribute('data-field-help-wired') === '1') {
            return;
        }
        trigger.setAttribute('data-field-help-wired', '1');

        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            if (wrap.classList.contains('is-open')) {
                closeHelp(wrap);
            } else {
                openHelpPanel(wrap);
            }
        });

        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeHelp(wrap);
                trigger.blur();
            }
        });

        trigger.addEventListener('focus', function () {
            openHelpPanel(wrap);
        });

        trigger.addEventListener('blur', function () {
            global.setTimeout(function () {
                if (!wrap.contains(document.activeElement)) {
                    closeHelp(wrap);
                }
            }, 120);
        });

        wrap.addEventListener('mouseenter', function () {
            if (global.matchMedia && global.matchMedia('(hover: hover) and (pointer: fine)').matches) {
                placeTooltip(wrap);
            }
        });
    }

    function wireExistingHelps(root) {
        (root || document).querySelectorAll('.field-help[data-field-help-root]').forEach(function (wrap) {
            attachInteractions(wrap);
        });
    }

    function enhanceLabel(label, root) {
        if (!label || label.getAttribute('data-field-help-enhanced') === '1' || shouldSkip(label)) {
            return false;
        }
        if (label.querySelector('.field-help')) {
            label.setAttribute('data-field-help-enhanced', '1');
            wireExistingHelps(label);
            return false;
        }

        var control = findControlForLabel(label, root || document);
        if (!control && !trim(label.getAttribute('data-field-help') || '')) {
            var textOnly = cleanLabelText(label);
            if (!textOnly || textOnly.length < 2) {
                return false;
            }
            var nearby = label.parentElement && label.parentElement.querySelector(CONTROL_SELECTOR);
            if (!nearby) {
                return false;
            }
            control = nearby;
        }

        if (control && shouldSkip(control)) {
            return false;
        }

        var helpText = resolveHelpText(label, control);
        if (!helpText) {
            return false;
        }

        INSTANCE += 1;
        var tipId = 'field-help-tip-' + INSTANCE;
        var wrap = document.createElement('span');
        wrap.className = 'field-help';
        wrap.setAttribute('data-field-help-root', '1');

        var trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'field-help__trigger';
        trigger.setAttribute('aria-label', 'Help: ' + helpText);
        trigger.setAttribute('aria-describedby', tipId);
        trigger.setAttribute('aria-expanded', 'false');
        trigger.setAttribute('aria-controls', tipId);
        trigger.innerHTML = '<span aria-hidden="true">i</span>';

        var panel = document.createElement('span');
        panel.className = 'field-help__panel';
        panel.id = tipId;
        panel.setAttribute('role', 'tooltip');
        panel.textContent = helpText;

        wrap.appendChild(trigger);
        wrap.appendChild(panel);

        var marker = label.querySelector('.requi, .required-asterisk, .text-danger');
        if (marker && marker.parentNode === label) {
            if (marker.nextSibling) {
                label.insertBefore(wrap, marker.nextSibling);
            } else {
                label.appendChild(wrap);
            }
        } else {
            label.appendChild(wrap);
        }

        if (control) {
            ensureDescribedBy(control, tipId);
            bindRelatedControls(label, control, tipId);
        }

        attachInteractions(wrap);
        label.setAttribute('data-field-help-enhanced', '1');
        return true;
    }

    function enhanceOrphanControl(control) {
        if (!control || control.getAttribute('data-field-help-bound') || shouldSkip(control)) {
            return false;
        }
        if (control.closest('label') || control.closest('.select2, .select2-container, .field-help')) {
            return false;
        }
        if (control.getAttribute('aria-hidden') === 'true' || control.classList.contains('select2-hidden-accessible')) {
            return false;
        }
        if (control.classList.contains('select2-search__field')) {
            return false;
        }
        var parent = control.closest('.col-md-12, .col-md-6, .col-md-4, .col-12, .col-6, .form-group, .detail-box, .jbl-field, .policy-preview__field, [class*="col-"]');
        if (parent && parent.querySelector('label[data-field-help-enhanced="1"]')) {
            var tip = parent.querySelector('.field-help__panel');
            if (tip && tip.id) {
                ensureDescribedBy(control, tip.id);
                return false;
            }
        }

        if (control.classList.contains('health-measure-unit') || (control.name && /_unit$/.test(control.name))) {
            return false;
        }

        var helpText = trim(control.getAttribute('data-field-help') || '') ||
            trim(control.getAttribute('aria-label') || '') ||
            trim(control.getAttribute('placeholder') || '');

        if (!helpText) {
            var nameHint = trim((control.getAttribute('name') || '').replace(/[\[\]]+/g, ' ').replace(/_/g, ' '));
            if (!nameHint) {
                return false;
            }
            helpText = sentenceFromLabel(nameHint, controlKind(control));
        }

        if (!helpText || helpText.toLowerCase() === 'off') {
            return false;
        }

        INSTANCE += 1;
        var tipId = 'field-help-tip-' + INSTANCE;
        var wrap = document.createElement('span');
        wrap.className = 'field-help field-help--orphan';
        wrap.setAttribute('data-field-help-root', '1');

        var trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'field-help__trigger';
        trigger.setAttribute('aria-label', 'Help: ' + helpText);
        trigger.setAttribute('aria-describedby', tipId);
        trigger.setAttribute('aria-expanded', 'false');
        trigger.setAttribute('aria-controls', tipId);
        trigger.innerHTML = '<span aria-hidden="true">i</span>';

        var panel = document.createElement('span');
        panel.className = 'field-help__panel';
        panel.id = tipId;
        panel.setAttribute('role', 'tooltip');
        panel.textContent = helpText;

        wrap.appendChild(trigger);
        wrap.appendChild(panel);

        if (control.parentNode) {
            control.parentNode.insertBefore(wrap, control);
        }
        ensureDescribedBy(control, tipId);
        attachInteractions(wrap);
        return true;
    }

    function enhance(target) {
        var root = typeof target === 'string' ? document.querySelector(target) : target;
        if (!root) {
            return 0;
        }
        var count = 0;
        root.querySelectorAll('label').forEach(function (label) {
            if (enhanceLabel(label, root)) {
                count += 1;
            }
        });
        root.querySelectorAll(CONTROL_SELECTOR).forEach(function (control) {
            if (enhanceOrphanControl(control)) {
                count += 1;
            }
        });
        wireExistingHelps(root);
        return count;
    }

    function observe(root) {
        if (!root || typeof MutationObserver === 'undefined') {
            return;
        }
        if (observedRoots.indexOf(root) !== -1) {
            return;
        }
        observedRoots.push(root);
        var timer = null;
        var observer = new MutationObserver(function () {
            if (timer) {
                global.clearTimeout(timer);
            }
            timer = global.setTimeout(function () {
                enhance(root);
            }, 80);
        });
        observer.observe(root, { childList: true, subtree: true });
    }

    function onDocumentClick(event) {
        if (!openHelp) {
            return;
        }
        if (openHelp.contains(event.target)) {
            return;
        }
        closeHelp(openHelp);
    }

    function onDocumentKeydown(event) {
        if (event.key === 'Escape' && openHelp) {
            closeHelp(openHelp);
        }
    }

    function wireDocument() {
        if (docWired) {
            return;
        }
        document.addEventListener('click', onDocumentClick, true);
        document.addEventListener('keydown', onDocumentKeydown, true);
        document.addEventListener('shown.bs.tab', function () {
            var root = document.querySelector(ROOT_DEFAULT);
            if (root) {
                enhance(root);
            }
        });
        if (global.jQuery) {
            global.jQuery(document).on('shown.bs.tab', function () {
                var root = document.querySelector(ROOT_DEFAULT);
                if (root) {
                    enhance(root);
                }
            });
        }
        docWired = true;
    }

    function init(selector) {
        var root = document.querySelector(selector || ROOT_DEFAULT);
        if (!root) {
            return;
        }
        enhance(root);
        observe(root);
        wireDocument();
        initialized = true;
    }

    global.FieldHelp = {
        enhance: enhance,
        enhanceLabel: enhanceLabel,
        init: init,
        close: function () {
            closeHelp(openHelp);
        }
    };

    function boot() {
        if (!initialized) {
            init(ROOT_DEFAULT);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})(window);
