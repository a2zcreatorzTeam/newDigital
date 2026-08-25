/**
 * Upload policy documents one file at a time (ModSecurity-friendly).
 * Uses JSON + base64 so WAF/ModSecurity does not strip multipart payloads.
 * UI remains unchanged.
 */
(function ($) {
    'use strict';

    var uploadUrl = '';
    var csrfToken = '';

    function getUploadUrl() {
        var $form = $('#msform');
        return $form.data('policy-upload-url') || uploadUrl;
    }

    function getCsrfToken() {
        return $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val() || csrfToken;
    }

    function resolveUploadField($input) {
        var name = $input.attr('name') || '';
        if (!name) {
            return '';
        }
        if (name === 'medical_extra_docs[]') {
            return 'medical_extra_doc';
        }
        if (name === 'other_docs[]') {
            return 'other_doc';
        }
        return name.replace(/\[\]$/, '');
    }

    function tokenInputName($input) {
        var name = $input.attr('name') || '';
        if (name === 'medical_extra_docs[]') {
            return 'medical_extra_temp_tokens[]';
        }
        if (name === 'other_docs[]') {
            return 'other_doc_temp_tokens[]';
        }
        return resolveUploadField($input) + '_temp_token';
    }

    function ensureHiddenTokenInput($input) {
        var tokenName = tokenInputName($input);
        var $row = $input.closest('[data-doc-row], .jbl-field, .col-md-6').first();
        var $hidden = $row.find('input[type="hidden"][name="' + tokenName + '"]');
        if (!$hidden.length) {
            $hidden = $('<input>', { type: 'hidden', name: tokenName });
            $input.after($hidden);
        }
        return $hidden;
    }

    function setRowState($input, state, message) {
        var $row = $input.closest('[data-doc-row]');
        if (!$row.length) {
            return;
        }
        var $name = $row.find('.doc-file-name');
        var $ok = $row.find('.doc-file-ok');
        var $clear = $row.find('.doc-file-clear');

        if (state === 'uploading') {
            $name.text(message || 'Uploading...');
            $ok.addClass('d-none');
            $clear.addClass('d-none');
            return;
        }
        if (state === 'done') {
            $name.text(message || 'Uploaded');
            $ok.removeClass('d-none');
            $clear.removeClass('d-none');
            return;
        }
        if (state === 'error') {
            $name.text(message || 'Upload failed');
            $ok.addClass('d-none');
            $clear.removeClass('d-none');
        }
    }

    function readFileAsBase64(file) {
        var deferred = $.Deferred();
        var reader = new FileReader();
        reader.onload = function (e) {
            deferred.resolve(String(e.target.result || ''));
        };
        reader.onerror = function () {
            deferred.reject('Unable to read selected file.');
        };
        reader.readAsDataURL(file);
        return deferred.promise();
    }

    function extractErrorMessage(xhr, fallback) {
        var msg = fallback || 'Upload failed';
        if (xhr && xhr.responseJSON) {
            if (xhr.responseJSON.message) {
                return xhr.responseJSON.message;
            }
            if (xhr.responseJSON.errors) {
                var firstKey = Object.keys(xhr.responseJSON.errors)[0];
                if (firstKey && xhr.responseJSON.errors[firstKey][0]) {
                    return xhr.responseJSON.errors[firstKey][0];
                }
            }
        }
        return msg;
    }

    function uploadSingleFile($input, file) {
        var field = resolveUploadField($input);
        if (!field || !file) {
            return $.Deferred().reject().promise();
        }
        if (!$.ajax || typeof $.ajax !== 'function') {
            setRowState($input, 'error', 'Upload library is not loaded. Please refresh.');
            return $.Deferred().reject().promise();
        }

        var $row = $input.closest('[data-doc-row]');
        if ($row.length) {
            setRowState($input, 'uploading');
        }
        $input.data('uploading', true);

        return readFileAsBase64(file)
            .then(function (dataUrl) {
                return $.ajax({
                    url: getUploadUrl(),
                    method: 'POST',
                    data: JSON.stringify({
                        field: field,
                        file_base64: dataUrl,
                        original_name: file.name,
                        _token: getCsrfToken()
                    }),
                    contentType: 'application/json',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
            })
            .then(function (response) {
                if (!response || !response.success || !response.token) {
                    return $.Deferred().reject({
                        responseJSON: {
                            message: (response && response.message) ? response.message : 'Upload failed'
                        }
                    }).promise();
                }
                ensureHiddenTokenInput($input).val(response.token);
                if ($row.length) {
                    setRowState($input, 'done', response.original_name || file.name);
                }
                return response;
            })
            .fail(function (xhr) {
                var msg = typeof xhr === 'string' ? xhr : extractErrorMessage(xhr, 'Upload failed');
                ensureHiddenTokenInput($input).val('');
                if ($row.length) {
                    setRowState($input, 'error', msg);
                }
            })
            .always(function () {
                $input.data('uploading', false);
            });
    }

    function clearTokenForInput($input) {
        var tokenName = tokenInputName($input);
        $input.closest('[data-doc-row], .jbl-field, .col-md-6').first()
            .find('input[type="hidden"][name="' + tokenName + '"]')
            .val('');
    }

    function initPolicyUpload(options) {
        uploadUrl = (options && options.uploadUrl) || uploadUrl;
        csrfToken = (options && options.csrfToken) || csrfToken;

        $(document).off('change.policyUpload', '#msform input[type="file"]');
        $(document).on('change.policyUpload', '#msform input[type="file"]', function () {
            var input = this;
            var $input = $(input);
            var file = input.files && input.files[0];

            if (!file) {
                clearTokenForInput($input);
                return;
            }

            uploadSingleFile($input, file);
        });

        $(document).off('click.policyUploadClear', '#documents .doc-file-clear');
        $(document).on('click.policyUploadClear', '#documents .doc-file-clear', function () {
            var $input = $(this).closest('[data-doc-row]').find('input[type="file"]').first();
            clearTokenForInput($input);
        });
    }

    /**
     * Build FormData without raw File objects — final save sends tokens only.
     */
    function buildFormDataWithoutFiles(form) {
        var fd = new FormData();
        var raw = new FormData(form);
        raw.forEach(function (value, key) {
            if (typeof File !== 'undefined' && value instanceof File) {
                return;
            }
            fd.append(key, value);
        });
        return fd;
    }

    function hasPendingUploads() {
        var pending = false;
        $('#msform input[type="file"]').each(function () {
            if ($(this).data('uploading')) {
                pending = true;
                return false;
            }
        });
        return pending;
    }

    function hasMissingRequiredDocTokens() {
        var missing = false;
        $('#documents input[type="file"][required]').each(function () {
            var $input = $(this);
            if (!$input.is(':visible') || $input.is(':disabled')) {
                return;
            }
            var token = ensureHiddenTokenInput($input).val();
            if (!token) {
                missing = true;
                return false;
            }
        });
        return missing;
    }

    window.initPolicyUpload = initPolicyUpload;
    window.buildPolicyFormDataWithoutFiles = buildFormDataWithoutFiles;
    window.policyUploadHasPending = hasPendingUploads;
    window.policyUploadHasMissingRequired = hasMissingRequiredDocTokens;
})(jQuery);
