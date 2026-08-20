@extends('user.layout')

@section('title', 'Event')

@push('css')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="section-header">
            <h1 class="section-title">Semua Event</h1>
        </div>

        <div class="events-grid">
            <div class="event-card">
                <div class="event-banner">
                    <img src="{{ asset('images/careerday.jpeg') }}" alt="Career Day" style="width:100%;height:100%;object-fit:cover;">
                    <div class="event-category">School Event</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Career Day</h3>
                    <div class="event-details">
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>20 August 2026</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>08:00 — 11:30</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Avis</span>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="event-status">
                            <span class="badge badge-success">Open</span>
                            <span class="event-participants">45/50 peserta</span>
                        </div>
                        <div class="event-actions">
                            <a href="{{ url('/user/events/1') }}" class="btn btn-outline btn-sm">Detail</a>
                            <button type="button" class="btn btn-primary btn-sm btn-trigger-register" data-event-title="Career Day" data-event-date="20 August 2026">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <div class="event-banner">
                    <img src="{{ asset('images/workshop.png') }}" alt="Workshop Programming" style="width:100%;height:100%;object-fit:cover;">
                    <div class="event-category">Workshop</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Workshop Programming</h3>
                    <div class="event-details">
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>25 August 2026</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>09:00 — 15:00</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Lab RPL</span>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="event-status">
                            <span class="badge badge-success">Open</span>
                            <span class="event-participants">20/30 peserta</span>
                        </div>
                        <div class="event-actions">
                            <a href="{{ url('/user/events/2') }}" class="btn btn-outline btn-sm">Detail</a>
                            <button type="button" class="btn btn-primary btn-sm btn-trigger-register" data-event-title="Workshop Programming" data-event-date="25 August 2026">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <div class="event-banner">
                    <img src="{{ asset('images/classmeeting.jpeg') }}" alt="Classmeeting" style="width:100%;height:100%;object-fit:cover;">
                    <div class="event-category">Competition</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Classmeeting</h3>
                    <div class="event-details">
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>1-5 September 2026</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>07.30 — 15:00</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Lapangan</span>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="event-status">
                            <span class="badge badge-warning">Almost Full</span>
                            <span class="event-participants">47/50 peserta</span>
                        </div>
                        <div class="event-actions">
                            <a href="{{ url('/user/events/3') }}" class="btn btn-outline btn-sm">Detail</a>
                            <button type="button" class="btn btn-primary btn-sm btn-trigger-register" data-event-title="Classmeeting" data-event-date="1-5 September 2026">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <div class="event-banner">
                    <img src="{{ asset('images/seminar.png') }}" alt="Seminar Kewirausahaan" style="width:100%;height:100%;object-fit:cover;">
                    <div class="event-category">Seminar</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Seminar Kewirausahaan</h3>
                    <div class="event-details">
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
                            <span>10:00 — 12:00</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Avis</span>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="event-status">
                            <span class="badge badge-success">Open</span>
                            <span class="event-participants">40/50 peserta</span>
                        </div>
                        <div class="event-actions">
                            <a href="{{ url('/user/events/4') }}" class="btn btn-outline btn-sm">Detail</a>
                            <button type="button" class="btn btn-primary btn-sm btn-trigger-register" data-event-title="Seminar Kewirausahaan" data-event-date="3 September 2026">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <div class="event-banner">
                    <img src="{{ asset('images/basket.jpeg') }}" alt="Turnamen Basket" style="width:100%;height:100%;object-fit:cover;">
                    <div class="event-category">Sports</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Turnamen Basket</h3>
                    <div class="event-details">
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>10 September 2026</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>08:00 — 16:00</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>Lapangan Basket</span>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="event-status">
                            <span class="badge badge-success">Open</span>
                            <span class="event-participants">10/24 peserta</span>
                        </div>
                        <div class="event-actions">
                            <a href="{{ url('/user/events/5') }}" class="btn btn-outline btn-sm">Detail</a>
                            <button type="button" class="btn btn-primary btn-sm btn-trigger-register" data-event-title="Turnamen Basket" data-event-date="10 September 2026">Daftar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection