const CONFIG = {
    OPENAI_API_KEY: 'your-openai-api-key', // Ganti dengan API key Anda
    CHATBOT_SETTINGS: {
        model: "gpt-3.5-turbo",
        temperature: 0.7,
        max_tokens: 150,
        initial_prompt: `You are a helpful customer service assistant for a job portal website. 
                        You help users with questions about job searching, account creation, 
                        application process, and general website navigation. Keep responses 
                        concise and friendly.`
    }
}; 