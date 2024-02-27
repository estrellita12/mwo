<?php
if(!defined('_TUBEWEB_')) exit;

$pg_title = "회원 정보관리";
include_once("./admin_head.sub.php");
?>

<form name="fregform" method="post" action="./seller_member_info_update.php" onsubmit="return fsellerform_submit(this);">
<input type="hidden" name="token" value="">
<h2>서비스 이용정보</h2>
<div class="tbl_frm01">
    <table>
    <colgroup>
        <col class="w140">
        <col>
    </colgroup>
    <tr>
        <th scope="row">아이디</th>
        <td><?php echo $member['id']; ?></td>
    </tr>
    <tr>
        <th scope="row">비밀번호</th>
        <td>
            <input type="password" name="mb_password" id="reg_mb_password" required class="required frm_input" placeholder="5~15자 / 영문자,숫자만 사용 가능" size=40>
            <span id="msg_mb_password" class="padl5"></span>
        </td>
    </tr>
    <tr>
        <th scope="row">비밀번호 확인</th>
        <td>
            <input type="password" name="mb_password_re" id="reg_mb_password_re" required class="required frm_input" placeholder="5~15자 / 영문자,숫자만 사용 가능" size=40>
            <span id="msg_mb_password_re" class="padl5"></span>
        </td>
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_confirm">
    <input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>
<script>
function fsellerform_submit(f) {
    if(f.mb_password.value.length < 4) {
        alert("비밀번호를 4글자 이상 입력하십시오.");
        f.mb_password.focus();
        return false;
    }

    if(f.mb_password.value != f.mb_password_re.value) {
        alert("비밀번호가 같지 않습니다.");
        f.mb_password_re.focus();
        return false;
    }

    if(f.mb_password.value.length > 0) {
        if(f.mb_password_re.value.length < 4) {
            alert("비밀번호를 4글자 이상 입력하십시오.");
            f.mb_password_re.focus();
            return false;
        }
    }
    return true;
}

function fsellerform_submit(f) {
    // 회원아이디 검사
    var msg = reg_mb_id_check();
    if(msg) {
        alert(msg);
        f.mb_id.select();
        return false;
    }

    if(f.mb_password.value.length < 4) {
        alert("비밀번호를 4글자 이상 입력하십시오.");
        f.mb_password.focus();
        return false;
    }

    if(f.mb_password.value != f.mb_password_re.value) {
        alert("비밀번호가 같지 않습니다.");
        f.mb_password_re.focus();
        return false;
    }

    if(f.mb_password.value.length > 0) {
        if(f.mb_password_re.value.length < 4) {
            alert("비밀번호를 4글자 이상 입력하십시오.");
            f.mb_password_re.focus();
            return false;
        }
    }
    document.getElementById("btn_submit").disabled = "disabled";
    return true;
}

jQuery(function($){
    $("#reg_mb_password").keyup(function(){
        var len = $(this).val().length;
        if(len < 5){
            $("#msg_mb_password").html("비밀번호를 5글자 이상이어야 합니다.");
            $("#msg_mb_password").css("color","#ec0e03");
        }else{
            $("#msg_mb_password").html("사용 가능한 비밀번호입니다.");
            $("#msg_mb_password").css("color","#547eec");
        }
        $("#reg_mb_password_re").val("");
        $("#msg_mb_password_re").html("");
    });

    $("#reg_mb_password_re").keyup(function(){
        var pw = $("#reg_mb_password").val();
        var pwre = $(this).val();
        if(pw!=pwre){
            $("#msg_mb_password_re").html("비밀번호가 동일하지 않습니다.");
            $("#msg_mb_password_re").css("color","#ec0e03");
        }else{
            $("#msg_mb_password_re").html("");
            $("#msg_mb_password_re").css("color","#547eec");
        }
    });

});

</script>

<?php
include_once("./admin_tail.sub.php");
?>

