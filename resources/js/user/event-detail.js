document.addEventListener('DOMContentLoaded', function() {
    // TODO: Replace mock data with backend data
    
    // Handle back button
    const backBtn = document.getElementById('backBtn');
    if (backBtn) {
        backBtn.addEventListener('click', function() {
            window.history.back();
        });
    }
    
    console.log('Event detail page loaded');
});
