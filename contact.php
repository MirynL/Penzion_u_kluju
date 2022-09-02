<?php

if(isset($_POST)) {
    $visitor_name = "";
    $visitor_email = "";
    $email_title = "";
    $visitor_message = "";
    $email_body = "<div>";
      
    if(isset($_POST['name'])) {
        $visitor_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Jméno:</b></label>&nbsp;<span>".$visitor_name."</span>
                        </div>";
    }
 
    if(isset($_POST['email'])) {
        $visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
        $visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
        $email_body .= "<div>
                           <label><b>Email:</b></label>&nbsp;<span>".$visitor_email."</span>
                        </div>";
    }
      
    if(isset($_POST['subject'])) {
        $email_title = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Předmět:</b></label>&nbsp;<span>".$email_title."</span>
                        </div>";
    }
      
      
    if(isset($_POST['message'])) {
        $visitor_message = htmlspecialchars($_POST['message']);
        $email_body .= "<div>
                           <label><b>Zpráva:</b></label>
                           <div>".$visitor_message."</div>
                        </div>";
    }
      
  
        $recipient = "mirecloc@seznam.cz";

      
    $email_body .= "</div>";
 
    $headers  = 'MIME-Version: 1.0' . "\r\n"
    .'Content-type: text/html; charset=utf-8' . "\r\n"
    .'From: ' . $visitor_email . "\r\n";
      
    if(mail($recipient, 'Zpráva z formuláře - '.$email_title, $email_body, $headers)) {
        
        $msg = "<div class='alert rounded-0 alert-dismissible alert-success slide'>Děkujeme za zprávu. Odpovíme Vám, jakmile to bude možné.  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        
    } else {
        
        $msg = "<div class='alert rounded-0 alert-dismissible alert-danger slide'>Něco se pokazilo. Zkuste to znovu.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
      
} else {
    $msg = "<div class='alert rounded-0 alert-dismissible alert-danger slide'>Něco se pokazilo. Zkuste to znovu.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";

}
echo json_encode($msg);
?>