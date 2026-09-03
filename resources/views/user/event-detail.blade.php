@extends('user.layout')

@section('title', $event->name)

@push('css')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')
<div class="dashboard-content" style="padding:1.5rem 1.75rem;">

    {{-- Back button --}}
    <div style="margin-bottom:1.25rem;">
        <a href="{{ url('/user/events') }}" class="btn btn-outline btn-sm">
            â† Kembali ke Semua Event
        </a>
    </div>

    {{-- Event Banner --}}
    <div style="border-radius:1rem;overflow:hidden;position:relative;height:260px;background:#0f1f4e;margin-bottom:1.5rem;">
        @if($event->banner_path)
            <img src="{{ $event->banner_url }}" alt="{{ $event->name }}"
                 style="width:100%;height:100%;object-fit:cover;">
        @endif
        <div style="position:absolute;top:1rem;left:1rem;">
            <span style="background:{{ $event->category->color }};color:#fff;padding:.3rem .75rem;border-radius:999px;font-size:.75rem;font-weight:700;">
                {{ $event->category->name }}
            </span>
        </div>
        <div style="position:absolute;top:1rem;right:1rem;">
            @php
                $statusStyle = match($event->status) {
                    'open'      => 'background:#10b981',
                    'closed'    => 'background:#f59e0b',
                    'completed' => 'background:#6b7280',
                    'cancelled' => 'background:#ef4444',
                    default     => 'background:#3b82f6',
                };
                $statusLabel = match($event->status) {
                    'open'      => 'Buka',
                    'closed'    => 'Tutup',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default     => 'Draft',
                };
            @endphp
            <span style="{{ $statusStyle }};color:#fff;padding:.3rem .75rem;border-radius:999px;font-size:.75rem;font-weight:700;">
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start;">

        {{-- Left: Event Info --}}
        <div>
            <h1 style="font-size:1.6rem;font-weight:800;color:var(--text-primary);margin-bottom:.5rem;">
                {{ $event->name }}
            </h1>
            <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:1.5rem;">
                Diselenggarakan oleh <strong>{{ $event->organizer }}</strong>
            </p>

            {{-- Detail grid --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1.5rem;">
                @foreach([
                    ['ðŸ“…', 'Tanggal', $event->formatted_date],
                    ['ðŸ•', 'Waktu', $event->formatted_time],
                    ['ðŸ“', 'Lokasi', $event->location],
                    ['ðŸ‘¥', 'Kuota', $event->registered_count . '/' . $event->quota . ' peserta'],
                ] as [$icon, $label, $value])
                <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.75rem;padding:.875rem 1rem;">
                    <div style="font-size:.7rem;color:var(--text-muted);font-weight:600;margin-bottom:.25rem;">{{ $icon }} {{ $label }}</div>
                    <div style="font-size:.875rem;font-weight:700;color:var(--text-primary);">{{ $value }}</div>
                </div>
                @endforeach

                {{-- Sertifikat dari DB --}}
                <div style="background:{{ $event->has_certificate ? '#dcfce7' : 'var(--bg-secondary)' }};border:1.5px solid {{ $event->has_certificate ? '#86efac' : 'var(--border-color)' }};border-radius:.75rem;padding:.875rem 1rem;">
                    <div style="font-size:.7rem;color:var(--text-muted);font-weight:600;margin-bottom:.25rem;">ðŸ† Sertifikat</div>
                    <div style="font-size:.875rem;font-weight:700;color:{{ $event->has_certificate ? '#15803d' : 'var(--text-primary)' }};">
                        {{ $event->has_certificate ? 'Tersedia âœ“' : 'Tidak tersedia' }}
                    </div>
                </div>

            </div>

            {{-- Quota bar --}}
            @if($event->quota > 0)
            <div style="margin-bottom:1.5rem;">
                @php $pct = min(100, round($event->registered_count / $event->quota * 100)); @endphp
                <div style="display:flex;justify-content:space-between;font-size:.78rem;color:var(--text-muted);margin-bottom:.35rem;">
                    <span>Kuota terisi</span><span>{{ $pct }}%</span>
                </div>
                <div style="height:8px;background:var(--bg-tertiary);border-radius:999px;overflow:hidden;">
                    <div style="height:100%;width:{{ $pct }}%;background:{{ $pct >= 90 ? '#ef4444' : '#3b82f6' }};border-radius:999px;transition:width .5s;"></div>
                </div>
            </div>
            @endif

            {{-- Description --}}
            <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:.75rem;padding:1.25rem;">
                <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:.75rem;">Deskripsi</h3>
                <p style="font-size:.875rem;color:var(--text-secondary);line-height:1.7;white-space:pre-line;">{{ $event->description }}</p>
            </div>
        </div>

        {{-- Right: Registration Card --}}
        <div style="background:var(--bg-secondary);border:1.5px solid var(--border-color);border-radius:1rem;padding:1.25rem;position:sticky;top:1rem;">
            <h3 style="font-size:1rem;font-weight:800;color:var(--text-primary);margin-bottom:1rem;">Pendaftaran</h3>

            {{-- Badge sertifikat di registration card --}}
            @if($event->has_certificate)
            <div style="background:#f0fdf4;border:1.5px solid #86efac;border-radius:.75rem;padding:.625rem .875rem;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;font-size:.8rem;font-weight:600;color:#15803d;">
                ðŸ† Event ini menyediakan <strong>sertifikat</strong> untuk peserta yang hadir
            </div>
            @endif

            @if($isRegistered)
                <div style="background:#dcfce7;border:1.5px solid #86efac;border-radius:.75rem;padding:.875rem;text-align:center;margin-bottom:1rem;">
                    <div style="font-size:1.5rem;">âœ…</div>
                    <div style="font-weight:700;color:#15803d;margin-top:.25rem;">Anda sudah terdaftar</div>
                </div>
                <a href="{{ url('/user/my-events') }}" class="btn btn-outline" style="width:100%;text-align:center;">
                    Lihat di Event Saya
                </a>

            @elseif($event->status !== 'open')
                <div style="background:var(--bg-tertiary);border-radius:.75rem;padding:.875rem;text-align:center;margin-bottom:1rem;">
                    <div style="font-size:1.5rem;">ðŸš«</div>
                    <div style="font-weight:600;color:var(--text-muted);margin-top:.25rem;">Pendaftaran tidak tersedia</div>
                    <div style="font-size:.78rem;color:var(--text-muted);margin-top:.25rem;">Status: {{ $statusLabel }}</div>
                </div>

            @elseif($event->isFull())
                <div style="background:#fef3c7;border:1.5px solid #fcd34d;border-radius:.75rem;padding:.875rem;text-align:center;margin-bottom:1rem;">
                    <div style="font-size:1.5rem;">ðŸ˜®</div>
                    <div style="font-weight:700;color:#b45309;margin-top:.25rem;">Kuota sudah penuh</div>
                </div>

            @else
                {{-- Tombol Daftar â€” trigger via JS (bukan form submit biasa) --}}
                <div style="font-size:.82rem;color:var(--text-muted);margin-bottom:1rem;line-height:1.5;">
                    Sisa kuota: <strong style="color:var(--text-primary);">{{ $event->getRemainingSlots() }} tempat</strong>
                </div>

                @if($event->isCompetition())
                    {{-- Competition: tombol buka form tim --}}
                    <button type="button" id="openTeamFormBtn" class="btn btn-primary" style="width:100%;">
                        ðŸ† Daftar Sebagai Tim
                    </button>
                    <p style="font-size:.72rem;color:var(--text-muted);text-align:center;margin-top:.5rem;">
                        Isi data tim setelah klik tombol di atas
                    </p>
                @else
                    {{-- Regular event: daftar langsung via AJAX --}}
                    <input type="hidden" id="regEventId" value="{{ $event->id }}">
                    <input type="hidden" id="regEventName" value="{{ addslashes($event->name) }}">
                    <input type="hidden" id="regIsCompetition" value="0">
                    <button type="button" id="registerBtn" class="btn btn-primary" style="width:100%;">
                        Daftar Sekarang
                    </button>
                @endif
            @endif

            {{-- Event meta --}}
            <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border-color);font-size:.75rem;color:var(--text-muted);">
                <div style="margin-bottom:.35rem;">ðŸ“Œ Dibuat oleh: {{ $event->creator->name }}</div>
                <div>ðŸ—“ Terakhir diperbarui: {{ $event->updated_at->format('d M Y') }}</div>
            </div>
        </div>

    </div>

    {{-- Flash messages --}}
    @if(session('success'))
    <div style="position:fixed;bottom:1.5rem;right:1.5rem;background:#dcfce7;border:1.5px solid #86efac;color:#15803d;padding:.875rem 1.25rem;border-radius:.75rem;font-weight:600;font-size:.875rem;box-shadow:0 4px 12px rgba(0,0,0,.1);z-index:9999;">
        âœ… {{ session('success') }}
    </div>
    @endif

</div>

    {{-- Flash messages dari server (fallback) --}}
    @if(session('success'))
    <div style="position:fixed;bottom:1.5rem;right:1.5rem;background:#dcfce7;border:1.5px solid #86efac;color:#15803d;padding:.875rem 1.25rem;border-radius:.75rem;font-weight:600;font-size:.875rem;box-shadow:0 4px 12px rgba(0,0,0,.1);z-index:9999;">
        Pendaftaran berhasil! {{ session('success') }}
    </div>
    @endif
</div>

{{-- ══════════════════════════════════════════════════
     MODAL 1: FORM TIM (competition only)
══════════════════════════════════════════════════ --}}
@if($event->isCompetition() && $event->status === 'open' && !$isRegistered && !$event->isFull())
<div id="teamFormModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:10000;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:var(--bg-secondary);border-radius:1.25rem;width:100%;max-width:540px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.25);">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--border-color);display:flex;align-items:center;justify-content:space-between;">
            <div>
                <div style="font-size:1rem;font-weight:800;color:var(--text-primary);">Daftarkan Tim</div>
                <div style="font-size:.78rem;color:var(--text-muted);margin-top:2px;">{{ $event->name }}</div>
            </div>
            <button onclick="closeTeamModal()" style="width:32px;height:32px;border-radius:50%;border:1.5px solid var(--border-color);background:transparent;cursor:pointer;font-size:1rem;color:var(--text-muted);">x</button>
        </div>
        <form id="teamForm" style="padding:1.25rem 1.5rem;">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.82rem;font-weight:700;color:var(--text-primary);margin-bottom:.35rem;">Nama Tim <span style="color:#ef4444;">*</span></label>
                <input type="text" name="team_name" id="teamName" required maxlength="100" placeholder="Contoh: Tim Garuda"
                       style="width:100%;padding:.625rem .875rem;border:1.5px solid var(--border-color);border-radius:.625rem;font-size:.875rem;background:var(--bg-primary);color:var(--text-primary);outline:none;box-sizing:border-box;">
                <small id="teamNameErr" style="color:#ef4444;font-size:.72rem;display:none;"></small>
            </div>

            <div style="margin-bottom:1rem;">
                <label style="display:block;font-size:.82rem;font-weight:700;color:var(--text-primary);margin-bottom:.35rem;">Nama Kapten <span style="color:#ef4444;">*</span></label>
                <input type="text" name="captain_name" id="captainName" required maxlength="100"
                       placeholder="Nama lengkap kapten" value="{{ Auth::user()->name }}"
                       style="width:100%;padding:.625rem .875rem;border:1.5px solid var(--border-color);border-radius:.625rem;font-size:.875rem;background:var(--bg-primary);color:var(--text-primary);outline:none;box-sizing:border-box;">
                <small id="captainErr" style="color:#ef4444;font-size:.72rem;display:none;"></small>
            </div>

            <div style="margin-bottom:1.25rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
                    <label style="font-size:.82rem;font-weight:700;color:var(--text-primary);">
                        Anggota Tim <span style="color:#ef4444;">*</span>
                        <span style="font-weight:400;color:var(--text-muted);font-size:.75rem;">(min. 1)</span>
                    </label>
                    <button type="button" onclick="addMember()"
                            style="padding:.3rem .75rem;border-radius:.5rem;border:1.5px solid #3b82f6;background:#eff6ff;color:#1d4ed8;font-size:.75rem;font-weight:700;cursor:pointer;">
                        + Anggota
                    </button>
                </div>
                <div id="membersContainer" style="display:flex;flex-direction:column;gap:.5rem;"></div>
                <small id="membersErr" style="color:#ef4444;font-size:.72rem;display:none;"></small>
            </div>

            <div style="background:var(--bg-tertiary);border-radius:.625rem;padding:.625rem 1rem;margin-bottom:1.25rem;font-size:.78rem;color:var(--text-muted);">
                Total: <strong id="totalCount" style="color:var(--text-primary);">2</strong> orang (kapten + anggota)
            </div>

            <div style="display:flex;gap:.625rem;">
                <button type="button" onclick="closeTeamModal()"
                        style="flex:1;padding:.75rem;border-radius:.75rem;border:1.5px solid var(--border-color);background:transparent;font-size:.875rem;font-weight:700;cursor:pointer;color:var(--text-secondary);">
                    Batal
                </button>
                <button type="submit" id="submitTeamBtn"
                        style="flex:2;padding:.75rem;border-radius:.75rem;border:none;background:#0f1f4e;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;">
                    Daftarkan Tim
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══════════════════════════════════════════════════
     MODAL 2: SUKSES
══════════════════════════════════════════════════ --}}
<div id="successModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:10001;align-items:center;justify-content:center;padding:1rem;">
    <div style="background:var(--bg-secondary);border-radius:1.25rem;width:100%;max-width:420px;padding:2rem;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.25);">
        <div style="width:72px;height:72px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;font-size:2.2rem;color:#fff;">✓</div>
        <h2 id="successTitle" style="font-size:1.2rem;font-weight:800;color:var(--text-primary);margin-bottom:.5rem;">Pendaftaran Berhasil!</h2>
        <p id="successMessage" style="font-size:.875rem;color:var(--text-secondary);line-height:1.6;margin-bottom:1rem;">Anda berhasil mendaftar.</p>
        <div id="successDetail" style="background:var(--bg-tertiary);border-radius:.75rem;padding:.875rem;margin-bottom:1.5rem;font-size:.82rem;color:var(--text-muted);text-align:left;display:none;"></div>
        <div style="display:flex;gap:.625rem;">
            <a href="{{ url('/user/my-events') }}"
               style="flex:1;padding:.75rem;border-radius:.75rem;border:1.5px solid var(--border-color);background:transparent;font-size:.875rem;font-weight:700;cursor:pointer;color:var(--text-secondary);text-decoration:none;display:block;text-align:center;">
                Event Saya
            </a>
            <button onclick="closeSuccessModal()"
                    style="flex:1;padding:.75rem;border-radius:.75rem;border:none;background:#0f1f4e;color:#fff;font-size:.875rem;font-weight:700;cursor:pointer;">
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@push('js')
@vite('resources/js/utils/api.js')
<script>
var EVENT_ID = {{ $event->id }};
var EVENT_NAME = @json($event->name);
var IS_COMP = {{ $event->isCompetition() ? 'true' : 'false' }};
var memberCount = 0;

document.addEventListener('DOMContentLoaded', function () {
    if (IS_COMP) addMember();

    var regBtn = document.getElementById('registerBtn');
    if (regBtn) {
        regBtn.addEventListener('click', function () {
            if (!confirm('Daftar ke event "' + EVENT_NAME + '"?')) return;
            doRegister();
        });
    }

    var openTeam = document.getElementById('openTeamFormBtn');
    if (openTeam) openTeam.addEventListener('click', openTeamModal);

    var teamForm = document.getElementById('teamForm');
    if (teamForm) teamForm.addEventListener('submit', function (e) { e.preventDefault(); submitTeamForm(); });
});

// ── Daftar biasa (non-competition) ──
async function doRegister() {
    var btn = document.getElementById('registerBtn');
    if (btn) { btn.disabled = true; btn.textContent = 'Mendaftar...'; }
    try {
        var res = await api.post('/user/events/register', { event_id: EVENT_ID });
        if (res.success) {
            showSuccessModal(res, null, null, null);
            setTimeout(function () { location.reload(); }, 3000);
        } else {
            alert(res.message || 'Pendaftaran gagal.');
            if (btn) { btn.disabled = false; btn.textContent = 'Daftar Sekarang'; }
        }
    } catch (err) {
        var msg = (err && err.data && err.data.message) ? err.data.message : 'Terjadi kesalahan.';
        alert(msg);
        if (btn) { btn.disabled = false; btn.textContent = 'Daftar Sekarang'; }
    }
}

// ── Modal tim ──
function openTeamModal()  { var m=document.getElementById('teamFormModal'); if(m){m.style.display='flex';document.body.style.overflow='hidden';} }
function closeTeamModal() { var m=document.getElementById('teamFormModal'); if(m){m.style.display='none';document.body.style.overflow='';} }
document.addEventListener('keydown', function(e){ if(e.key==='Escape'){closeTeamModal();closeSuccessModal();} });

// ── Tambah / hapus anggota ──
function addMember() {
    var container = document.getElementById('membersContainer');
    if (!container) return;
    memberCount++;
    var row = document.createElement('div');
    row.style.cssText = 'display:flex;gap:.4rem;align-items:center;';
    row.innerHTML = '<input type="text" name="members[]" required maxlength="100" placeholder="Nama anggota ' + memberCount + '" '
        + 'style="flex:1;padding:.55rem .75rem;border:1.5px solid var(--border-color);border-radius:.5rem;font-size:.82rem;background:var(--bg-primary);color:var(--text-primary);outline:none;">'
        + '<button type="button" onclick="removeMember(this)" '
        + 'style="width:30px;height:30px;border-radius:50%;border:1.5px solid #fca5a5;background:#fff5f5;color:#ef4444;cursor:pointer;font-size:.9rem;flex-shrink:0;">x</button>';
    container.appendChild(row);
    updateTotalCount();
}

function removeMember(btn) {
    var rows = document.querySelectorAll('#membersContainer > div');
    if (rows.length <= 1) { alert('Minimal 1 anggota tim.'); return; }
    btn.closest('div').remove();
    updateTotalCount();
}

function updateTotalCount() {
    var c = document.querySelectorAll('#membersContainer > div').length;
    var el = document.getElementById('totalCount');
    if (el) el.textContent = c + 1;
}

// ── Submit form tim ──
async function submitTeamForm() {
    var btn = document.getElementById('submitTeamBtn');
    ['teamNameErr','captainErr','membersErr'].forEach(function(id){
        var el=document.getElementById(id); if(el){el.style.display='none';el.textContent='';}
    });

    var teamName    = (document.getElementById('teamName')?.value || '').trim();
    var captainName = (document.getElementById('captainName')?.value || '').trim();
    var inputs      = document.querySelectorAll('#membersContainer input[name="members[]"]');
    var members     = Array.from(inputs).map(function(i){return i.value.trim();}).filter(Boolean);

    var valid = true;
    if (!teamName)         { showErr('teamNameErr','Nama tim harus diisi.'); valid=false; }
    if (!captainName)      { showErr('captainErr','Nama kapten harus diisi.'); valid=false; }
    if (members.length===0){ showErr('membersErr','Minimal 1 anggota harus diisi.'); valid=false; }
    if (!valid) return;

    if (btn) { btn.disabled=true; btn.textContent='Mendaftarkan Tim...'; }

    try {
        var res = await api.post('/user/events/register', {
            event_id: EVENT_ID, team_name: teamName, captain_name: captainName, members: members
        });
        if (res.success) {
            closeTeamModal();
            showSuccessModal(res, teamName, captainName, members);
            setTimeout(function(){location.reload();}, 3500);
        } else {
            alert(res.message || 'Pendaftaran gagal.');
            if (btn) { btn.disabled=false; btn.textContent='Daftarkan Tim'; }
        }
    } catch(err) {
        if (err && err.data && err.data.errors) {
            var e=err.data.errors;
            if(e.team_name)    showErr('teamNameErr', e.team_name[0]);
            if(e.captain_name) showErr('captainErr',  e.captain_name[0]);
            if(e.members)      showErr('membersErr',  e.members[0]);
        } else {
            alert((err && err.data && err.data.message) ? err.data.message : 'Terjadi kesalahan.');
        }
        if (btn) { btn.disabled=false; btn.textContent='Daftarkan Tim'; }
    }
}

function showErr(id, msg) {
    var el=document.getElementById(id);
    if(el){ el.textContent=msg; el.style.display='block'; }
}

// ── Modal sukses ──
function showSuccessModal(res, teamName, captainName, members) {
    var modal=document.getElementById('successModal');
    var title=document.getElementById('successTitle');
    var msg=document.getElementById('successMessage');
    var detail=document.getElementById('successDetail');
    if(!modal) return;
    if(title)   title.textContent   = 'Pendaftaran Berhasil!';
    if(msg)     msg.textContent     = res.message || 'Anda berhasil mendaftar.';
    if(detail && res.is_competition && teamName) {
        var mList = (members||[]).map(function(m){return '<li>'+m+'</li>';}).join('');
        detail.innerHTML = '<strong>Data Tim:</strong><br>Nama: ' + teamName
            + '<br>Kapten: ' + captainName
            + (mList ? '<br>Anggota:<ul style="margin:.25rem 0 0 1rem;">'+mList+'</ul>' : '');
        detail.style.display = 'block';
    } else if(detail) { detail.style.display='none'; }
    modal.style.display='flex';
    document.body.style.overflow='hidden';
}

function closeSuccessModal() {
    var m=document.getElementById('successModal');
    if(m){ m.style.display='none'; document.body.style.overflow=''; }
}
</script>
@endpush
