<?php /** @var  \xltxlm\h5skin\Traits\VueLink $this */
use xltxlm\h5skin\Request\UserCookieModelCopy; ?>

<script>
    //searchform 可以由网页自定义.如果没有定义,那么默认搜索框是关闭的
    if(typeof searchform === 'undefined')
    {
        searchform =false;
    }
    //draggable 是否可以拖拽排序
    if(typeof draggable === 'undefined')
    {
        draggable =false;
    }
    //modelname 当前项目的模型名称
    if(typeof modelname == 'undefined')
    {
        modelname ='';
    }
    var oldgetdata=[];
    var <?=$this::vueel()?> =(new Vue({
            el: "#<?=$this::vueel()?>",
            data: {
                //请求页面模型
                requestmodel:requestmodel,
                //ajax接受到的结果集
                alldata: alldata,
                oldalldata:[],
                openeditflag:"",
                openeditiitem:"",
                tmpindex: 0,
                modelname: modelname,
                reloadfield:reloadfield,
                searchform:searchform,
                draggable:draggable
            },
            methods: {
                //请求接口新数据
                action: function () {
                    var getdata={};
                    //拼接查询的数据参数
                    $('#<?=$this::vueel()?> form [name]').each(function () {
                        getdata[this.name] = this.value;
                    });
                    oldgetdata=getdata;
                    //发送数据,查询内容
                    $.ajax({
                        dataType: "json",
                        method: "GET",
                        url: '<?=$this->getUrl()?>',
                        data: getdata,
                        async:false,
                        success: function (result) {
                            <?=$this::vueel()?>. $data.alldata = result;
                            //借助json进行深拷贝，如果直接等于的话， oldalldata 和 alldata 实时联动的
                            <?=$this::vueel()?>. $data.oldalldata = JSON.parse(JSON.stringify(result));
                        }
                    });
                },
                //以下是分页条
                pageBar:function (pageid) {
                    $('#<?=$this::vueel()?> form [name=<?=UserCookieModelCopy::pageID()?>]').val(pageid)
                    <?=$this::vueel()?>.action();
                },

                //以下是点击编辑的切换状态
                openedit:function (id,index,item) {
                    this.tmpindex = index;
                    <?=$this::vueel()?>.$data.openeditflag = id;
                    <?=$this::vueel()?>.$data.openeditiitem = item;
                },

                editField:function () {
                    object=event.currentTarget;
                    var postdata={};
                    //主键id
                    postdata['id']=this.openeditflag;
                    //字段名字 => 字段值
                    postdata['name']=object.name;
                    postdata['value']=object.value;
                    //只有编辑的内容和之前不一致，才请求新数据
                    eval('oldmodel=this.oldalldata.'+this.modelname);
                    if (object.value == oldmodel[this.tmpindex][object.name] )
                    {
                        return;
                    }


                    //发送数据,编辑当前字段的值
                    $.ajax({
                        dataType: "json",
                        method: "GET",
                        url: '<?=$this->getEditAjaxUrl()?>',
                        data: postdata,
                        success: function (result) {
                            if($.inArray(object.name,<?=$this::vueel()?>.$data.reloadfield) != -1)
                            {
                                <?=$this::vueel()?>.action();
                                ajaxSuccess(result,<?=$this::vueel()?>.$data.openeditiitem);
                            }
                        },
                        error:function (XMLHttpRequest,textStatus) {
                            ajaxError(textStatus,<?=$this::vueel()?>.$data.openeditiitem)
                        }
                    });
                },

                // 以下是表格拖的功能 index:被压元素的坑
                drop: function (index, event) {
                    eval('model=this.alldata.'+this.modelname);
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        url: '<?=$this->getDragAjaxUrl()?>',
                        data:{
                            'from':model[this.tmpindex],
                            'to':model[index]
                        },
                        success: function (result) {
                            if(result.code == 0)
                            {
//                                var tmp = model[this.tmpindex];
//                                //删除掉拽住的元素
//                                model.splice(this.tmpindex, 1);
//                                //被压的元素前面加 上 拽住的元素
//                                model.splice(index, 0,tmp);
                                <?=$this::vueel()?>.action();
                                ajaxSuccess(result,<?=$this::vueel()?>.$data.openeditiitem);
                            }else
                            {
                                ajaxError(result)
                            }
                        },
                        error:function (XMLHttpRequest,textStatus) {
                            ajaxError(textStatus,<?=$this::vueel()?>.$data.openeditiitem)
                        }
                    });
                },
                dragover: function (event) {
                    event.preventDefault();
                },
                dragstart: function (index, event) {
                    this.tmpindex = index;
                }

            }
        })
    );

    //管辖之内,有name的元素,全部加上联动绑定
    $(function () {
        $('#<?=$this::vueel()?> form [name]').each(function () {
            $(this).keyup(function () {
                //console.log('触发函数:keyup');
                //数据不一致才执行查询
                if(this.value != oldgetdata[this.name])
                { <?=$this::vueel()?>.action(); }
            });
            $(this).blur(function () {
                //console.log('触发函数:blur');
                //数据不一致才执行查询
                if(this.value != oldgetdata[this.name])
                { <?=$this::vueel()?>.action(); }
            });
            $(this).change(function () {
                //console.log('触发函数:change');
                if(this.value != oldgetdata[this.name])
                {<?=$this::vueel()?>.action();}
            });
        });
        $('.daterangepickerClass').on('apply.daterangepicker cancel.daterangepicker', function (ev, picker) {
            <?=$this::vueel()?>.action();
        });
        <?=$this::vueel()?>. action();
    });

</script>