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
         
         textfield.addEventListener('input', updateCharCount);
      </script>
   </head>

   <body>
      <div id="container">
         <div id="chatbotContainer">
            <div id="chatWindow">
               <div class="chatbotTextChat">
                  <p class="chatbotChatReply">Hello there</p>
               </div>
               <div class="userTextChat">
                  <p class="userChatReply">General Kenobi</p>
               </div>
               <div class="userTextChat">
                     <?php
                        if(isset($_GET["userInput"])){
                           $_SESSION['userText'] = $_GET["userInput"];
                           $sessionData = $_SESSION['userText'];
                           echo '<p class="userChatReply">' . $sessionData . '</p>';
                        }else echo '<p class="userChatReply">...</p>';
                     ?>
                  </div>
                  <div class="chatbotTextChat">
                     <?php
                        if(isset($_GET["botResponse"])){
                           $_SESSION['chatBotReply'] = $_GET["botResponse"];
                           $sessionBot = $_SESSION['chatBotReply'];
                           echo '<p class="chatbotChatReply">' . $sessionBot . '</p>';
                        }else echo '<p class="chatbotChatReply">...</p>';
                     ?>
                  </div>
            </div>
            <div id="userInputForm">
               <form action="botResponses.php" method="get">
                  <div id="formElements">
                     <textarea id="userInput" oninput="updateCharCount()" name="userInput" maxlength="100" placeholder="Start chatting here..." rows="4" cols="50"></textarea>
                     <button id="formSubmitButton" type="submit"><i class="arrow right"></i></button>
                     <div class="box-container">
                        <p id="charCount"></p>
                  </div>
               </form>
            </div>
         </div>
      <script>
         updateCharCount();
      </script>
   </body>
</html>