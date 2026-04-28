@extends('layouts.app')

@section('content')

<style>
    body {
        background:
            radial-gradient(circle at top left, rgba(255, 255, 255, 0.16), transparent 32%),
            radial-gradient(circle at bottom right, rgba(255, 255, 255, 0.08), transparent 35%),
            #050505;
        color: #f5f5f5;
        min-height: 100vh;
        font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    .dashboard-shell {
        padding: 32px 0;
    }

    .glass-panel {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.14);
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
        border-radius: 28px;
        overflow: hidden;
    }

    .dashboard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 28px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .dashboard-eyebrow {
        margin-bottom: 8px;
        color: rgba(255, 255, 255, 0.56);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }

    .dashboard-title {
        margin: 0;
        color: #ffffff;
        font-size: clamp(28px, 4vw, 44px);
        font-weight: 800;
        letter-spacing: -0.05em;
        line-height: 1;
    }

    .dashboard-subtitle {
        max-width: 560px;
        margin: 12px 0 0;
        color: rgba(255, 255, 255, 0.62);
        font-size: 15px;
        line-height: 1.7;
    }

    .btn-glass-create {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        min-width: 150px;
        padding: 13px 20px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.24);
        background: rgba(255, 255, 255, 0.92);
        color: #050505;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 14px 35px rgba(255, 255, 255, 0.08);
        transition: all 0.25s ease;
    }

    .btn-glass-create:hover {
        background: #ffffff;
        color: #000000;
        transform: translateY(-2px);
        box-shadow: 0 18px 42px rgba(255, 255, 255, 0.14);
    }

    .table-wrap {
        padding: 18px;
    }

    .glass-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .glass-table thead th {
        padding: 14px 18px;
        color: rgba(255, 255, 255, 0.48);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        border: none;
        background: transparent;
    }

    .glass-table tbody tr {
        background: rgba(255, 255, 255, 0.075);
        border: 1px solid rgba(255, 255, 255, 0.11);
        box-shadow: 0 14px 35px rgba(0, 0, 0, 0.22);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        transition: all 0.25s ease;
    }

    .glass-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.11);
        transform: translateY(-2px);
        box-shadow: 0 20px 46px rgba(0, 0, 0, 0.34);
    }

    .glass-table tbody td {
        padding: 18px;
        color: rgba(255, 255, 255, 0.8);
        vertical-align: middle;
        border-top: 1px solid rgba(255, 255, 255, 0.09);
        border-bottom: 1px solid rgba(255, 255, 255, 0.09);
        background: transparent;
    }

    .glass-table tbody td:first-child {
        border-left: 1px solid rgba(255, 255, 255, 0.09);
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .glass-table tbody td:last-child {
        border-right: 1px solid rgba(255, 255, 255, 0.09);
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .qr-box {
        width: 92px;
        height: 92px;
        display: grid;
        place-items: center;
        padding: 10px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.24);
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.04);
    }

    .product-name {
        color: #ffffff;
        font-size: 16px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .product-description {
        max-width: 380px;
        color: rgba(255, 255, 255, 0.58);
        font-size: 14px;
        line-height: 1.6;
    }

    .price-pill {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #ffffff;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-glass {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 13px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.16);
        background: rgba(255, 255, 255, 0.07);
        color: rgba(255, 255, 255, 0.82);
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-glass:hover {
        background: rgba(255, 255, 255, 0.92);
        color: #000000;
        border-color: rgba(255, 255, 255, 0.85);
        transform: translateY(-1px);
    }

    .btn-glass-danger {
        padding: 8px 13px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.04);
        color: rgba(255, 255, 255, 0.62);
        font-size: 12px;
        font-weight: 800;
        transition: all 0.25s ease;
    }

    .btn-glass-danger:hover {
        background: #ffffff;
        color: #000000;
        border-color: #ffffff;
        transform: translateY(-1px);
    }

    .empty-state {
        padding: 44px 20px !important;
        text-align: center;
        color: rgba(255, 255, 255, 0.52) !important;
        font-size: 15px;
        letter-spacing: 0.02em;
    }

    @media (max-width: 768px) {
        .dashboard-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-glass-create {
            width: 100%;
        }

        .table-wrap {
            overflow-x: auto;
        }

        .glass-table {
            min-width: 860px;
        }
    }
</style>

<div class="dashboard-shell">
    <div class="glass-panel">
        <div class="dashboard-header">
            <div>
                <div class="dashboard-eyebrow">Product Inventory</div>
                <h1 class="dashboard-title">QR Code Dashboard</h1>
            </div>

            <a href="{{ route('products.create') }}" class="btn-glass-create">
                + Add Product
            </a>
        </div>

        <div class="table-wrap">
            <table class="glass-table">
                <thead>
                    <tr>
                        <th>QR Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th width="240">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="qr-box">
                                    {!! $product->qr !!}
                                </div>
                            </td>

                            <td>
                                <div class="product-name">
                                    {{ $product->name }}
                                </div>
                            </td>

                            <td>
                                <div class="product-description">
                                    {{ $product->description ?: 'No description available.' }}
                                </div>
                            </td>

                            <td>
                                <span class="price-pill">
                                    ₱{{ number_format($product->price, 2) }}
                                </span>
                            </td>

                            <td>
                                <div class="action-group">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn-glass">
                                        View
                                    </a>

                                    <a href="{{ route('products.edit', $product->id) }}" class="btn-glass">
                                        Edit
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-glass-danger"
                                            onclick="return confirm('Are you sure you want to delete this product?')"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                No products found. Create your first product to generate a QR code.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection