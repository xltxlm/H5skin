<?php /** @var  \xltxlm\h5skin\Traits\VueLink $this */
use xltxlm\h5skin\Request\UserCookieModelCopy; ?>

<script>
    var getdata = {};
    var <?=$this::vueel()?> =(new Vue({
            el: "#<?=$this::vueel()?>",
            data: {
                //ajax接受到的结果集
                alldata: {},
                page: [],
                firstopen: true,
                openeditflag:"",
                tmpindex: 0
            },
            methods: {
                action: function () {
                    var getdata={};
                    //拼接查询的数据参数
                    $('#<?=$this::vueel()?> form [name]').each(function () {
                        getdata[this.name] = this.value;
                    });
                    //发送数据,查询内容
                    $.ajax({
                        dataType: "json",
                        method: "GET",
                        url: '<?=$this->getUrl()?>',
                        data: getdata,
                        async:false,
                        success: function (result) {
                            <?=$this::vueel()?>. $data.alldata = result.data;
                            <?=$this::vueel()?>. $data.page = result.page;
                        }
                    });
                    this.firstopen = false
                },
                //以下是分页条
                pageBar:function (pageid) {
                    $('#<?=$this::vueel()?> form [name=<?=UserCookieModelCopy::pageID()?>]').val(pageid)
                    <?=$this::vueel()?>.action();
                },

                //以下是点击编辑的切换状态
                openedit:function (id) {
                    <?=$this::vueel()?>.$data.openeditflag = id;
                },

                editField:function () {
                    object=event.currentTarget;
                    var postdata={};
                    //主键id
                    postdata['id']=this.openeditflag;
                    //字段名字 => 字段值
                    postdata['name']=object.name;
                    postdata['value']=object.value;


                    //发送数据,编辑当前字段的值
                    $.ajax({
                        dataType: "json",
                        method: "GET",
                        url: '<?=$this->getEditAjaxUrl()?>',
                        data: postdata,
                        success: function (result) {
                            <?=$this::vueel()?>.action();
                        }
                    });
                },

                // 以下是表格拖的功能 index:被压元素的坑
                drop: function (index, event) {
                    var tmp = this.alldata.edit[this.tmpindex];
                    //删除掉拽住的元素
                    this.alldata.edit.splice(this.tmpindex, 1);
                    //被压的元素前面加 上 拽住的元素
                    this.alldata.edit.splice(index, 0,tmp);
                },
                dragover: function (event) {
                    event.preventDefault();
                },
                dragstart: function (index, eveent) {
                    this.tmpindex = index;
                }

            }
        })
    );

    //管辖之内,有name的元素,全部加上联动绑定
    $(function () {
        $('#<?=$this::vueel()?> form [name]').each(function () {
            $(this).keyup(function () {
                <?=$this::vueel()?>.action();
            });
            $(this).blur(function () {
                <?=$this::vueel()?>.action();
            });
            $(this).change(function () {
                <?=$this::vueel()?>.action();
            });
            $(function () {
                $('.daterangepickerClass').on('apply.daterangepicker cancel.daterangepicker', function (ev, picker) {
                    <?=$this::vueel()?>.action();
                });
            })
        });
        <?=$this::vueel()?>. action();
    });

</script>