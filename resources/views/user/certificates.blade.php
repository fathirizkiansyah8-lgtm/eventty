@extends('user.layout')

@section('title', 'Sertifikat')

@push('css')
    @vite('resources/css/user/dashboard.css')
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="section-header">
            <h1 class="section-title">Sertifikat Saya</h1>
        </div>

        <div class="events-grid">
            <div class="event-card">
                <div class="event-banner">
                    <img src="{{ asset('images/events/workshop-placeholder.jpg') }}" alt="Workshop Leadership" onerror="this.style.display='none'">
                    <div class="event-category">Workshop</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Workshop Leadership</h3>
                    <div class="event-details">
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>15 August 2026</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="7"></circle>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                            <span>Participation</span>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="event-status">
                            <span class="badge badge-success">Available</span>
                        </div>
                        <div class="event-actions">
                            <button class="btn btn-outline btn-sm">Lihat</button>
                            <button class="btn btn-primary btn-sm">Download</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <div class="event-banner">
                    <img src="{{ asset('images/events/workshop-placeholder.jpg') }}" alt="Workshop Design" onerror="this.style.display='none'">
                    <div class="event-category">Workshop</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Workshop Design</h3>
                    <div class="event-details">
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>5 August 2026</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="7"></circle>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                            <span>Completion</span>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="event-status">
                            <span class="badge badge-success">Available</span>
                        </div>
                        <div class="event-actions">
                            <button class="btn btn-outline btn-sm">Lihat</button>
                            <button class="btn btn-primary btn-sm">Download</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="event-card">
                <div class="event-banner">
                    <img src="{{ asset('images/events/seminar-placeholder.jpg') }}" alt="Seminar Teknologi" onerror="this.style.display='none'">
                    <div class="event-category">Seminar</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">Seminar Teknologi</h3>
                    <div class="event-details">
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>28 July 2026</span>
                        </div>
                        <div class="event-detail">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="7"></circle>
                                <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                            </svg>
                            <span>Attendance</span>
                        </div>
                    </div>
                    <div class="event-footer">
                        <div class="event-status">
                            <span class="badge badge-success">Available</span>
                        </div>
                        <div class="event-actions">
                            <button class="btn btn-outline btn-sm">Lihat</button>
                            <button class="btn btn-primary btn-sm">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection