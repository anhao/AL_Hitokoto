<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('comm/header', $this->data);
?>
<main class="mdl-layout__content animated fadeIn">
    <div class="page-content">
        <div id="hitokoto" class="hitokoto-fullpage animated  bounceInUp">
            <div class="bracket left">『</div>
            <div class="word" id="home_hitokoto_text">在天原作比翼鸟，在地愿为连理枝。</div>
            <div class="bracket right">』</div>
            <div class="author" id="home_hitokoto_author"> - 「白居易 」</div>
        </div>
    </div>
</main>
</div>
<?php $this->load->view('comm/footer')?>
<script>


    function Home_Hitokoto() {
        $.ajax({
            url:url+'/Api',
            method:'get',
            success:function (res) {
                if($('#hitokoto').hasClass('animated')){
                    $('#hitokoto').removeClass("animated");
                    $('#hitokoto').removeClass('bounceInUp')
                }
                $('#hitokoto').animateCss('bounce');
                $('#home_hitokoto_text').text(res.hitokoto);
                let author = res.author?res.author:'无名氏'
                $('#home_hitokoto_author').text("-「" + author + "」")
                window.setTimeout(Home_Hitokoto,5000)
            },
            error:function () {

            }
        })
    }
    setTimeout(Home_Hitokoto,5000)
</script>
