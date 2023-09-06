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
            let maxLength = textfield.getAttribute("maxlength");

            charCount.textContent = `${currentText} / ${maxLength}`;
         }
         
         textfield.addEventListener('input', updateCharCount);         

         
      </script>
   </head>
   <?php
   //sleep(5);
   $botResponses = [
      "standart response" => "I didn't quite get that.",
      "what is your name?" => "My name is chatbot.",
      "hello there" => "General Kenobi",
   ]

   ?>

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
                  <p class="userChatReply">
                     <?php
                     if(isset($_GET["userInput"])){
                        echo $_GET["userInput"];
                     }else echo "...";
                     ?>
                   </p>
                  </div>
                  <div class="chatbotTextChat">
                     <p class="chatbotChatReply">
                        <?php
                        if(isset($_GET["userInput"])){
                           if(array_key_exists($_GET["userInput"], $botResponses)){
                              echo $botResponses[$_GET["userInput"]];
                           }else {echo $botResponses["standart response"];}
                        }else echo "...";
                        ?>
                     </p>
                  </div>
            </div>
            <div id="userInputForm">
               <form action="?" method="get">
                  <div id="formElements">
                     <textarea id="userInput" oninput="updateCharCount()" name="userInput" maxlength="50" placeholder="Start chatting here..." rows="4" cols="50"></textarea>
                     <button id="formSubmitButton" type="submit"><i class="arrow right"></i></button>
                     <div class="box-container">
                        <p id="charCount">0 / 200</p>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <script>
         updateCharCount();
      </script>
   </body>
</html>