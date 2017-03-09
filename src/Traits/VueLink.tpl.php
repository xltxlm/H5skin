<?php /** @var  \xltxlm\h5skin\Traits\VueLink $this */ ?>

<script>
    var getdata={};
    var <?=$this::vueel()?> = (new Vue({
            el: "#<?=$this::vueel()?>",
            data: {
                //ajax接受到的结果集
                alldata: []
            },
            methods: {
                action: function () {
                    var taget = $(event.currentTarget);
                    if (taget.val() != "") {
                        //拼接发送的数据参数
                        $('#<?=$this::vueel()?> [name]').each(function () {
                            getdata[this.name]=this.value;
                        });
                        //发送数据
                        $.ajax({
                            dataType: "json",
                            method: "GET",
                            url: '<?=$this->getUrl()?>',
                            data: getdata,
                            success: function (result) {
                                <?=$this::vueel()?>.$data.alldata = result;
                            }
                        });
                    }
                }

            }
        })
    );

    //管辖之内,有name的元素,全部加上联动绑定
    $(function () {
        $('#<?=$this::vueel()?> [name]').each(function () {
            $(this).keyup(function () {
                <?=$this::vueel()?>.action();
            })
        });
    });

</script>