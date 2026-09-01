/**
 * API Utility Functions
 * Centralizes all API calls with proper error handling and CSRF protection
 */

class ApiClient {
    constructor() {
        this.baseURL = '';
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Set default headers
        this.defaultHeaders = {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        };

        if (this.csrfToken) {
            this.defaultHeaders['X-CSRF-TOKEN'] = this.csrfToken;
        }
    }

    /**
     * Generic request method
     */
    async request(url, options = {}) {
        const config = {
            headers: { ...this.defaultHeaders, ...options.headers },
            ...options
        };

        try {
            const response = await fetch(this.baseURL + url, config);
            
            // Check if response is JSON
            const contentType = response.headers.get('content-type');
            const isJson = contentType && contentType.includes('application/json');
            
            let data;
            if (isJson) {
                data = await response.json();
            } else {
                data = await response.text();
            }

            if (!response.ok) {
                throw new ApiError(data.message || 'Request failed', response.status, data);
            }

            return data;
        } catch (error) {
            if (error instanceof ApiError) {
                throw error;
            }
            
            // Network or other errors
            console.error('API Request Error:', error);
            throw new ApiError('Network error occurred', 0, error);
        }
    }

    /**
     * GET request
     */
    async get(url, params = {}) {
        const searchParams = new URLSearchParams(params);
        const queryString = searchParams.toString();
        const fullUrl = queryString ? `${url}?${queryString}` : url;
        
        return this.request(fullUrl, {
            method: 'GET'
        });
    }

    /**
     * POST request
     */
    async post(url, data = {}, options = {}) {
        const config = {
            method: 'POST',
            ...options
        };

        if (data instanceof FormData) {
            // For file uploads, don't set Content-Type (browser sets it automatically with boundary)
            delete config.headers;
            config.headers = { 
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': this.csrfToken 
            };
            config.body = data;
        } else {
            config.body = JSON.stringify(data);
        }

        return this.request(url, config);
    }

    /**
     * PUT request
     */
    async put(url, data = {}) {
        return this.request(url, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    /**
     * DELETE request
     */
    async delete(url) {
        return this.request(url, {
            method: 'DELETE'
        });
    }

    /**
     * Upload file
     */
    async upload(url, file, additionalData = {}) {
        const formData = new FormData();
        formData.append('file', file);
        
        // Add additional data to form
        Object.keys(additionalData).forEach(key => {
            formData.append(key, additionalData[key]);
        });

        return this.post(url, formData);
    }
}

/**
 * Custom API Error class
 */
class ApiError extends Error {
    constructor(message, status = 0, data = null) {
        super(message);
        this.name = 'ApiError';
        this.status = status;
        this.data = data;
    }

    isValidationError() {
        return this.status === 422;
    }

    isAuthError() {
        return this.status === 401 || this.status === 403;
    }

    getValidationErrors() {
        if (this.isValidationError() && this.data?.errors) {
            return this.data.errors;
        }
        return {};
    }
}

/**
 * Global API client instance
 */
const api = new ApiClient();

/**
 * Show notification helper
 */
function showNotification(message, type = 'info', duration = 5000) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span class="notification-message">${message}</span>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;

    // Add to page
    let container = document.querySelector('.notification-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'notification-container';
        document.body.appendChild(container);
    }
    container.appendChild(notification);

    // Auto remove
    if (duration > 0) {
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, duration);
    }
}

/**
 * Handle API errors globally
 */
function handleApiError(error, showToUser = true) {
    console.error('API Error:', error);

    if (error.isAuthError()) {
        // Redirect to login on auth errors
        showNotification('Session expired. Please login again.', 'error');
        setTimeout(() => {
            window.location.href = '/login';
        }, 2000);
        return;
    }

    if (showToUser) {
        const message = error.message || 'An error occurred. Please try again.';
        showNotification(message, 'error');
    }

    // If validation error, return errors for form handling
    if (error.isValidationError()) {
        return error.getValidationErrors();
    }

    return null;
}

/**
 * Loading state helper
 */
function setLoadingState(element, isLoading, loadingText = 'Loading...') {
    if (!element) return;

    if (isLoading) {
        element.disabled = true;
        element.setAttribute('data-original-text', element.textContent);
        element.textContent = loadingText;
        element.classList.add('loading');
    } else {
        element.disabled = false;
        const originalText = element.getAttribute('data-original-text');
        if (originalText) {
            element.textContent = originalText;
            element.removeAttribute('data-original-text');
        }
        element.classList.remove('loading');
    }
}

/**
 * Export for use in modules
 */
export { api, ApiError, showNotification, handleApiError, setLoadingState };

/**
 * Global exports for non-module usage
 */
if (typeof window !== 'undefined') {
    window.api = api;
    window.ApiError = ApiError;
    window.showNotification = showNotification;
    window.handleApiError = handleApiError;
    window.setLoadingState = setLoadingState;
}