@extends('frontend.layout.master')
@section('content')
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
    .queue-page {
        --sl-blue: #1f93d1;
        --sl-blue-dark: #0f4f73;
        --sl-blue-soft: #e8f5fc;
    }

    .queue-hero {
        background: linear-gradient(135deg, #e8f5fc 0%, #f7fbfe 50%, #ffffff 100%);
        border: 1px solid #cfe8f6;
        border-radius: 1rem;
        padding: 1.5rem 1.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: space-between;
        align-items: center;
    }

    .queue-hero__eyebrow {
        margin: 0 0 0.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--sl-blue);
    }

    .queue-hero__title {
        margin: 0 0 0.35rem;
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--sl-blue-dark);
    }

    .queue-hero__subtitle {
        margin: 0;
        color: #4a6575;
        max-width: 36rem;
        font-size: 0.95rem;
    }

    .queue-count-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: #fff;
        border: 1px solid #1f93d1;
        color: #1f93d1;
        font-weight: 700;
        border-radius: 999px;
        padding: 0.45rem 0.9rem;
        white-space: nowrap;
    }

    .queue-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.1rem;
    }

    .queue-card {
        background: #fff;
        border: 1px solid #e2eef5;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(15, 79, 115, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
    }

    .queue-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(31, 147, 209, 0.14);
    }

    .queue-card__head {
        background: var(--sl-blue-soft);
        border-bottom: 1px solid #d9eaf4;
        padding: 1rem 1.15rem;
    }

    .queue-card__product {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--sl-blue-dark);
    }

    .queue-card__meta {
        margin: 0.35rem 0 0;
        font-size: 0.82rem;
        color: #6b8494;
    }

    .queue-card__body {
        padding: 1rem 1.15rem 1.15rem;
        flex: 1;
    }

    .queue-progress {
        height: 8px;
        background: #eef5fa;
        border-radius: 999px;
        overflow: hidden;
        margin: 0.75rem 0 0.4rem;
    }

    .queue-progress > span {
        display: block;
        height: 100%;
        background: linear-gradient(90deg, #1f93d1, #4eb3e4);
        border-radius: 999px;
    }

    .queue-card__progress-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #0f4f73;
    }

    .queue-card__actions {
        display: flex;
        gap: 0.5rem;
        padding: 0 1.15rem 1.15rem;
        flex-wrap: wrap;
    }

    .btn-queue-primary {
        background: #1f93d1 !important;
        border-color: #1f93d1 !important;
        color: #fff !important;
        font-weight: 600;
        border-radius: 0.65rem;
        padding: 0.45rem 0.9rem;
        flex: 1;
        text-align: center;
    }

    .btn-queue-primary:hover {
        background: #1879ad !important;
        color: #fff !important;
    }

    .btn-queue-danger {
        background: #fff !important;
        border: 1px solid #e35d6a !important;
        color: #e35d6a !important;
        font-weight: 600;
        border-radius: 0.65rem;
        padding: 0.45rem 0.9rem;
    }

    .queue-empty {
        text-align: center;
        padding: 3rem 1.5rem;
        background: #fff;
        border: 1px dashed #cfe8f6;
        border-radius: 1rem;
    }

    .queue-empty i {
        font-size: 2.5rem;
        color: #1f93d1;
        margin-bottom: 0.75rem;
    }

    .queue-empty h3 {
        color: #0f4f73;
        font-weight: 700;
    }

    .queue-empty p {
        color: #6b8494;
        margin-bottom: 1.25rem;
    }
</style>

<main class="fix queue-page">
    <section class="breadcrumb__area breadcrumb__bg" data-background="{{ asset('frontend/images/breadcrumb_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">Application Queue</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Queue</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services-area services-bg py-5" data-background="{{ asset('frontend/images/services_bg.jpg') }}">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif

            <div class="queue-hero">
                <div>
                    <p class="queue-hero__eyebrow">Continue later</p>
                    <h1 class="queue-hero__title">Your Saved Applications</h1>
                    <p class="queue-hero__subtitle">
                        Incomplete policy forms are saved here automatically. You can keep up to
                        {{ $maxDrafts }} applications in the queue and resume anytime.
                    </p>
                </div>
                <div class="queue-count-pill">
                    <i class="fas fa-layer-group"></i>
                    {{ $drafts->count() }} / {{ $maxDrafts }} in queue
                </div>
            </div>

            @if($drafts->isEmpty())
                <div class="queue-empty">
                    <i class="fas fa-inbox"></i>
                    <h3>No applications in queue</h3>
                    <p>Start a policy application from Products. If you leave mid-way, it will appear here.</p>
                    <a href="{{ route('frontend.product') }}" class="btn btn-queue-primary">Browse Products</a>
                </div>
            @else
                <div class="queue-grid">
                    @foreach($drafts as $draft)
                        @php
                            $sections = max(1, (int) $draft->filled_sections);
                            $pct = min(100, (int) round(($sections / 9) * 100));
                        @endphp
                        <article class="queue-card">
                            <div class="queue-card__head">
                                <h2 class="queue-card__product">{{ $draft->product_name ?? ($draft->product->name ?? 'Policy Application') }}</h2>
                                <p class="queue-card__meta">
                                    Last updated {{ $draft->updated_at?->diffForHumans() }}
                                    @if($draft->progress_label)
                                        · {{ $draft->progress_label }}
                                    @endif
                                </p>
                            </div>
                            <div class="queue-card__body">
                                <div class="queue-card__progress-label">Progress: {{ $pct }}%</div>
                                <div class="queue-progress" aria-hidden="true"><span style="width: {{ $pct }}%"></span></div>
                                <p class="queue-card__meta mb-0">
                                    {{ $draft->filled_sections }} section(s) with data · Resume to continue filling
                                </p>
                            </div>
                            <div class="queue-card__actions">
                                <a href="{{ route('frontend.queue.resume', $draft->id) }}" class="btn btn-queue-primary">
                                    <i class="fas fa-play me-1"></i> Resume
                                </a>
                                <form action="{{ route('frontend.queue.destroy', $draft->id) }}" method="POST" onsubmit="return confirm('Remove this draft from your queue?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-queue-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</main>
@endsection
