/**
 * Example JavaScript code for using the MashouraX API
 * This file demonstrates how to interact with the backend API from the frontend
 */

// Base API URL
const API_BASE = '/backend/api/index.php';

/**
 * Helper function to make API requests
 */
async function apiRequest(endpoint, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        credentials: 'include' // Include cookies for session
    };
    
    if (data && (method === 'POST' || method === 'PUT')) {
        options.body = JSON.stringify(data);
    }
    
    try {
        const response = await fetch(API_BASE + endpoint, options);
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('API request failed:', error);
        return { success: false, message: 'Network error occurred' };
    }
}

// ==================== AUTHENTICATION ====================

/**
 * Login user
 */
async function login(email, password) {
    return await apiRequest('/auth/login', 'POST', { email, password });
}

/**
 * Signup new user
 */
async function signup(userData) {
    return await apiRequest('/auth/signup', 'POST', userData);
}

/**
 * Logout user
 */
async function logout() {
    return await apiRequest('/auth/logout', 'POST');
}

/**
 * Get current user
 */
async function getCurrentUser() {
    return await apiRequest('/auth/me');
}

/**
 * Verify session
 */
async function verifySession() {
    return await apiRequest('/auth/verify');
}

// ==================== USER PROFILE ====================

/**
 * Get user profile
 */
async function getUserProfile(userId = null) {
    const endpoint = userId ? `/user/profile/${userId}` : '/user/profile';
    return await apiRequest(endpoint);
}

/**
 * Update user profile
 */
async function updateProfile(data) {
    return await apiRequest('/user/profile/update', 'POST', data);
}

/**
 * Change password
 */
async function changePassword(oldPassword, newPassword) {
    return await apiRequest('/user/password/change', 'POST', {
        old_password: oldPassword,
        new_password: newPassword
    });
}

// ==================== STUDENT ====================

/**
 * Get student dashboard data
 */
async function getStudentDashboard() {
    return await apiRequest('/student/dashboard');
}

/**
 * Get academic progress
 */
async function getAcademicProgress() {
    return await apiRequest('/student/progress');
}

/**
 * Get student courses
 */
async function getStudentCourses() {
    return await apiRequest('/student/courses');
}

/**
 * Get student grades
 */
async function getStudentGrades(courseId = null) {
    const endpoint = courseId ? `/student/grades/${courseId}` : '/student/grades';
    return await apiRequest(endpoint);
}

/**
 * Get student assignments
 */
async function getStudentAssignments(status = null) {
    const endpoint = status ? `/student/assignments?status=${status}` : '/student/assignments';
    return await apiRequest(endpoint);
}

// ==================== ADVISOR ====================

/**
 * Get advisor dashboard data
 */
async function getAdvisorDashboard() {
    return await apiRequest('/advisor/dashboard');
}

/**
 * Get advisor statistics
 */
async function getAdvisorStats() {
    return await apiRequest('/advisor/stats');
}

/**
 * Get assigned students
 */
async function getAssignedStudents(limit = null) {
    const endpoint = limit ? `/advisor/students?limit=${limit}` : '/advisor/students';
    return await apiRequest(endpoint);
}

/**
 * Assign student to advisor
 */
async function assignStudent(studentId) {
    return await apiRequest('/advisor/assign', 'POST', { student_id: studentId });
}

/**
 * Get upcoming meetings (advisor)
 */
async function getAdvisorMeetings(limit = 10) {
    return await apiRequest(`/advisor/meetings?limit=${limit}`);
}

// ==================== ADMIN ====================

/**
 * Get admin dashboard data
 */
async function getAdminDashboard() {
    return await apiRequest('/admin/dashboard');
}

/**
 * Get system statistics
 */
async function getSystemStats() {
    return await apiRequest('/admin/stats');
}

/**
 * Get all users
 */
async function getAllUsers(role = null, limit = 50, offset = 0) {
    let endpoint = `/admin/users?limit=${limit}&offset=${offset}`;
    if (role) endpoint += `&role=${role}`;
    return await apiRequest(endpoint);
}

/**
 * Update user status
 */
async function updateUserStatus(userId, isActive) {
    return await apiRequest('/admin/user/status', 'POST', {
        user_id: userId,
        is_active: isActive
    });
}

/**
 * Update user role
 */
async function updateUserRole(userId, newRole) {
    return await apiRequest('/admin/user/role', 'POST', {
        user_id: userId,
        role: newRole
    });
}

/**
 * Delete user
 */
async function deleteUser(userId) {
    return await apiRequest(`/admin/user/delete/${userId}`, 'POST');
}

// ==================== CHAT ====================

/**
 * Send chat message
 */
async function sendChatMessage(message) {
    return await apiRequest('/chat/send', 'POST', { message });
}

/**
 * Get chat history
 */
async function getChatHistory(limit = 50) {
    return await apiRequest(`/chat/history?limit=${limit}`);
}

/**
 * Clear chat history
 */
async function clearChatHistory() {
    return await apiRequest('/chat/clear', 'POST');
}

// ==================== MEETINGS ====================

/**
 * Create meeting
 */
async function createMeeting(meetingData) {
    return await apiRequest('/meeting/create', 'POST', meetingData);
}

/**
 * Get meetings
 */
async function getMeetings(status = null, limit = null) {
    let endpoint = '/meeting/list';
    const params = [];
    if (status) params.push(`status=${status}`);
    if (limit) params.push(`limit=${limit}`);
    if (params.length > 0) endpoint += '?' + params.join('&');
    return await apiRequest(endpoint);
}

/**
 * Get upcoming meetings
 */
async function getUpcomingMeetings(limit = 10) {
    return await apiRequest(`/meeting/upcoming?limit=${limit}`);
}

/**
 * Update meeting status
 */
async function updateMeetingStatus(meetingId, status) {
    return await apiRequest('/meeting/status', 'POST', {
        meeting_id: meetingId,
        status: status
    });
}

/**
 * Cancel meeting
 */
async function cancelMeeting(meetingId, reason = null) {
    return await apiRequest('/meeting/cancel', 'POST', {
        meeting_id: meetingId,
        reason: reason
    });
}

/**
 * Reschedule meeting
 */
async function rescheduleMeeting(meetingId, newDateTime) {
    return await apiRequest('/meeting/reschedule', 'POST', {
        meeting_id: meetingId,
        new_datetime: newDateTime
    });
}

// ==================== USAGE EXAMPLES ====================

// Example: Login and get dashboard
async function exampleLoginAndDashboard() {
    // Login
    const loginResult = await login('student@example.com', 'password123');
    if (loginResult.success) {
        console.log('Logged in as:', loginResult.data.user);
        
        // Get dashboard based on role
        if (loginResult.data.user.role === 'student') {
            const dashboard = await getStudentDashboard();
            console.log('Student dashboard:', dashboard.data);
        } else if (loginResult.data.user.role === 'advisor') {
            const dashboard = await getAdvisorDashboard();
            console.log('Advisor dashboard:', dashboard.data);
        } else if (loginResult.data.user.role === 'admin') {
            const dashboard = await getAdminDashboard();
            console.log('Admin dashboard:', dashboard.data);
        }
    } else {
        console.error('Login failed:', loginResult.message);
    }
}

// Example: Chat support
async function exampleChat() {
    // Send a message
    const result = await sendChatMessage('What are your pricing plans?');
    if (result.success) {
        console.log('Bot response:', result.data.response);
    }
    
    // Get chat history
    const history = await getChatHistory(20);
    if (history.success) {
        console.log('Chat history:', history.data.history);
    }
}

// Example: Create meeting
async function exampleCreateMeeting() {
    const result = await createMeeting({
        advisor_id: 2,
        student_id: 1,
        scheduled_at: '2024-12-20 14:00:00',
        duration: 30,
        type: 'Academic Planning',
        notes: 'Discuss course selection for next semester'
    });
    
    if (result.success) {
        console.log('Meeting created:', result.data.meeting_id);
    }
}

// Export functions for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        login,
        signup,
        logout,
        getCurrentUser,
        getStudentDashboard,
        getAdvisorDashboard,
        getAdminDashboard,
        sendChatMessage,
        createMeeting,
        // ... export other functions as needed
    };
}

