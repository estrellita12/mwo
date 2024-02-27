<?php
define('_NEWWIN_', true);
include_once('./_common.php');
include_once(TB_ADMIN_PATH."/admin_head.php");
?>
<style>
#loading-box{
    display:none;
    position:absolute;
    width:100%;
    height:100%;
    top:0;
    left:0;
    background-color:rgba(100,100,100,0.5);
}
#loading-box #loading-innerbox{
    width:600px;
    height:200px;
    background-color:#fff;
    position:absolute;
    top:calc(50% - 100px);
    left:calc(50% - 300px);
    padding:20px;
    box-sizing:border-box;
}
#loading-box #loading-txtbox{
    height:50px;
    line-height:50px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
#loading-box #loading-header{
    font-size:15px;
    color:gray;
    font-weight:bold;
}
#loading-box #loading-perc{
    font-size:20px;
    display:none;
}
#loading-box #loading-imagebox{
    height:110px;
    text-align:center;
}
</style>
<div id="sodr_pop" class="new_win">
	<h1>동영상 업로드</h1>
    <section id="anc_sodr_list">
        <h4 class="anc_tit">동영상 업로드</h4>
        <ul class="marb10">
            <li class="fc_red">※ 재생 시간 60호 이하, 원본 화질 해상도 1090p 이라, 용량 10M 미만 동영상만 업로드 가능합니다.</li>
            <li></li>
        </ul>
        <form>
            <div style="padding:20px; border-radius:10px; border:1px dotted lightgray;">
                <input type="file" name="gs_video">
            </div>
		    <div class="btn_confirm">
                <button type="button" class="btn_medium" onclick="video_upload()">업로드</button>
			    <a href="javascript:window.close();" class="btn_medium bx-white">닫기</a>
		    </div>
		</form>
	</section>
    <div id="loading-box">
        <div id="loading-innerbox">
            <div id="loading-txtbox">
                <div id="loading-header">잠시만 기다려주세요. 2분 정도 시간이 소요됩니다.</div>
                <div id="loading-perc">50%</div>
            </div>
            <div id="loading-imagebox">
                <img src="https://mwo.kr/img/ajax-loader.gif">
            </div>
        </div>
        <!--
        <div id="loading-header">loading..</div>
        <div id="loading-txt"><span>00</span>:<span>00</span></div>
        <div id="loading-bar"></div>
        -->
    </div>
</div>
<script>
function video_upload(){
    const files = $("input[name='gs_video']");
    const inputFiles = files[0].files;
    if( inputFiles.length <= 0 ){
        alert("파일을 선택해주세요");
        return false;
    }

    $("#loading-box").css("display","block");   
    const formData = new FormData();
    formData.append("gs_video",inputFiles[0]);
    formData.append("gs_id","<?php echo $gs_id ?>");
    $.ajax({
        type: "POST",
        url: "./seller_goods_video_form_update.php",
        processData: false,
        contentType: false,
        data: formData,
        success: function (res) {
            console.log(res);
            $("#loading-box").css("display","none");   
            if(res == "1"){
                alert("업로드가 완료되었습니다.");
            }else{
                alert("업로드를 실패하였습니다. 잠시후 다시 시도해주세요");
            }
            window.close();
        },
        err: function (err) {
            $("#loading-box").css("display","none");   
            console.log("err:", err);
        },
    });
}
</script>


<?php
//include_once(TB_ADMIN_PATH."/admin_tail.sub.php");
?>
