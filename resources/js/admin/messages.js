/**
 * Admin Messages JS
 *
 * CATATAN: Logic utama (sendAdm, event listeners untuk sendBtn dan keydown)
 * sudah ada sebagai inline script di messages.blade.php.
 *
 * File ini HANYA bertugas menangani hal-hal yang belum ada di blade:
 * - Auto-resize textarea saat mengetik
 * - Expose helper ke window agar bisa dipanggil dari luar jika diperlukan
 *
 * Jangan duplikasi event listener sendBtn / keydown di sini karena
 * blade sudah mendefinisikannya — duplikasi menyebabkan kirim 2x.
 */

document.addEventListener('DOMContentLoaded', function () {
    var chatInput = document.getElementById('admInput');

    // Auto-resize textarea — blade belum menangani ini via external JS
    // (blade punya versi inline tapi hanya saat 'input', kita pastikan
    //  juga berjalan saat halaman pertama load)
    if (chatInput) {
        // Reset ke ukuran konten saat ini saat mount
        chatInput.style.height = 'auto';
        chatInput.style.height = Math.min(chatInput.scrollHeight, 132) + 'px';
    }
});
