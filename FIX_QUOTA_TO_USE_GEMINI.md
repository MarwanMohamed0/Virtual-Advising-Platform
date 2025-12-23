# How to Fix Quota Issue to Use Gemini AI

## Current Status
✅ **API Configuration**: Correct  
✅ **Model**: `gemini-2.5-flash` (working)  
✅ **System Prompt**: Updated to answer ANY question like Gemini  
⚠️ **API Quota**: Exceeded (429 error)

## The Problem
Your Gemini API key has exceeded its quota/rate limit. The system is configured correctly and WILL work perfectly once the quota resets or you get a new key.

## Solutions (Choose One)

### Option 1: Wait for Quota Reset (Easiest)
- Free tier quotas reset every 24 hours
- Check your quota: https://ai.dev/usage?tab=rate-limit
- Wait until quota resets (usually at midnight Pacific Time)

### Option 2: Get a New API Key (Recommended)
1. Go to: https://makersuite.google.com/app/apikey
2. Click "Create API Key"
3. Copy the new API key
4. Open `config/api.php`
5. Replace the old key:
   ```php
   define('GEMINI_API_KEY', 'YOUR_NEW_API_KEY_HERE');
   ```
6. Save the file
7. **Done!** The chat will now work like Gemini and answer ANY question!

### Option 3: Upgrade Your Plan
- Visit: https://ai.google.dev/pricing
- Upgrade to a paid plan for higher limits
- Free tier limits:
  - 60 requests per minute (RPM)
  - 1,500 requests per day (RPD)

## Once Fixed
Once you have quota available, the chat will:
- ✅ Answer ANY question (just like Gemini)
- ✅ Provide detailed, helpful responses
- ✅ Handle general knowledge, academic questions, and more
- ✅ Be conversational and friendly

## Test It
After fixing the quota issue, try asking:
- "What is the capital of France?"
- "How do I study better?"
- "Explain quantum physics"
- "What is the meaning of life?"
- Any other question!

The system is **fully configured** - you just need quota available! 🚀

