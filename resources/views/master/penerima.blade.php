@extends('layouts.app')

@section('title', 'Penerima')

@section('content')
    <div class="page-header">
        <div>
            <h1>Penerima</h1>
            <p>Kelola master data penerima barang.</p>
        </div>
        <div class="page-header-actions">
            <button type="button" class="btn btn-primary btn-sm" onclick="openModal('create')">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Tambah Penerima
            </button>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <div>
                <h3>Daftar Penerima</h3>
                <p class="table-header-sub">Total: {{ $items->count() }} penerima</p>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Penerima</th>
                    <th>Alamat</th>
                    <th style="width: 140px;">Telepon</th>
                    <th style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="font-weight: 500; color: var(--color-text);">{{ $item->nama }}</td>
                        <td style="font-size: 13px; color: var(--color-text-secondary);">{{ $item->alamat ?? '-' }}</td>
                        <td class="mono">{{ $item->telepon ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <button type="button" class="btn-icon" title="Edit" onclick="openModal('edit', {{ $item->id }}, '{{ addslashes($item->nama) }}', '{{ addslashes($item->alamat ?? '') }}', '{{ addslashes($item->telepon ?? '') }}')">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('penerima-master.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin hapus penerima ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="Hapus" style="color: var(--color-danger);">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px 24px; color: var(--color-text-muted);">
                            <div style="font-size: 15px; font-weight: 600; color: var(--color-text-secondary); margin-bottom: 4px;">Belum ada data</div>
                            <div style="font-size: 13px;">Tambahkan penerima pertama</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('modals')
<div id="modalOverlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); z-index: 9999; justify-content: center; align-items: center;" onclick="if(event.target===this) closeModal()">
    <div style="background: var(--color-surface); border-radius: 16px; padding: 32px; width: 100%; max-width: 500px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); border: 1px solid var(--color-border); animation: modalIn 0.2s ease-out;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
            <h3 id="modalTitle" style="font-size: 18px; font-weight: 700; color: var(--color-text);"></h3>
            <button type="button" onclick="closeModal()" style="background: none; border: none; cursor: pointer; padding: 4px; color: var(--color-text-muted);">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="createForm" action="{{ route('penerima-master.store') }}" method="POST" style="display: none;">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label class="form-label">Nama Penerima <span style="color: var(--color-danger);">*</span></label>
                    <input type="text" name="nama" class="form-input" placeholder="Masukkan nama penerima" required id="createNama">
                </div>
                <div>
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-input" placeholder="Alamat penerima" id="createAlamat">
                </div>
                <div>
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-input" placeholder="08xxxxxxxxxx" id="createTelepon">
                </div>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>

        <form id="editForm" action="" method="POST" style="display: none;">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 20px;">
                <div>
                    <label class="form-label">Nama Penerima <span style="color: var(--color-danger);">*</span></label>
                    <input type="text" name="nama" class="form-input" required id="editNama">
                </div>
                <div>
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-input" id="editAlamat">
                </div>
                <div>
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-input" id="editTelepon">
                </div>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
<style>
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    function openModal(mode, id = null, nama = '', alamat = '', telepon = '') {
        const overlay = document.getElementById('modalOverlay');
        const createForm = document.getElementById('createForm');
        const editForm = document.getElementById('editForm');
        const title = document.getElementById('modalTitle');
        overlay.style.display = 'flex';
        if (mode === 'create') {
            title.textContent = 'Tambah Penerima';
            createForm.style.display = 'block';
            editForm.style.display = 'none';
            document.getElementById('createNama').value = '';
            document.getElementById('createAlamat').value = '';
            document.getElementById('createTelepon').value = '';
            setTimeout(() => document.getElementById('createNama').focus(), 100);
        } else {
            title.textContent = 'Edit Penerima';
            createForm.style.display = 'none';
            editForm.style.display = 'block';
            editForm.action = `/penerima-master/${id}`;
            document.getElementById('editNama').value = nama;
            document.getElementById('editAlamat').value = alamat;
            document.getElementById('editTelepon').value = telepon;
            setTimeout(() => document.getElementById('editNama').focus(), 100);
        }
    }
    function closeModal() { document.getElementById('modalOverlay').style.display = 'none'; }
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeModal(); });
    @if($errors->any()) openModal('create'); @endif
</script>
@endpush
