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
        --shadow: 0 24px 70px rgba(0, 0, 0, 0.5);
        --blur: blur(26px);
        --radius-xl: 30px;
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

    .create-product-page {
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }

    .glass-modal {
        width: min(100%, 720px);
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border);
        background:
            linear-gradient(180deg, rgba(255,255,255,0.09), rgba(255,255,255,0.035)),
            var(--panel);
        backdrop-filter: var(--blur);
        -webkit-backdrop-filter: var(--blur);
        box-shadow: var(--shadow);
    }

    .glass-modal::before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background:
            linear-gradient(135deg, rgba(255,255,255,0.18), transparent 28%),
            radial-gradient(circle at top right, rgba(255,255,255,0.10), transparent 30%);
        opacity: 0.75;
    }

    .modal-inner {
        position: relative;
        z-index: 1;
        padding: 1.5rem;
    }

    .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding-bottom: 1.25rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid var(--border);
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        padding: 0.42rem 0.72rem;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-faint);
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        margin-bottom: 0.85rem;
    }

    .modal-title-custom {
        margin: 0;
        color: var(--text);
        font-size: clamp(1.9rem, 5vw, 3.4rem);
        line-height: 0.95;
        font-weight: 800;
        letter-spacing: -0.065em;
    }

    .modal-subtitle {
        margin: 0.85rem 0 0;
        color: var(--text-soft);
        line-height: 1.65;
        font-size: 0.96rem;
        max-width: 520px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        padding: 0.7rem 0.9rem;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-soft);
        font-size: 0.85rem;
        font-weight: 700;
    }

    .status-pill strong {
        color: var(--text);
        margin-left: 0.35rem;
    }

    .form-grid {
        display: grid;
        gap: 1rem;
    }

    .field-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .field-label {
        color: var(--text-faint);
        font-size: 0.76rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.11em;
    }

    .glass-input,
    .glass-textarea {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: rgba(255, 255, 255, 0.045);
        color: var(--text);
        padding: 0.9rem 1rem;
        font-size: 0.96rem;
        outline: none;
        transition: 0.2s ease;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    .glass-input:focus,
    .glass-textarea:focus {
        border-color: rgba(255, 255, 255, 0.45);
        background: rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.06);
        color: var(--text);
    }

    .glass-input::placeholder,
    .glass-textarea::placeholder {
        color: rgba(255, 255, 255, 0.35);
    }

    .glass-textarea {
        resize: vertical;
        min-height: 130px;
        line-height: 1.65;
    }

    .price-wrap {
        position: relative;
    }

    .currency-mark {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-faint);
        font-weight: 800;
        pointer-events: none;
    }

    .price-input {
        padding-left: 2.1rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        padding-top: 1.25rem;
        margin-top: 1.25rem;
        border-top: 1px solid var(--border);
        flex-wrap: wrap;
    }

    .mono-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        gap: 0.45rem;
        padding: 0.8rem 1rem;
        border-radius: 14px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, 0.05);
        color: var(--text);
        text-decoration: none;
        font-size: 0.92rem;
        font-weight: 800;
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

    .error-text {
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.84rem;
        margin-top: 0.35rem;
    }

    @media (max-width: 576px) {
        .create-product-page {
            align-items: flex-start;
            padding: 1rem 0;
        }

        .modal-inner {
            padding: 1rem;
        }

        .modal-header-custom {
            flex-direction: column;
        }

        .status-pill {
            width: 100%;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .mono-btn {
            width: 100%;
        }
    }
</style>

<div class="create-product-page">
    <div class="glass-modal">
        <div class="modal-inner">
            <div class="modal-header-custom">
                <div>
                    <div class="eyebrow">Create Product</div>
                    <h1 class="modal-title-custom">Add Product</h1>
                </div>

                <div class="status-pill">
                    Status <strong>New</strong>
                </div>
            </div>

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="field-group">
                        <label class="field-label" for="name">Product Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="glass-input"
                            value="{{ old('name') }}"
                            placeholder="Enter product name"
                            required
                        >

                        @error('name')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="description">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            class="glass-textarea"
                            rows="4"
                            placeholder="Write a short product description"
                        >{{ old('description') }}</textarea>

                        @error('description')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="price">Price</label>
                        <div class="price-wrap">
                            <span class="currency-mark">₱</span>
                            <input
                                type="number"
                                id="price"
                                name="price"
                                step="0.01"
                                class="glass-input price-input"
                                value="{{ old('price') }}"
                                placeholder="0.00"
                                required
                            >
                        </div>

                        @error('price')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('products.index') }}" class="mono-btn">
                        Back
                    </a>

                    <button type="submit" class="mono-btn primary">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection