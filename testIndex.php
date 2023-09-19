<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Chatbot</title>
</head>
<body>
    <h1>Simple Chatbot</h1>
    <div id="chat-container">
        <!-- Chat messages will be displayed here -->
    </div>
    <form id="chat-form">
        <input type="text" id="user-input" placeholder="Type your message..." required>
        <button type="submit">Send</button>
    </form>

    <script>
        const chatContainer = document.getElementById('chat-container');
        const chatForm = document.getElementById('chat-form');
        const userInput = document.getElementById('user-input');

        async function fetchBotResponse(userMessage){
            try {
                const response = await fetch('testMessages.json');
                if (!response.ok) {
                    throw new Error('Failed to fetch responses.');
                }

                const data = await response.json();
                const responses = data.responses;

                // Check if the user's message corresponds to a response in the JSON file
                const botResponse = responses[userMessage];
                if (botResponse) {
                    return botResponse;
                } else {
                    return "I'm sorry, I don't understand your question.";
                }
            } 
            catch (error) {
                console.error('Error fetching or parsing JSON:', error);
                return "An error occurred. Please try again.";
            }
        }

        async function handleUserMessage(userMessage) {
            // Display user message in the chat
            chatContainer.innerHTML += `<p><strong>You:</strong> ${userMessage}</p>`;

            const botResponse = await fetchBotResponse(userMessage);

            // Display bot's response in the chat
            chatContainer.innerHTML += `<p><strong>Bot:</strong> ${botResponse}</p>`;
            
            // Scroll to the bottom of the chat
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const userMessage = userInput.value.trim();
            if (userMessage === '') return;

            await handleUserMessage(userMessage);

            // Clear the input field
            userInput.value = '';
        });

        async function initializeChat() {
            const response = await fetch('phpBackend.php');
            if (response.ok) {
                const data = await response.json();
                const chatHistory = data.chatHistory;

                for (const message of chatHistory) {
                    chatContainer.innerHTML += `<p><strong>${message.user}:</strong> ${message.bot}</p>`;
                }
            } else {
                console.error('Error fetching chat history.');
            }
        }

        // Initialize the chat when the page loads
        initializeChat();
    </script>
</body>
</html>



