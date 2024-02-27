<?php
if(!defined('_TUBEWEB_')) exit;

include_once(TB_PHPMAILER_PATH.'/PHPMailerAutoload.php');

// 메일 보내기 (파일 여러개 첨부 가능)
// type : text=0, html=1, text+html=2
function mailer($fname, $fmail, $to, $subject, $content, $type=0, $file="", $cc="", $bcc="")
{
    if($type != 1)
        $content = nl2br($content);

    $mail = new PHPMailer(); // defaults to using php "mail()"
    if(defined('TB_SMTP') && TB_SMTP) {
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host = TB_SMTP; // SMTP server
        if(defined('TB_SMTP_PORT') && TB_SMTP_PORT)
            $mail->Port = TB_SMTP_PORT;

        /* 추가 시작 */
        $mail->SMTPAuth = true;
        $mail->AuthType = "LOGIN";  // 이건 있어도 없어도 상관없는 듯 합니다.
        $mail->SMTPSecure = TB_SMTP_SECURE;
        $mail->Username = TB_SMTP_USER;
        $mail->Password = TB_SMTP_PW;
        /* 추가 끝 */

    }
    $mail->CharSet = 'UTF-8';
    $mail->From = $fmail;
    $mail->FromName = $fname;
    $mail->Subject = $subject;
    $mail->AltBody = ""; // optional, comment out and test
    $mail->msgHTML($content);
    $mail->addAddress($to);
    if($cc)
        $mail->addCC($cc);
    if($bcc)
        $mail->addBCC($bcc);
    //print_r2($file); exit;
    if($file != "") {
        foreach ($file as $f) {
            $mail->addAttachment($f['path'], $f['name']);
        }
    }
    return $mail->send();
}

// 파일을 첨부함
function attach_file($filename, $tmp_name)
{
    // 서버에 업로드 되는 파일은 확장자를 주지 않는다. (보안 취약점)
    $dest_file = TB_DATA_PATH.'/tmp/'.str_replace('/', '_', $tmp_name);
    move_uploaded_file($tmp_name, $dest_file);
    $tmpfile = array("name" => $filename, "path" => $dest_file);
    return $tmpfile;
}
?>
