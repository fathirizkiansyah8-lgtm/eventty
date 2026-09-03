@extends('user.layout')

@section('title', 'Messages')

@section('body-class', 'messages-page')

@push('css')
<style>
    .messages-page .sidebar,
    .messages-page .sidebar-toggle {
        display: none !important;
    }

    .messages-page .main-content {
        margin-left: 0 !important;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .msg-page {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 73px);
        overflow: hidden;
        position: relative;
        z-index: 1;
        font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
    }

    .msg-layout {
        display: grid;
        grid-template-columns: 320px minmax(0, 1fr);
        height: 100%;
        overflow: hidden;
        background: var(--bg-primary);
    }

    .msg-conv-panel {
        display: flex;
        flex-direction: column;
        border-right: 1.5px solid var(--border-color);
        background: var(--bg-secondary);
        overflow: hidden;
    }

    .msg-conv-hd {
        padding: 1.1rem 1.1rem 0.875rem;
        border-bottom: 1px solid var(--border-color);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .msg-conv-hd h2 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text-primary);
    }

    .msg-online-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.3rem 0.65rem;
        border-radius: 999px;
        background: #dcfce7;
        color: #15803d;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    .msg-online-badge::before {
        content: "";
        width: 7px;
        height: 7px;
        background: #22c55e;
        border-radius: 50%;
    }

    .msg-conv-list {
        flex: 1;
        overflow-y: auto;
        padding: 0.5rem;
    }

    .msg-conv-item {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding: 0.8rem 0.8rem;
        border-radius: 0.95rem;
        cursor: pointer;
        transition: all 0.18s ease;
        margin-bottom: 0.2rem;
    }

    .msg-conv-item:hover {
        background: var(--bg-tertiary);
    }

    .msg-conv-item.active {
        background: var(--primary-light);
        border: 1px solid rgba(59, 130, 246, 0.13);
    }

    .msg-av {
        position: relative;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 0.8rem;
        font-weight: 800;
        flex-shrink: 0;
        background: linear-gradient(135deg, #0f172a, #1d4ed8);
    }

    .msg-av-dot {
        position: absolute;
        right: 1px;
        bottom: 1px;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #22c55e;
        border: 2px solid var(--bg-secondary);
    }

    .msg-conv-info {
        flex: 1;
        min-width: 0;
    }

    .msg-conv-row1,
    .msg-conv-row2 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }

    .msg-conv-row1 {
        margin-bottom: 0.2rem;
    }

    .msg-conv-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .msg-conv-time {
        font-size: 0.66rem;
        color: var(--text-muted);
        white-space: nowrap;
    }

    .msg-conv-preview {
        font-size: 0.75rem;
        color: var(--text-secondary);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        flex: 1;
        min-width: 0;
    }

    .msg-unread-pill {
        min-width: 1.2rem;
        height: 1.2rem;
        padding: 0 0.4rem;
        border-radius: 999px;
        background: var(--primary);
        color: #fff;
        font-size: 0.62rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .msg-exit-link {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: var(--text-secondary);
        font-size: 0.7rem;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.18s ease, background 0.18s ease;
        padding: 0.4rem 0.55rem;
        border-radius: 0.55rem;
    }

    .msg-exit-link:hover {
        color: var(--primary-hover);
        background: var(--primary-light);
    }

    .msg-conv-ft {
        padding: 0.75rem 1rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.68rem;
        color: var(--text-muted);
        background: rgba(148, 163, 184, 0.04);
    }

    .msg-chat {
        display: flex;
        flex-direction: column;
        height: 100%;
        background: var(--bg-primary);
        overflow: hidden;
    }

    .msg-chat-hd {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.9rem 1.25rem;
        background: var(--bg-secondary);
        border-bottom: 1.5px solid var(--border-color);
        flex-shrink: 0;
    }

    .msg-back-btn {
        display: none;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid var(--border-color);
        background: transparent;
        color: var(--text-secondary);
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .msg-chat-av {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.84rem;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, #0f172a, #1d4ed8);
        flex-shrink: 0;
    }

    .msg-chat-hd-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .msg-chat-hd-name {
        font-size: 0.92rem;
        font-weight: 800;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .msg-chat-hd-status {
        font-size: 0.68rem;
        color: var(--text-muted);
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .msg-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #22c55e;
    }

    .msg-feed {
        flex: 1;
        overflow-y: auto;
        padding: 1.25rem 1.5rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        scroll-behavior: smooth;
        background:
            linear-gradient(
                180deg,
                rgba(59, 130, 246, 0.025),
                rgba(59, 130, 246, 0.005)
            );
    }

    .msg-date-div {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        margin: 0.3rem 0 0.65rem;
        font-size: 0.68rem;
        font-weight: 700;
        color: var(--text-muted);
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .msg-date-div::before,
    .msg-date-div::after {
        content: "";
        flex: 1;
        height: 1px;
        background: var(--border-color);
    }

    .msg-date-div span {
        white-space: nowrap;
        padding: 0.2rem 0.7rem;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 999px;
    }

    .msg-row {
        display: flex;
        align-items: flex-end;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .msg-row.out {
        justify-content: flex-end;
    }

    .msg-row.in {
        justify-content: flex-start;
    }

    .msg-row-av {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, #0f172a, #1d4ed8);
        flex-shrink: 0;
    }

    .msg-col {
        display: flex;
        flex-direction: column;
        gap: 0.28rem;
        max-width: 68%;
    }

    .msg-row.out .msg-col {
        align-items: flex-end;
    }

    .msg-bubble {
        padding: 0.8rem 0.95rem;
        border-radius: 1.1rem;
        line-height: 1.55;
        font-size: 0.88rem;
        word-break: break-word;
        white-space: pre-wrap;
    }

    .msg-bubble.in {
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
        color: var(--text-primary);
        border-bottom-left-radius: 0.25rem;
    }

    .msg-bubble.out {
        background: linear-gradient(135deg, #0f172a, #1d4ed8);
        color: #fff;
        border-bottom-right-radius: 0.25rem;
    }

    .msg-bubble.failed {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .msg-bbl-time {
        font-size: 0.62rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .msg-bbl-meta {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        justify-content: flex-end;
    }

    .msg-tick {
        display: inline-flex;
        color: var(--text-muted);
    }

    .msg-tick.read {
        color: #22c55e;
    }

    .msg-status-line {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.62rem;
        color: var(--text-muted);
        margin-top: 0.08rem;
    }

    .msg-status-line.error {
        color: #dc2626;
    }

    .msg-typing {
        display: none;
        align-items: flex-end;
        gap: 0.5rem;
        margin-top: 0.3rem;
    }

    .msg-typing-bbl {
        display: flex;
        align-items: center;
        gap: 0.28rem;
        padding: 0.7rem 0.85rem;
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        border-bottom-left-radius: 0.25rem;
    }

    .msg-typing-bbl span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--text-muted);
        animation: msgDot 1.1s ease-in-out infinite;
    }

    .msg-typing-bbl span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .msg-typing-bbl span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes msgDot {
        0%, 80%, 100% {
            transform: translateY(0);
            opacity: 0.4;
        }
        40% {
            transform: translateY(-4px);
            opacity: 1;
        }
    }

    .msg-input-area {
        background: var(--bg-secondary);
        border-top: 1.5px solid var(--border-color);
        padding: 0.9rem 1.25rem calc(0.9rem + env(safe-area-inset-bottom));
        flex-shrink: 0;
    }

    .msg-quick-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.7rem;
    }

    .msg-quick-btn {
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        color: var(--text-secondary);
        border-radius: 999px;
        padding: 0.45rem 0.7rem;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .msg-quick-btn:hover {
        border-color: rgba(59, 130, 246, 0.35);
        background: var(--primary-light);
        color: var(--primary-hover);
    }

    .msg-send-status {
        display: none;
        margin-bottom: 0.45rem;
        font-size: 0.72rem;
        font-weight: 600;
        border-radius: 0.7rem;
        padding: 0.45rem 0.7rem;
    }

    .msg-send-status.loading {
        display: block;
        background: rgba(59, 130, 246, 0.08);
        color: var(--primary-hover);
        border: 1px solid rgba(59, 130, 246, 0.12);
    }

    .msg-send-status.error {
        display: block;
        background: rgba(239, 68, 68, 0.08);
        color: #b91c1c;
        border: 1px solid rgba(239, 68, 68, 0.15);
    }

    .msg-input-wrap {
        display: flex;
        align-items: flex-end;
        gap: 0.7rem;
        background: var(--bg-primary);
        border: 1.5px solid var(--border-color);
        border-radius: 1rem;
        padding: 0.5rem 0.5rem 0.5rem 0.9rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .msg-input-wrap:focus-within {
        border-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.08);
    }

    .msg-input {
        flex: 1;
        border: none;
        background: transparent;
        resize: none;
        font-size: 0.88rem;
        color: var(--text-primary);
        line-height: 1.5;
        outline: none;
        max-height: 120px;
        min-height: 24px;
        font-family: inherit;
    }

    .msg-input::placeholder {
        color: var(--text-muted);
    }

    .msg-send-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: linear-gradient(135deg, #0f172a, #1d4ed8);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform 0.15s ease, opacity 0.2s ease;
        flex-shrink: 0;
    }

    .msg-send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .msg-send-btn:not(:disabled):hover {
        transform: translateY(-1px) scale(1.02);
    }

    .msg-input-hint {
        margin: 0.45rem 0 0;
        text-align: center;
        color: var(--text-muted);
        font-size: 0.64rem;
    }

    .msg-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 0.65rem;
        height: 100%;
        min-height: 230px;
        color: var(--text-muted);
        padding: 2rem 1.5rem;
    }

    .msg-empty-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }

    .msg-empty-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--text-primary);
    }

    .msg-empty-description {
        max-width: 260px;
        font-size: 0.8rem;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .msg-layout {
            grid-template-columns: 1fr;
            position: relative;
        }

        .msg-conv-panel {
            width: 100%;
            height: 100%;
        }

        .msg-chat {
            position: absolute;
            inset: 0;
            transform: translateX(100%);
            transition: transform 0.28s ease;
            z-index: 10;
            background: var(--bg-primary);
        }

        .msg-layout.chat-open .msg-chat {
            transform: translateX(0);
        }

        .msg-back-btn {
            display: inline-flex;
        }

        .msg-col {
            max-width: 80%;
        }

        .msg-feed {
            padding: 1rem 0.9rem 0.8rem;
        }

        .msg-input-area {
            padding-left: 0.9rem;
            padding-right: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<div class="msg-page">
    <div class="msg-layout" id="msgLayout">
        <aside class="msg-conv-panel">
            <div class="msg-conv-hd">
                <h2>Messages</h2>
                <a href="{{ url('/user/dashboard') }}" class="msg-exit-link" aria-label="Kembali ke Dashboard">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    Keluar
                </a>
            </div>
            <div class="msg-conv-list" id="conversationList"></div>
            <div class="msg-conv-ft">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                Chat langsung dengan Admin EVENTTY
            </div>
        </aside>

        <section class="msg-chat">
            <div class="msg-chat-hd">
                <button class="msg-back-btn" type="button" onclick="window.closeChat && closeChat()" aria-label="Kembali">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <div class="msg-chat-av" id="chatAvatar">E</div>
                <div class="msg-chat-hd-info">
                    <span class="msg-chat-hd-name" id="chatName">EVENTTY Bot</span>
                    <span class="msg-chat-hd-status"><span class="msg-status-dot"></span><span id="chatStatus">Online</span></span>
                </div>
            </div>

            <div class="msg-feed" id="msgFeed"></div>

            <div class="msg-input-area">
                <div class="msg-quick-actions" id="quickActions"></div>
                <div class="msg-send-status" id="sendStatus"></div>
                <div class="msg-input-wrap">
                    <textarea class="msg-input" id="msgInput" placeholder="Tulis pesan..." rows="1" aria-label="Tulis pesan"></textarea>
                    <button class="msg-send-btn" id="msgSendBtn" type="button" aria-label="Kirim" disabled>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                </div>
                <p class="msg-input-hint">Enter kirim · Shift + Enter baris baru</p>
            </div>
        </section>
    </div>
</div>
@endsection

@vite(['resources/js/user/messages.js'])
