{{-- resources/views/admin/participants.blade.php --}}
@extends('admin.layout')

@section('title', 'Data Peserta')
@section('page-title', 'Data Peserta')

@section('content')
<div class="table-card">
    <div class="table-header">
        <span class="table-title">👥 Daftar Peserta</span>
        <form method="GET" action="{{ route('admin.participants') }}" style="display:flex; gap:.5rem; flex-wrap:wrap;">
            <input type="text" name="search" class="input-sm" placeholder="🔍 Cari nama / email / kode..." value="{{ request('search') }}" style="min-width:200px;">
            <select name="status" class="input-sm">
                <option value="">Semua Status</option>
                <option value="pending"  {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="accepted" {{ request('status') === 'accepted'  ? 'selected' : '' }}>Diterima</option>
                <option value="rejected" {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
            @if(request()->hasAny(['search','status']))
            <a href="{{ route('admin.participants') }}" class="btn btn-gold">Reset</a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Tiket</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>HP</th>
                    <th>Umur</th>
                    <th>Instansi</th>
                    <th>Sumber Info</th>
                    <th>Status</th>
                    <th>Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $p)
                <tr>
                    <td style="color:rgba(255,255,255,.4); font-size:.8rem;">{{ $participants->firstItem() + $loop->index }}</td>
                    <td>
                        <span style="font-family:monospace; color:var(--gold); font-size:.82rem; background:rgba(198,163,78,.1); padding:.2rem .5rem; border-radius:6px;">
                            {{ $p->ticket_code }}
                        </span>
                    </td>
                    <td style="font-weight:500;">{{ $p->name }}</td>
                    <td style="color:rgba(255,255,255,.6); font-size:.85rem;">{{ $p->email }}</td>
                    <td style="color:rgba(255,255,255,.6); font-size:.85rem;">{{ $p->phone }}</td>
                    <td>
                        <span class="badge" style="background:rgba(168,85,247,.1);color:#c084fc;border:1px solid rgba(168,85,247,.3);">
                            {{ $p->age_range }} thn
                        </span>
                    </td>
                    <td style="font-size:.85rem; max-width:150px; word-break:break-word;">{{ $p->institution }}</td>
                    <td style="font-size:.8rem; color:rgba(255,255,255,.55);">{{ $p->info_source }}</td>
                    <td>
                        @if($p->status === 'accepted')
                            <span class="badge badge-accepted">✅ Diterima</span>
                        @elseif($p->status === 'rejected')
                            <span class="badge badge-rejected">❌ Ditolak</span>
                        @else
                            <span class="badge badge-pending">⏳ Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($p->attendance)
                            @if($p->attendance->status === 'hadir')
                                <span class="badge badge-hadir">✅ Hadir</span>
                                <div style="font-size:.72rem; color:rgba(255,255,255,.35); margin-top:.2rem;">
                                    {{ $p->attendance->scanned_at?->format('d/m H:i') }}
                                </div>
                            @else
                                <span class="badge badge-belum">— Belum</span>
                            @endif
                        @else
                            <span style="color:rgba(255,255,255,.25); font-size:.8rem;">-</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:.4rem; flex-wrap:wrap;">
                            <!-- Lihat Bukti -->
                            <a href="{{ route('admin.participants.proof', $p) }}" target="_blank" class="btn btn-gold" title="Lihat Bukti Pembayaran">
                                🧾
                            </a>

                            <!-- Accept -->
                            @if($p->status === 'pending')
                            <form method="POST" action="{{ route('admin.participants.accept', $p) }}" style="display:inline;" onsubmit="return confirm('Terima peserta {{ addslashes($p->name) }}? Tiket akan dikirim ke email.')">
                                @csrf
                                <button type="submit" class="btn btn-green" title="Terima & Kirim Tiket">✅</button>
                            </form>
                            <form method="POST" action="{{ route('admin.participants.reject', $p) }}" style="display:inline;" onsubmit="return confirm('Tolak peserta {{ addslashes($p->name) }}?')">
                                @csrf
                                <button type="submit" class="btn btn-red" title="Tolak">❌</button>
                            </form>
                            @endif

                            @if($p->status === 'accepted' && $p->ticket_sent)
                            <span title="Tiket sudah dikirim" style="font-size:.8rem; color:rgba(34,197,94,.6);">📧</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" style="text-align:center; color:rgba(255,255,255,.3); padding:2.5rem;">
                        Tidak ada data peserta ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($participants->hasPages())
    <div class="pagination-wrap">
        {{ $participants->links('admin.pagination') }}
    </div>
    @endif
</div>
@endsection
