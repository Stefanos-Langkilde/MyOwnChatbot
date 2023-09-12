<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="style.css" />
      <title>Chatbot</title>      
      <script>
         //let startTime = new Date().getTime();
         //while(new Date().getTime() < startTime + 2000){};
         
         //textfield.addEventListener('input', updateCharCount);
         
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
            <?php
               // PHP code to initialize session and retrieve chat history
               if (isset($_SESSION['chat_history'])) {
                  foreach ($_SESSION['chat_history'] as $message) {
                     echo "<p>$message</p>";
                  }
               }
            ?>
            </div>
            <div id="userInputForm">
               <form id="chat-form" action="?" method="get">
                  <div id="formElements">
                     <textarea id="userInput" oninput="updateCharCount()" name="userInput" maxlength="100" placeholder="Start chatting here..." rows="4" cols="50"></textarea>
                     <button id="formSubmitButton" type="submit"><i class="arrow right"></i></button>
                     <div class="box-container">
                        <p id="charCount"></p>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <script>
         fetch('messages.json')
         .then(Response => Response.json())
         .then(data => {
            const chatOutput = document.getElementById('chatWindow');
            const chatForm = document.getElementById('chat-form');
            const userInput = document.getElementById('user-input');

            function appendBotResponse(response) {
               chatOutput.innerHTML += `<p class="chatbotChatReply"><strong>Bot:</strong> ${response}</p><br/>`;
            }

            chatForm.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the form from submitting

                    if(!userInput.value){
                     const userMessage = "";
                    }else {
                       const userMessage = userInput.value.trim();
                    }
                    if (userMessage === '') return; // Ignore empty messages
                    userInput.value = ''; // Clear the input field

                    // Implement your chatbot logic here
                    let botResponse = "";
                    if (userMessage.toLowerCase() === 'name') {
                        botResponse = `My name is ${data.honda}`;
                    } else if (userMessage.toLowerCase() === 'age') {
                        botResponse = `I am ${data.ford} years old`;
                    } else if (userMessage.toLowerCase() === 'city') {
                        botResponse = `I live in ${data.toyota}`;
                    } else {
                        botResponse = "I didn't understand that.";
                    }

                    // Append the user's message and bot's response to chat history
                    chatOutput.innerHTML += `<p class="userChatReply"><strong>You:</strong> ${userMessage}</p><br/>`;
                    appendBotResponse(botResponse);

                    // PHP code to store chat history in session
                    <?php
                        if (!isset($_SESSION['chat_history'])) {
                              $_SESSION['chat_history'] = array();
                        }else {
                           array_push($_SESSION['chat_history'], "<strong>You:</strong> $userMessage", "<strong>Bot:</strong> $botResponse");
                        }
                    ?>
                });
            })
            .catch(error => {
               console.error('Error:', error);
            });
            updateCharCount();
      </script>
   </body>
</html>