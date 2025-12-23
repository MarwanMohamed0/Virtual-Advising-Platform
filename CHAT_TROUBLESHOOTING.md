# Chat Troubleshooting Guide

## Issue: "Sorry, I encountered an error. Please try again."

If you're seeing this error message, here are the steps to fix it:

### Step 1: Check if Gemini API Key is Configured

1. Open `config/api.php`
2. Check if `GEMINI_API_KEY` has a value:
   ```php
   define('GEMINI_API_KEY', 'YOUR_API_KEY_HERE');
   ```

**If the API key is empty:**
- The system will automatically use keyword-based fallback responses
- This should still work, but responses will be simpler
- To enable full AI functionality, add your Gemini API key (see `GEMINI_SETUP.md`)

### Step 2: Check Browser Console

1. Open your browser's Developer Tools (F12)
2. Go to the Console tab
3. Try sending a message in the chat
4. Look for any error messages

Common errors you might see:
- `401 Unauthorized` - Session expired, try logging in again
- `500 Internal Server Error` - Check PHP error logs
- `Network Error` - Check your internet connection

### Step 3: Check PHP Error Logs

Check your PHP error log (usually in XAMPP: `xampp/php/logs/php_error_log` or `xampp/apache/logs/error.log`)

Look for errors related to:
- `Gemini API Error`
- `Chat error`
- `cURL error`

### Step 4: Verify API Endpoint

Test the API endpoint directly:

1. Open browser console
2. Run this command:
   ```javascript
   fetch('backend/api/index.php/chat/send', {
       method: 'POST',
       headers: {'Content-Type': 'application/json'},
       credentials: 'include',
       body: JSON.stringify({message: 'test'})
   }).then(r => r.json()).then(console.log)
   ```

### Step 5: Common Fixes

#### Fix 1: API Key Not Set
- **Solution**: Add your Gemini API key to `config/api.php`
- **Alternative**: The system will use keyword matching (simpler responses)

#### Fix 2: Session Expired
- **Solution**: Log out and log back in
- **Check**: Make sure cookies are enabled

#### Fix 3: cURL Not Enabled
- **Solution**: Enable cURL extension in PHP
- **Check**: In `php.ini`, uncomment `extension=curl`
- **Restart**: Restart Apache in XAMPP

#### Fix 4: Database Connection Issue
- **Solution**: Check `config/database.php` settings
- **Verify**: Database exists and credentials are correct

#### Fix 5: File Permissions
- **Solution**: Make sure PHP can read/write to the database
- **Check**: File permissions on `config/` directory

### Step 6: Test Without Gemini API

The chat should work even without Gemini API configured. It will use keyword-based responses.

Try asking:
- "What courses should I take?"
- "Help with account"
- "Pricing information"

These should trigger keyword-based responses.

### Step 7: Enable Debug Mode (Temporary)

To see more detailed errors, temporarily add this to `chat.php`:

```javascript
// In the sendMessage function, before the try block:
console.log('Sending message:', message);
console.log('API Base:', API_BASE);
```

### Still Having Issues?

1. **Check PHP version**: Should be PHP 7.4 or higher
2. **Check cURL**: Run `php -m | grep curl` (if PHP CLI is available)
3. **Check database**: Verify `chat_messages` table exists
4. **Check session**: Make sure you're logged in

### Getting Help

If none of these solutions work:
1. Check the browser console for specific error messages
2. Check PHP error logs
3. Verify all files are in place:
   - `backend/api/index.php`
   - `backend/controller/ChatController.php`
   - `backend/model/ChatModel.php`
   - `backend/services/GeminiService.php`
   - `config/api.php`

### Expected Behavior

**Without Gemini API Key:**
- Chat should still work
- Responses will be keyword-based
- Simpler, predefined responses

**With Gemini API Key:**
- Full AI-powered responses
- Context-aware conversations
- More natural language understanding

