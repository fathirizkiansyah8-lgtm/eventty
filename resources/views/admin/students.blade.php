<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/students.css'
    ])
</head>
<body>
<script>(function(){ var t=localStorage.getItem('theme')||'light'; document.body.setAttribute('data-theme',t); })();</script>

<button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
</button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

@include('admin.partials.sidebar', ['activePage' => 'students'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <h1 class="admin-page-hd-title">Data Siswa</h1>
        </div>

        <!-- Search and Filter -->
        <div class="admin-table-hd">
            <div class="admin-search-wrap">
                <input type="text" class="admin-search-input" id="searchInput" placeholder="Cari siswa...">
            </div>
            <div class="admin-filter-row">
                <select class="admin-select" id="classFilter">
                    <option value="">Semua Kelas</option>
                    <option value="X">Kelas X</option>
                    <option value="XI">Kelas XI</option>
                    <option value="XII">Kelas XII</option>
                </select>
                <select class="admin-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>

        <!-- Students Table -->
        <div class="admin-table-wrap">
            <div class="admin-table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #2563eb); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">F</div> Fathi</div></td>
                        <td>12345</td>
                        <td>XII IPA 1</td>
                        <td>fathi@sekolah.sch.id</td>
                        <td><span class="abadge abadge-green">Active</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="abtn abtn-outline abtn-sm action-btn">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #7c3aed, #5b21b6); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">A</div> Ahmad</div></td>
                        <td>12346</td>
                        <td>XII IPA 2</td>
                        <td>ahmad@sekolah.sch.id</td>
                        <td><span class="abadge abadge-green">Active</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="abtn abtn-outline abtn-sm action-btn">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #059669, #047857); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">B</div> Budi</div></td>
                        <td>12347</td>
                        <td>XI IPS 1</td>
                        <td>budi@sekolah.sch.id</td>
                        <td><span class="abadge abadge-green">Active</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="abtn abtn-outline abtn-sm action-btn">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #d97706, #b45309); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">C</div> Citra</div></td>
                        <td>12348</td>
                        <td>X IPA 1</td>
                        <td>citra@sekolah.sch.id</td>
                        <td><span class="abadge abadge-green">Active</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="abtn abtn-outline abtn-sm action-btn">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #db2777, #be185d); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">D</div> Dewi</div></td>
                        <td>12349</td>
                        <td>XII IPS 1</td>
                        <td>dewi@sekolah.sch.id</td>
                        <td><span class="abadge abadge-green">Active</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="abtn abtn-outline abtn-sm action-btn">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #4f46e5); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">E</div> Eko</div></td>
                        <td>12350</td>
                        <td>XI IPA 1</td>
                        <td>eko@sekolah.sch.id</td>
                        <td><span class="abadge abadge-gray">Inactive</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="abtn abtn-outline abtn-sm action-btn">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #d97706); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">F</div> Fani</div></td>
                        <td>12351</td>
                        <td>XII IPA 3</td>
                        <td>fani@sekolah.sch.id</td>
                        <td><span class="abadge abadge-green">Active</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="abtn abtn-outline abtn-sm action-btn">Detail</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><div style="display: flex; align-items: center; gap: 0.5rem;"><div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #8b5cf6, #7c3aed); display: flex; align-items: center; justify-content: center; color: white; font-size: 0.75rem; font-weight: 600;">G</div> Gita</div></td>
                        <td>12352</td>
                        <td>X IPS 2</td>
                        <td>gita@sekolah.sch.id</td>
                        <td><span class="abadge abadge-green">Active</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="abtn abtn-outline abtn-sm action-btn">Detail</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="admin-pagination">
            <div class="admin-pagination-btns">
                <button class="abtn abtn-secondary abtn-sm" disabled>Previous</button>
                <button class="abtn abtn-primary abtn-sm active">1</button>
                <button class="abtn abtn-secondary abtn-sm">2</button>
                <button class="abtn abtn-secondary abtn-sm">3</button>
                <button class="abtn abtn-secondary abtn-sm">Next</button>
            </div>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')

@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
@vite(['resources/js/admin/students.js'])
</body>
</html>
