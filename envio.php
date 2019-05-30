<?
if (isset($_POST['enviar'])){
/****************************************************/
// lembre-se que no <form> precisa conter o -> enctype="multipart/form-data" para upload de arquivos, senão não funcionará
/***************************************************/
//Variaveis de POST
//====================================================
$nome = ucwords($_POST["nome"]);
$mensagem_exibir = strip_tags(trim(ucwords(nl2br($_POST["mensagem"]))));
$email_form = $_POST["email"];
$telefone = $_POST["telefone"];
$whats = $_POST["whats"];
$assunto = ucwords($_POST["assunto"]);
$arquivo = $_FILES['arquivo'];
//====================================================
//email para onde será enviado
$email_para='seu-email@seudominio.com.br';
//====================================================
//configuração de upload
$tamanho = 5242880; // aqui o máximo do upload é de 5MB, para alterar, digite no Google "5MB para Bytes" e veja o valor exato para colocar na variável
$tipos = array('application/pdf','application/msword'); // caso deseje outros tipos de extensões, pesquise por mime types no Google e veja a lista
//====================================================
//validação do assunto do email
// aqui está em número pois fiz uma validação em js para liberar campos de acordo com o que a pessoa seleciona na combo do assunto
if ($assunto=='1') {
    $assunto_exibe = 'Contato Pelo Site - Seu Site';
}elseif ($assunto=='2') {
    $assunto_exibe = 'Cadastro de Currículo - Seu Site';
}else{
    $assunto_exibe = 'Parceria - Seu Site';
}
//====================================================
//verifica o tamanho e tipo antes do upload do arquivo
if ($arquivo['size']>$tamanho) {
     echo '<script>alert("O arquivo deve conter no máximo 5MB");</script>';
}elseif (!in_array($arquivo['type'], $tipos)) {
     echo '<script>alert("São aceitos apenas arquivos PDF e .DOC (WORD)")</script>';
}else{
//====================================================
//pega o tipo do arquivo e muda extensão
if ($arquivo['type']=='application/pdf') {
    $tipo ='.pdf';
}else{
    $tipo = '.doc';
}
//====================================================
//se tudo está ok, realiza o envio
require('PHPMailer/class.phpmailer.php');

$mail = new PHPMailer();

$mail -> IsMail(); //tipo email
$mail -> SetFrom($email_form, $nome); //remetente
$mail -> AddAddress($email_para,'Seu Site'); //destinatário
$mail ->AddBCC("seu-email@seudominio.com.br", "Seu Site"); //cópia oculta para controle interno caso necessário
$mail -> Subject = $assunto_exibe; // assunto do e-mail
//======================================================
//função de data para obter informações de quando foi enviado o e-mail e ser exibido junto ao corpo do e-mail
$datas    = date('D');
$mes      = date('M');
$dia      = date('d');
$ano      = date('Y');
$semana   = array("Sun" => "Domingo", "Mon" => "Segunda-Feira", "Tue" => "Terca-Feira", "Wed" => "Quarta-Feira", "Thu" => "Quinta-Feira", "Fri" => "Sexta-Feira", "Sat" => "Sabado");
$mess = array("Jan" => "Janeiro", "Feb" => "Fevereiro", "Mar" => "Marco", "Apr" => "Abril", "May" => "Maio", "Jun" => "Junho", "Jul" => "Julho", "Aug" => "Agosto", "Sep" => "Setembro", "Oct" => "Outubro", "Nov" => "Novembro", "Dec" => "Dezembro");
$data     = $semana["$datas"].", $dia de ".$mess["$mes"]." de $ano";
$hora     = date("H:i:s");                                      //Hora
//======================================================
// corpo do e-mail, ou seja, o layout do mesmo.
$url_site ='https://www.seudominio.com.br'; // url do site para configuração de redirecionamento em cliques e imagens
$empresa = 'Eduardo Honorato'; //empresa desenvolvedora
$nome_empresa = 'Empresa'; //Nome da empresa que irá receber o e-mail
$body ='<html>
        <head><style>.a1:link,.a1:hover,.a1:visited{color:#006CFF;text-decoration:none;}</style></head>
        <body>
        <table>
          <tr>
            <td align="center" valign="top" style="padding:20px;background-color:#F1F1F1;">
              <table width="800" border="0">
                <tr>
                  <td height="110">
                    <a href="'.$url_site.'" target="_blank">
                      <img src="'.$url_site.'/images/topo-email.png" width="800" height="110" border="0"/>
                    </a>
                  </td>
                </tr>
              </table>
              <table width="800" border="0">
                <tr>
                  <td height="20"></td>
                </tr>
              </table>
              <table width="800" border="0">
                <tr>
                  <td height="auto" style="padding:20px;" bgcolor="#FFFFFF" align="justify">
                    <font face="Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana, sans-serif" size="3">
                    <b><font color="#5997d1">'.$nome_empresa.'</font></b>, uma nova mensagem foi transmitida pelo site. A mensagem encontra-se abaixo.<br>
                    Data Envio: '.$data.' às '.$hora.'
                    <br>
                    <br>
                    <b>Nome: </b><font color="#5997d1"><strong>'.$nome.'</strong></font><br>
                    <br>
                    <b>E-mail: </b><font color="#5997d1"><strong>'.$email_form.'</strong></font><br>
                    <br>
                    <b>Telefone: </b><font color="#5997d1"><strong>'.$telefone.'</strong></font><br>
                    <br>
                    <b>WhatsApp: </b><font color="#5997d1"><strong>'.$whats.'</strong></font><br>
                    <br>
                    <b>Assunto: </b><font color="#5997d1"><strong>'.$assunto_exibe.'</strong></font><br>
                    <br>
                    <b>Mensagem: </b><font color="#5997d1"><strong>'.$mensagem_exibir.'</strong></font>
                    <br>
                    <br>
                    <br>
                    Atenciosamente, <br>
                    <strong>'.$nome_empresa.' </strong></font>
                  </td>
                </tr>
              </table>
              <table width="800" border="0">
                <tr>
                  <td height="auto" style="padding:20px;" bgcolor="#E4E4E4" align="justify">
                    <font face="Arial" color="#AAAAAA" size="2">
                    <br>
                    Mensagem enviada através do site <a href="'.$url_site.'" target="_blank"><font face="Arial, Helvetica, sans-serif" size="2" color="#666666">'.$url_site.'</font></a> pelo formulário de contato.
                   
                    </font>
                  </td>
                </tr>
              </table>
              <p>
                <font size="2" color="#aaa" face="Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana, sans-serif">'.date('Y').' &copy; '.$empresa.'</font>
              </p>
            </td>
          </tr>
        </table>
        </body>
        </html>';

        $mail -> MsgHTML(utf8_decode($body)); // monta o layout no corpo do e-mail
        //========================================================================
        // aqui será realizado o Attachment, ou seja, o anexo do arquivo. no meu caso, como foi upload de currículo eu fiz da seguinte maneira:
        // ele está renomeando o arquivo para currículo-nome-do-cara-que-enviou.extensão [pdf/doc]
        $mail -> AddAttachment($_FILES['arquivo']['tmp_name'], 'curriculo-'.$nome.$tipo);
        // agora ele realizará o envio do e-mail, se for sucesso, ele mostrará um alert com a mensagem de enviado com sucesso, senão retorna o erro.
        // você poderá usar o alert normal ou então algum framework do tipo select2.js ou Toast.js
        if ($mail->Send()) {
            echo '<script>alert("Mensagem enviada com sucesso")</script>';
        }else{
            echo '<script>alert("Erro ao enviar mensagem")</script>';
        }
    }
//====================================================
//fim do script
}
?>