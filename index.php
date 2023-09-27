<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="styling/style.css" />
      <title>Chatbot</title>      
      <script>
         
         function updateCharCount() {
            const textfield = document.getElementById("userInput");
            const charCount = document.getElementById("charCount");
            const currentText = textfield.value.length;
            console.log(currentText);

            //set character count length
            let setChar = textfield.setAttribute("maxlength", "90");
            let maxLength = textfield.getAttribute("maxlength");

            charCount.textContent = `${currentText} / ${maxLength}`;
         }         

      </script>
   </head>

   <body>
      <div id="container">
         <div id="chatbotContainer">
            <div id="chatWindow">
               <!-- chat goes here -->
            </div>
            <div id="userInputForm">
               <form id="chat-form">
                  <div id="formElements">
                     <textarea id="userInput" oninput="updateCharCount()" name="user_input" maxlength="100" placeholder="Start chatting here..." rows="4" cols="50"></textarea>
                     <button id="formSubmitButton" type="submit"><i class="arrow right"></i></button>
                     <div class="box-container">
                        <p id="charCount"></p>
                     </div>
                     <button onclick="resetSession()">Reset Session</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <script>
         const chatContainer = document.getElementById('chatWindow');
         const chatForm = document.getElementById('chat-form');
         const userInput = document.getElementById('userInput');       

        function postData(url, data) {
            return fetch(url, {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json', // Adjust the content type based on your needs
                },
                body: JSON.stringify(data), // Convert data to JSON format
            })
            .then(response => {
                if (!response.ok) {
                throw new Error('Network response was not ok');
                }
                return response.json(); // Parse the response as JSON
            })
            .catch(error => {
                console.error('There was an error:', error);
            });
        }

        async function handleUserMessage(userMessage, botResponse) {
            // Display user message in the chat
            chatContainer.innerHTML += `<p><strong>You:</strong> ${userMessage}</p>`;

            // Display bot's response in the chat
            chatContainer.innerHTML += `<p><strong>Bot:</strong> ${botResponse}</p>`;
            
            // Scroll to the bottom of the chat
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const userMessage = userInput.value.trim();
            if (userMessage === '') return;
            const jsonData = {user_input: userMessage};

            const botResponse = await postData("api/phpBackend.php", jsonData);
            await handleUserMessage(userMessage, botResponse['response']);
            
            // Clear the input field
            userInput.value = '';
        });

        async function initializeChat() {
            const response = await fetch('api/phpBackend.php');
            if (response.ok) {
               const data = await response.json();
               const chatHistory = Object.values(data.chatHistory);

               if (Array.isArray(chatHistory)) {
                     for (const message of chatHistory) {
                        await handleUserMessage(message.user, message.bot);
                     }
               } else {
                     console.error('Chat history is not an array.');
               }
            } else {
               console.error('Error fetching chat history.');
            }
         }

         updateCharCount();
         // Initialize the chat when the page loads
         initializeChat();
      </script>
   </body>
</html>