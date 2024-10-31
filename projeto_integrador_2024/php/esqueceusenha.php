<?php
//teste 3

   function EnviarMail($destinatario, $assunto, $mensagem)
  {
      $from = "estudypi.com.br@estudy.com.br";
      $headers = "From: E-Study <".$de.">\n";
      $destinatario = $destinatario;
     // $headers = "Content-Type: Text/HTML; charset=UTF-8\n";
    
       formatação da mensagem em HTML
      $mensagem = '<html>
       <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
       <body>
       "Oi"
     </body>
      </html>';
  
   $ok = mail($destinatario,$mensagem,$headers);
  
     return $ok;
 }

    // $campo = $_POST['campo'];

    // // Configurações do e-mail
    // $from = "estudypi.com.br@estudy.com.br";
    // $to = $campo;
    // $subject = "Esqueceu a senha - Solicitação de redefinição";
    // $message = "Para trocar sua senha, acesse: ";
    // $headers = "From: " . $from;  // Substitua por um e-mail válido do seu domínio

    // // Enviar o e-mail
    // mail($to, $subject, $message, $headers); 
    //   echo "Enviado.";

?>
