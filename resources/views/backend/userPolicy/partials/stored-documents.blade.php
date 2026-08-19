@php
    $docs = $docs ?? [];
    $usePublicPath = $usePublicPath ?? false;
@endphp
@forelse($docs as $doc)
    @php
        $file = $doc['file'] ?? null;
        $label = $doc['label'] ?? 'Document';
        $isImage = \App\Support\PolicyStoredDocuments::isImage($file);
        $webSrc = $file ? asset('uploads/policy_documents/'.$file) : null;
        $pdfSrc = $file ? public_path('uploads/policy_documents/'.$file) : null;
        $src = $usePublicPath ? $pdfSrc : $webSrc;
    @endphp
    @if($usePublicPath)
        <tr>
            <td>
                <div class="detail-label">{{ $label }}</div>
                <div class="detail-value">
                    @if($file && $isImage)
                        <img src="{{ $src }}" alt="{{ $label }}" class="doc-image">
                    @elseif($file)
                        {{ $file }}
                    @else
                        ---
                    @endif
                </div>
            </td>
            <td></td>
        </tr>
    @else
        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">{{ $label }}</div>
                <div class="detail-value">
                    @if($file && $isImage)
                        <a href="{{ $webSrc }}" target="_blank">
                            <img src="{{ $webSrc }}" alt="{{ $label }}" class="img-fluid rounded" style="max-height:120px;">
                        </a>
                    @elseif($file)
                        <a href="{{ $webSrc }}" target="_blank">{{ $file }}</a>
                    @else
                        ---
                    @endif
                </div>
            </div>
        </div>
    @endif
@empty
@endforelse
