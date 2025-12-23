# Gemini API Setup Guide

This guide will help you set up Google Gemini API for the AI chat agent in MashouraX Virtual Advising Platform.

## Step 1: Get Your Gemini API Key

1. **Go to Google AI Studio**
   - Visit: https://makersuite.google.com/app/apikey
   - Or visit: https://aistudio.google.com/app/apikey

2. **Sign in with your Google Account**
   - Use your Google account to sign in
   - If you don't have one, create a free Google account

3. **Create an API Key**
   - Click "Create API Key" button
   - Select "Create API key in new project" (or choose an existing project)
   - Your API key will be generated and displayed

4. **Copy Your API Key**
   - Copy the API key immediately (you won't be able to see it again)
   - It will look something like: `AIzaSyAbCdEfGhIjKlMnOpQrStUvWxYz1234567`

## Step 2: Configure the API Key

1. **Open the configuration file**
   - Navigate to: `config/api.php`

2. **Add your API key**
   - Find the line: `define('GEMINI_API_KEY', '');`
   - Paste your API key between the quotes:
   ```php
   define('GEMINI_API_KEY', 'YOUR_API_KEY_HERE');
   ```

3. **Save the file**

## Step 3: Test the Integration

1. **Test via API endpoint** (if you have API testing tools):
   ```
   POST /backend/api/index.php/chat/send
   Headers: Content-Type: application/json
   Body: {
     "message": "Hello, can you help me?"
   }
   ```

2. **Or test via the chat interface**:
   - Log in to your platform
   - Navigate to the chat support page
   - Send a test message
   - You should receive an AI-generated response

## Step 4: Security Best Practices

⚠️ **IMPORTANT**: Keep your API key secure!

1. **Add to .gitignore**
   - Make sure `config/api.php` is in your `.gitignore` file
   - This prevents accidentally committing your API key to version control

2. **Environment Variables (Recommended for Production)**
   - For production, consider using environment variables instead of hardcoding
   - Update `config/api.php` to read from environment:
   ```php
   define('GEMINI_API_KEY', getenv('GEMINI_API_KEY') ?: '');
   ```

3. **API Key Restrictions**
   - In Google Cloud Console, you can restrict your API key:
     - Go to: https://console.cloud.google.com/apis/credentials
     - Click on your API key
     - Set "API restrictions" to only allow "Generative Language API"
     - Set "Application restrictions" to limit usage

## API Usage and Limits

### Free Tier Limits
- **60 requests per minute** (RPM)
- **1,500 requests per day** (RPD)
- Free tier is generous for testing and small applications

### Paid Tier
- Higher rate limits available
- Pay-as-you-go pricing
- Check current pricing at: https://ai.google.dev/pricing

## Troubleshooting

### Error: "Gemini API key is not configured"
- **Solution**: Make sure you've added your API key to `config/api.php`

### Error: "Failed to connect to Gemini API"
- **Solution**: 
  - Check your internet connection
  - Verify the API key is correct
  - Check if cURL is enabled in PHP: `php -m | grep curl`

### Error: "Gemini API returned error code: 400"
- **Solution**: 
  - Check your API key is valid
  - Verify you have access to the Generative Language API
  - Check API quotas in Google Cloud Console

### Error: "Gemini API returned error code: 429"
- **Solution**: 
  - You've exceeded rate limits
  - Wait a few minutes and try again
  - Consider upgrading to paid tier for higher limits

### Responses are not working
- **Solution**: 
  - Check PHP error logs for detailed error messages
  - Verify cURL extension is installed: `php -m | grep curl`
  - Test API key directly using curl:
    ```bash
    curl -X POST "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=YOUR_API_KEY" \
      -H 'Content-Type: application/json' \
      -d '{"contents":[{"parts":[{"text":"Hello"}]}]}'
    ```

## Customizing the AI Behavior

You can customize the AI's behavior by editing the system prompt in `backend/services/GeminiService.php`:

```php
private function getDefaultSystemPrompt() {
    return "Your custom instructions here...";
}
```

### Example Customizations:

**More Academic-Focused:**
```php
"You are an expert academic advisor AI assistant. Focus on helping students with course selection, degree planning, academic policies, and graduation requirements."
```

**More Friendly and Casual:**
```php
"You are a friendly and approachable AI assistant. Use a warm, conversational tone while maintaining professionalism."
```

**Institution-Specific:**
```php
"You are an AI advisor for [Your Institution Name]. Help students navigate [specific programs/requirements]. Always refer complex issues to human advisors."
```

## Advanced Configuration

### Adjusting Response Parameters

Edit `config/api.php` to customize:

- **Temperature** (0.0 - 1.0): Controls randomness
  - Lower (0.0-0.3): More focused, deterministic
  - Higher (0.7-1.0): More creative, varied responses
  - Default: 0.7 (balanced)

- **Max Tokens**: Maximum response length
  - Default: 1000 tokens (~750 words)
  - Increase for longer responses

- **Model**: Choose different Gemini models
  - `gemini-pro`: Text generation (default)
  - `gemini-pro-vision`: Text + image understanding

## Support

For issues with:
- **Gemini API**: Check Google AI documentation: https://ai.google.dev/docs
- **Platform Integration**: Check `backend/README.md` and `backend/INTEGRATION.md`

## Next Steps

1. ✅ Get your API key
2. ✅ Configure it in `config/api.php`
3. ✅ Test the integration
4. ✅ Customize the system prompt (optional)
5. ✅ Set up API key restrictions (recommended for production)
6. ✅ Monitor usage in Google Cloud Console

Enjoy your AI-powered chat agent! 🚀

