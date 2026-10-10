```blade
@extends('layouts.app')

@section('content')
<div class="transaction-detail">
    <div class="page-header">
        <div>
            <a href="{{ route('transactions.index') }}" class="back-link">
                &larr; Kembali ke transaksi
            </a>
            <h1>Detail Transaksi</h1>
            <p>Informasi lengkap transaksi stok bunga.</p>
        </div>

        <span class="status-badge {{ $transaction->type === 'masuk' ? 'badge-in' : 'badge-out' }}">
            {{ ucfirst($transaction->type) }}
        </span>
    </div>

    <div class="detail-card">
        <div class="card-header">
            <div>
                <span class="eyebrow">Nomor Referensi</span>
                <h2>{{ $transaction->reference_number }}</h2>
            </div>

            <span class="transaction-id">
                ID #{{ $transaction->id }}
            </span>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Nama Bunga</span>
                <span class="detail-value">
                    {{ $transaction->flower?->name ?? 'Bunga tidak ditemukan' }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Jenis Transaksi</span>
                <span class="detail-value">
                    {{ $transaction->type === 'masuk' ? 'Stok Masuk' : 'Stok Keluar' }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Jumlah</span>
                <span class="detail-value quantity">
                    {{ number_format($transaction->quantity, 0, ',', '.') }}
                    <small>batang</small>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Tanggal Transaksi</span>
                <span class="detail-value">
                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Sumber / Tujuan</span>
                <span class="detail-value">
                    {{ $transaction->source_destination }}
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Petugas</span>
                <span class="detail-value">
                    {{ $transaction->handled_by }}
                </span>
            </div>

            <div class="detail-item full-width">
                <span class="detail-label">Catatan</span>
                <p class="notes">
                    {{ $transaction->notes ?: 'Tidak ada catatan.' }}
                </p>
            </div>
        </div>

        <div class="card-footer">
            <span class="created-at">
                Dicatat pada
                {{ $transaction->created_at?->format('d M Y, H:i') ?? '-' }}
            </span>

            <div class="actions">
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <form
                    action="{{ route('transactions.destroy', $transaction) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok bunga juga akan disesuaikan.');"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Hapus Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .transaction-detail {
        max-width: 1000px;
        margin: 0 auto;
        padding: 32px 20px;
        color: #1f2937;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 14px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
    }

    .back-link:hover {
        color: #2563eb;
    }

    .page-header h1 {
        margin: 0 0 8px;
        font-size: 28px;
        font-weight: 700;
    }

    .page-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .status-badge {
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-in {
        background: #dcfce7;
        color: #166534;
    }

    .badge-out {
        background: #fee2e2;
        color: #991b1b;
    }

    .detail-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgb(15 23 42 / 4%);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 24px;
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }

    .eyebrow {
        display: block;
        margin-bottom: 8px;
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .card-header h2 {
        margin: 0;
        font-size: 20px;
        overflow-wrap: anywhere;
    }

    .transaction-id {
        color: #64748b;
        font-size: 13px;
        white-space: nowrap;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0;
        padding: 8px 24px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 20px 0;
        border-bottom: 1px solid #f1f5f9;
        min-width: 0;
    }

    .detail-item:nth-last-child(-n + 2) {
        border-bottom: none;
    }

    .detail-item:nth-child(odd) {
        padding-right: 24px;
    }

    .detail-item:nth-child(even) {
        padding-left: 24px;
    }

    .detail-label {
        color: #64748b;
        font-size: 13px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .quantity {
        color: #0f766e;
        font-size: 24px;
    }

    .quantity small {
        color: #64748b;
        font-size: 13px;
        font-weight: 400;
    }

    .full-width {
        grid-column: 1 / -1;
        padding-right: 0 !important;
        padding-left: 0 !important;
        border-bottom: none !important;
    }

    .notes {
        margin: 0;
        color: #374151;
        font-size: 14px;
        line-height: 1.7;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 20px 24px;
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
    }

    .created-at {
        color: #64748b;
        font-size: 12px;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .actions form {
        margin: 0;
    }

    .btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 10px 14px;
        border: 1px solid transparent;
        border-radius: 7px;
        font: inherit;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-secondary {
        background: #fff;
        border-color: #d1d5db;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #f3f4f6;
    }

    .btn-danger {
        background: #dc2626;
        color: #fff;
    }

    .btn-danger:hover {
        background: #b91c1c;
    }

    @media (max-width: 640px) {
        .transaction-detail {
            padding: 24px 14px;
        }

        .page-header h1 {
            font-size: 23px;
        }

        .card-header {
            align-items: flex-start;
            padding: 20px 16px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            padding: 8px 16px;
        }

        .detail-item:nth-child(odd),
        .detail-item:nth-child(even) {
            padding: 16px 0;
        }

        .detail-item:nth-last-child(-n + 2) {
            border-bottom: 1px solid #f1f5f9;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .card-footer {
            align-items: flex-start;
            flex-direction: column;
            padding: 20px 16px;
        }

        .actions {
            width: 100%;
            flex-wrap: wrap;
        }

        .actions form {
            flex: 1;
        }

        .actions .btn {
            width: 100%;
        }
    }
</style>
@endsection
```