// Toggle FAQ
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const faqItem = question.parentElement;
        faqItem.classList.toggle('active');
    });
});

// Chatbot functionality
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotContainer = document.getElementById('chatbot-container');
    const chatbotClose = document.getElementById('chatbot-close');
    const messagesContainer = document.getElementById('chatbot-messages');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-message');

    chatbotToggle.addEventListener('click', () => {
        chatbotContainer.style.display = 'block';
    });

    chatbotClose.addEventListener('click', () => {
        chatbotContainer.style.display = 'none';
    });

    function addMessage(message, isUser) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user' : 'bot'}`;
        
        if (!isUser) {
            const avatarImg = document.createElement('img');
            avatarImg.src = 'images/bot-avatar.png';
            avatarImg.alt = 'Bot';
            avatarImg.className = 'bot-avatar';
            messageDiv.appendChild(avatarImg);
        }

        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        messageContent.textContent = message;
        messageDiv.appendChild(messageContent);
        
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    async function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;

        addMessage(message, true);
        userInput.value = '';

        try {
            const response = await fetch('http://localhost:5000/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            addMessage(data.response, false);
        } catch (error) {
            console.error('Error:', error);
            addMessage('Sorry, there was an error processing your message.', false);
        }
    }

    sendButton.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});

// Add floating button to all pages
document.addEventListener('DOMContentLoaded', () => {
    if (!document.querySelector('.chatbot-toggle')) {
        const button = document.createElement('button');
        button.className = 'chatbot-toggle';
        button.innerHTML = '<i class="fas fa-comments"></i>';
        document.body.appendChild(button);
    }
}); 