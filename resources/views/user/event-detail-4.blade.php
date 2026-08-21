@extends('user.layout')

@section('title', 'Detail Event')

@push('css')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="section-header">
            <a href="{{ url('/user/events') }}" class="btn btn-outline btn-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: var(--spacing-xs);">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali
            </a>
        </div>

        <div class="event-card">
            <div class="event-banner" style="height: 250px;">
                <img src="{{ asset('images/events/seminar-placeholder.jpg') }}" alt="Seminar Kewirausahaan" onerror="this.style.display='none'" style="width: 100%; height: 100%; object-fit: cover;">
                <div class="event-category">Seminar</div>
                <div style="position: absolute; bottom: var(--spacing-md); left: var(--spacing-md); right: var(--spacing-md);">
                    <span class="badge badge-success">Pendaftaran Dibuka</span>
                </div>
            </div>
            <div class="event-content">
                <h1 class="event-title" style="font-size: 2rem; margin-bottom: var(--spacing-md);">Seminar Kewirausahaan</h1>
                
                <div class="event-details" style="margin-bottom: var(--spacing-lg);">
                    <div class="event-detail">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>3 September 2026</span>
                    </div>
                    <div class="event-detail">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>10:00 — 12:00 WIB</span>
                    </div>
                    <div class="event-detail">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Avis</span>
                    </div>
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: var(--spacing-sm); color: var(--text-primary);">Tentang Event</h3>
                    <p style="color: var(--text-muted); line-height: 1.8;">
                        Seminar Kewirausahaan adalah acara edukatif yang menghadirkan pengusaha sukses untuk berbagi pengalaman dan tips memulai bisnis. 
                        Siswa akan belajar tentang mindset entrepreneur, strategi bisnis, dan cara mengembangkan ide bisnis. Acara ini cocok untuk siswa yang tertarik menjadi wirausaha muda.
                    </p>
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: var(--spacing-sm); color: var(--text-primary);">Apa yang Akan Anda Pelajari</h3>
                    <ul style="color: var(--text-muted); line-height: 1.8; padding-left: var(--spacing-lg);">
                        <li>Mindset entrepreneur yang sukses</li>
                        <li>Strategi memulai bisnis dari nol</li>
                        <li>Tips mengelola keuangan bisnis</li>
                        <li>Cara mengembangkan networking bisnis</li>
                    </ul>
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: var(--spacing-sm); color: var(--text-primary);">Persyaratan Peserta</h3>
                    <ul style="color: var(--text-muted); line-height: 1.8; padding-left: var(--spacing-lg);">
                        <li>Siswa kelas X, XI, atau XII</li>
                        <li>Wajib mengenakan seragam sekolah</li>
                        <li>Membawa alat tulis</li>
                        <li>Tepat waktu (10:00 WIB)</li>
                    </ul>
                </div>

                <div style="margin-bottom: var(--spacing-lg);">
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: var(--spacing-sm); color: var(--text-primary);">Kuota Peserta</h3>
                    <div style="display: flex; align-items: center; gap: var(--spacing-md);">
                        <div style="flex: 1; height: 12px; background: var(--bg-secondary); border-radius: 6px; overflow: hidden;">
                            <div style="width: 80%; height: 100%; background: var(--primary-color); border-radius: 6px;"></div>
                        </div>
                        <span style="color: var(--text-primary); font-size: 0.875rem; font-weight: 600;">40/50 peserta</span>
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin-top: var(--spacing-xs);">Sisa 10 kuota tersedia</p>
                </div>

                <div style="margin-bottom: var(--spacing-lg); padding: var(--spacing-md); background: var(--bg-secondary); border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: var(--spacing-sm); color: var(--text-primary);">Informasi Pendaftaran</h3>
                    <ul style="color: var(--text-muted); line-height: 1.8; padding-left: var(--spacing-lg);">
                        <li>Pendaftaran gratis</li>
                        <li>Sertifikat kehadiran akan diberikan</li>
                        <li>Snack disediakan</li>
                        <li>Materi seminar akan dibagikan</li>
                    </ul>
                </div>

                <div class="event-footer">
                    <div class="event-status">
                        <span class="badge badge-success">Pendaftaran Dibuka</span>
                    </div>
                    <div class="event-actions">
                        <form action="{{ url('/user/events/register') }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="4">
                            <button type="submit" class="btn btn-primary" style="padding: var(--spacing-md) var(--spacing-xl);">Daftar Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
