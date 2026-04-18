{{-- resources/views/admin/attendance.blade.php --}}
@extends('admin.layout')

@section('title', 'Data Kehadiran')
@section('page-title', 'Data Kehadiran')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
    <div>
        <h2 style="font-size:1.1rem; font-weight:600;">📋 Rekap Kehadiran Peserta</h2>
        <p style="color:rgba(255,255,255,.45); font-size:.85rem; margin-top:.25rem;">
            Hanya menampilkan peserta yang sudah diterima
        </p>
    </div>
    <a href="{{ route('admin.scan') }}" class="btn btn-primary" style="padding:.65rem 1.25rem;">
        📷 Buka Scanner QR
    </a>
</div>

<div class="table-card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Tiket</th>
                    <th>Nama</th>
                    <th>Instansi</th>
                    <th>Email</th>
                    <th>Status Kehadiran</th>
                    <th>Waktu Scan</th>
                    <th>Di-scan Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                <tr>
                    <td style="color:rgba(255,255,255,.4); font-size:.8rem;">{{ $attendances->firstItem() + $loop->index }}</td>
                    <td>
                        <span style="font-family:monospace; color:var(--gold); font-size:.82rem; background:rgba(198,163,78,.1); padding:.2rem .5rem; border-radius:6px;">
                            {{ $att->participant->ticket_code }}
                        </span>
                    </td>
                    <td style="font-weight:500;">{{ $att->participant->name }}</td>
                    <td style="font-size:.85rem; color:rgba(255,255,255,.6);">{{ $att->participant->institution }}</td>
                    <td style="font-size:.83rem; color:rgba(255,255,255,.5);">{{ $att->participant->email }}</td>
                    <td>
                        @if($att->status === 'hadir')
                            <span class="badge badge-hadir">✅ Hadir</span>
                        @else
                            <span class="badge badge-belum">— Belum Hadir</span>
                        @endif
                    </td>
                    <td style="font-size:.83rem; color:rgba(255,255,255,.55);">
                        {{ $att->scanned_at ? $att->scanned_at->format('d M Y, H:i:s') : '—' }}
                    </td>
                    <td style="font-size:.83rem; color:rgba(255,255,255,.45);">
                        {{ $att->scanned_by ?? '—' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:rgba(255,255,255,.3); padding:2.5rem;">
                        Belum ada data kehadiran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($attendances->hasPages())
    <div class="pagination-wrap">
        {{ $attendances->links('admin.pagination') }}
    </div>
    @endif
</div>
@endsection
