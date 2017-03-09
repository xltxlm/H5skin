<?php /** @var  \xltxlm\h5skin\Traits\VuePatchJs $this */ ?>

<script>
    var vueel = (new Vue({
            el: "#vueel",
            data: {
                alldata: []
            },
            methods: {
                SearchDo: function () {
                    var taget = $(event.currentTarget);
                    if (taget.val() != "") {
                        $.ajax({
                            dataType: "json",
                            method: "GET",
                            url: '<?=$this->getUrl()?>',
                            data: {keyword: taget.val()},
                            success: function (result) {
                                vueel.$data.alldata = result;
                            }
                        });
                    }
                }

            }
        })
    );
</script>