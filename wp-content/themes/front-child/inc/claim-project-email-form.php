<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $mail_to = $_POST["mailto"];
  $subject = "Cosmos Jobs - Claim Project Request";

  # Sender Data
  $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
  $user_email = filter_var(trim($_POST["user_email"]), FILTER_SANITIZE_EMAIL);
  $project = trim($_POST["project"]);
  
  if ( empty($name) OR !filter_var($user_email, FILTER_VALIDATE_EMAIL) OR empty($project)) {
      # Set a 400 (bad request) response code and exit.
      http_response_code(400);
      echo "Please complete the form and try again.";
      exit;
  }
  
  # Mail Content
  $content = "Name: $name\n";
  $content .= "Email: $user_email\n\n";
  $content .= "Project: $project\n";

  # email headers.
  $headers = "From: $name &lt;$email&gt;";

  # Send the email.
  $success = mail($mail_to, $subject, $content, $headers);
  if ($success) {
      # Set a 200 (okay) response code.
      http_response_code(200);
      echo "Thank You! You have successfully requested to claim this project.";
  } else {
      # Set a 500 (internal server error) response code.
      http_response_code(500);
      echo "Oops! Something went wrong, we couldn't send your message.";
  }

  } else {
      # Not a POST request, set a 403 (forbidden) response code.
      http_response_code(403);
      echo "There was a problem with your submission, please try again.";
  }