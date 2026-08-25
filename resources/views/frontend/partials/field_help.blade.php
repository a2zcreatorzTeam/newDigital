{{--
  Reusable Policy Buy field-help icon.

  @param string $text   Help text shown in the tooltip (required)
  @param string|null $id Optional tooltip element id

  Example:
    <label>
      Province
      @include('frontend.partials.field_help', ['text' => 'Select the province for this address.'])
    </label>

  Prefer data-field-help on the label/control when auto-enhancement is enough:
    <label data-field-help="Select the province for this address.">Province</label>
--}}
@php
    $text = trim((string) ($text ?? ''));
    $id = $id ?? ('field-help-static-' . uniqid());
@endphp
@if($text !== '')
<span class="field-help" data-field-help-root="1">
    <button type="button"
        class="field-help__trigger"
        aria-label="Help: {{ $text }}"
        aria-describedby="{{ $id }}"
        aria-expanded="false"
        aria-controls="{{ $id }}">
        <span aria-hidden="true">i</span>
    </button>
    <span class="field-help__panel" id="{{ $id }}" role="tooltip">{{ $text }}</span>
</span>
@endif
