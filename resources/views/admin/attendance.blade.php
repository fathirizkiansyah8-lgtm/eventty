<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran — Eventty Admin</title>
    @vite([
        'resources/css/components/design-system.css',
        'resources/css/components/sidebar.css',
        'resources/css/admin/admin-shared.css',
        'resources/css/admin/attendance.css'
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

@include('admin.partials.sidebar', ['activePage' => 'attendance'])

<div class="admin-main">
    @include('admin.partials.header')
    <div class="admin-content">

        <div class="admin-page-hd">
            <h1 class="admin-page-hd-title">Kehadiran</h1>
        </div>

        <!-- Search and Filter -->
        <div class="admin-table-hd">
            <div class="admin-search-wrap">
                <input type="text" class="admin-search-input" id="searchInput" placeholder="Cari peserta...">
            </div>
            <div class="admin-filter-row">
                <select class="admin-select" id="eventFilter">
                    <option value="">Semua Event</option>
                    <option value="career-day">Career Day</option>
                    <option value="workshop-programming">Workshop Programming</option>
                    <option value="lomba-design">Lomba Design</option>
                    <option value="seminar-pendidikan">Seminar Pendidikan</option>
                </select>
                <select class="admin-select" id="attendanceFilter">
                    <option value="">Semua Status</option>
                    <option value="present">Hadir</option>
                    <option value="absent">Tidak Hadir</option>
                    <option value="pending">Belum Dicek</option>
                </select>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="admin-table-wrap">
            <div class="admin-table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Event</th>
                        <th>Status Kehadiran</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Fathi</td>
                        <td>12345</td>
                        <td>XII IPA 1</td>
                        <td>Career Day</td>
                        <td><span class="abadge abadge-yellow">Belum Dicek</span></td>
                        <td>
                            <div class="attendance-actions">
                                <button class="abtn abtn-success abtn-sm attendance-btn" data-status="present">✓ Hadir</button>
                                <button class="abtn abtn-danger abtn-sm attendance-btn" data-status="absent">✗ Tidak</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Ahmad</td>
                        <td>12346</td>
                        <td>XII IPA 2</td>
                        <td>Workshop Programming</td>
                        <td><span class="abadge abadge-green">Hadir</span></td>
                        <td>
                            <div class="attendance-actions">
                                <button class="abtn abtn-secondary abtn-sm attendance-btn" disabled>Sudah Dicek</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Budi</td>
                        <td>12347</td>
                        <td>XI IPS 1</td>
                        <td>Lomba Design</td>
                        <td><span class="abadge abadge-red">Tidak Hadir</span></td>
                        <td>
                            <div class="attendance-actions">
                                <button class="abtn abtn-secondary abtn-sm attendance-btn" disabled>Sudah Dicek</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Citra</td>
                        <td>12348</td>
                        <td>X IPA 1</td>
                        <td>Seminar Pendidikan</td>
                        <td><span class="abadge abadge-green">Hadir</span></td>
                        <td>
                            <div class="attendance-actions">
                                <button class="abtn abtn-secondary abtn-sm attendance-btn" disabled>Sudah Dicek</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Dewi</td>
                        <td>12349</td>
                        <td>XII IPS 1</td>
                        <td>Workshop Leadership</td>
                        <td><span class="abadge abadge-yellow">Belum Dicek</span></td>
                        <td>
                            <div class="attendance-actions">
                                <button class="abtn abtn-success abtn-sm attendance-btn" data-status="present">✓ Hadir</button>
                                <button class="abtn abtn-danger abtn-sm attendance-btn" data-status="absent">✗ Tidak</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Eko</td>
                        <td>12350</td>
                        <td>XI IPA 1</td>
                        <td>Career Day</td>
                        <td><span class="abadge abadge-yellow">Belum Dicek</span></td>
                        <td>
                            <div class="attendance-actions">
                                <button class="abtn abtn-success abtn-sm attendance-btn" data-status="present">✓ Hadir</button>
                                <button class="abtn abtn-danger abtn-sm attendance-btn" data-status="absent">✗ Tidak</button>
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
                <button class="abtn abtn-secondary abtn-sm">Next</button>
            </div>
        </div>

    </div>
</div>

@include('admin.partials.logout-modal')

@vite(['resources/js/components/sidebar.js', 'resources/js/admin/admin-shared.js'])
@vite(['resources/js/admin/attendance.js'])
</body>
</html>
