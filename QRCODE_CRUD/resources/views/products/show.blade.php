@extends('layouts.app')

@section('content')
<style>
    :root {
        --bg: #050505;
        --panel: rgba(255, 255, 255, 0.06);
        --panel-strong: rgba(255, 255, 255, 0.10);
        --border: rgba(255, 255, 255, 0.14);
        --border-strong: rgba(255, 255, 255, 0.24);
        --text: #ffffff;
        --text-soft: rgba(255, 255, 255, 0.72);
        --text-faint: rgba(255, 255, 255, 0.48);
        --shadow: 0 24px 70px rgba(0, 0, 0, 0.45);
        --blur: blur(24px);
        --radius-xl: 28px;
        --radius-lg: 20px;
        --radius-md: 14px;
    }

    body {
        background:
            radial-gradient(circle at top left, rgba(255, 255, 255, 0.12), transparent 24%),
            radial-gradient(circle at bottom right, rgba(255, 255, 255, 0.06), transparent 22%),
            linear-gradient(180deg, #0a0a0a 0%, #050505 100%);
        color: var(--text);
        min-height: 100vh;
    }

    .product-show-page {
        padding: 2rem 0;
    }

    .show-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        padding: 0.45rem 0.75rem;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-faint);
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        margin-bottom: 0.85rem;
        backdrop-filter: var(--blur);
        -webkit-backdrop-filter: var(--blur);
    }

    .show-title {
        margin: 0;
        font-size: clamp(2rem, 5vw, 4.5rem);
        line-height: 0.95;
        letter-spacing: -0.07em;
        font-weight: 800;
        color: var(--text);
    }

    .show-subtitle {
        margin: 1rem 0 0;
        max-width: 620px;
        color: var(--text-soft);
        font-size: 1rem;
        line-height: 1.7;
    }

    .show-actions {
        display: flex;
        gap: 0.7rem;
        flex-wrap: wrap;
    }

    .mono-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.45rem;
        padding: 0.75rem 1rem;
        border-radius: 14px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.05);
        color: var(--text);
        text-decoration: none;
        font-size: 0.92rem;
        font-weight: 700;
        transition: 0.2s ease;
        backdrop-filter: var(--blur);
        -webkit-backdrop-filter: var(--blur);
    }

    .mono-btn:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: var(--border-strong);
        color: var(--text);
        transform: translateY(-1px);
    }

    .mono-btn.primary {
        background: rgba(255, 255, 255, 0.92);
        color: #050505;
        border-color: rgba(255, 255, 255, 0.95);
        box-shadow: 0 12px 26px rgba(255, 255, 255, 0.08);
    }

    .mono-btn.primary:hover {
        background: #ffffff;
        color: #000000;
    }

    .show-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(320px, 0.8fr);
        gap: 1.2rem;
        align-items: stretch;
    }

    .glass-panel {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border);
        background:
            linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.035)),
            var(--panel);
        backdrop-filter: var(--blur);
        -webkit-backdrop-filter: var(--blur);
        box-shadow: var(--shadow);
    }

    .glass-panel::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background:
            linear-gradient(135deg, rgba(255,255,255,0.16), transparent 28%),
            radial-gradient(circle at top right, rgba(255,255,255,0.10), transparent 26%);
        opacity: 0.75;
    }

    .panel-content {
        position: relative;
        z-index: 1;
        padding: 1.4rem;
    }

    .details-panel {
        min-height: 460px;
    }

    .panel-label {
        color: var(--text-faint);
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }

    .product-name-large {
        font-size: clamp(2rem, 4vw, 3.6rem);
        line-height: 1;
        letter-spacing: -0.06em;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 1rem;
    }

    .description-box {
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        background: rgba(255, 255, 255, 0.035);
        padding: 1rem;
        color: var(--text-soft);
        line-height: 1.7;
        margin-bottom: 1.2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.85rem;
        margin-top: 1.2rem;
    }

    .info-card {
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        background: rgba(255, 255, 255, 0.04);
        padding: 1rem;
        min-height: 105px;
    }

    .info-card span {
        display: block;
        color: var(--text-faint);
        font-size: 0.74rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.11em;
        margin-bottom: 0.55rem;
    }

    .info-card strong {
        display: block;
        color: var(--text);
        font-size: 1.3rem;
        line-height: 1.2;
        word-break: break-word;
    }

    .price-card strong {
        font-size: 2rem;
        letter-spacing: -0.04em;
    }

    .qr-panel {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        text-align: center;
        min-height: 460px;
    }

    .qr-shell {
        margin: 1.5rem auto;
        width: min(100%, 260px);
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.3rem;
        border-radius: 28px;
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(255, 255, 255, 0.85);
        box-shadow:
            inset 0 1px 0 rgba(255,255,255,0.6),
            0 24px 50px rgba(0, 0, 0, 0.3);
    }

    .qr-shell svg,
    .qr-shell img {
        width: 100%;
        max-width: 210px;
        height: auto;
        display: block;
    }

    .qr-title {
        margin: 0;
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        color: var(--text);
    }

    .qr-text {
        max-width: 280px;
        margin: 0.7rem auto 0;
        color: var(--text-soft);
        font-size: 0.92rem;
        line-height: 1.6;
    }

    .qr-footnote {
        margin-top: 1rem;
        padding: 0.85rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.035);
        color: var(--text-faint);
        font-size: 0.82rem;
        line-height: 1.5;
    }

    @media (max-width: 992px) {
        .show-grid {
            grid-template-columns: 1fr;
        }

        .details-panel,
        .qr-panel {
            min-height: auto;
        }
    }

    @media (max-width: 576px) {
        .product-show-page {
            padding: 1rem 0;
        }

        .show-actions {
            width: 100%;
        }

        .mono-btn {
            width: 100%;
        }

        .panel-content {
            padding: 1rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .qr-shell {
            width: min(100%, 220px);
        }
    }
</style>

<div class="product-show-page">
    <div class="show-header">
        <div>
            <div class="eyebrow">Product Record</div>
            <h1 class="show-title">Product Details</h1>
        </div>

        <div class="show-actions">
            <a href="{{ route('products.edit', $product->id) }}" class="mono-btn primary">
                Edit Product
            </a>

            <a href="{{ route('products.index') }}" class="mono-btn">
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="show-grid">
        <section class="glass-panel details-panel">
            <div class="panel-content">
                <div class="panel-label">Product Information</div>

                <div class="product-name-large">
                    {{ $product->name }}
                </div>

                <div class="description-box">
                    {{ $product->description ?: 'No description provided for this product.' }}
                </div>

                <div class="info-grid">
                    <div class="info-card">
                        <span>Product ID</span>
                        <strong>#{{ $product->id }}</strong>
                    </div>

                    <div class="info-card price-card">
                        <span>Price</span>
                        <strong>₱{{ number_format($product->price, 2) }}</strong>
                    </div>

                    <div class="info-card">
                        <span>Name</span>
                        <strong>{{ $product->name }}</strong>
                    </div>

                    <div class="info-card">
                        <span>Status</span>
                        <strong>QR Ready</strong>
                    </div>
                </div>
            </div>
        </section>

        <aside class="glass-panel qr-panel">
            <div class="panel-content">
                <div class="panel-label">Generated QR Code</div>

                <h2 class="qr-title">Scan Product Data</h2>
                <p class="qr-text">
                    This QR code contains the product details generated from the current product record.
                </p>

                <div class="qr-shell">
                    {!! $qr !!}
                </div>

                <div class="qr-footnote">
                    Use any QR scanner to view the encoded product information.
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection