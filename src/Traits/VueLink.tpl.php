<?php /** @var  \xltxlm\h5skin\Traits\VueLink $this */
use xltxlm\h5skin\Request\UserCookieModelCopy; ?>

<link rel="stylesheet" type="text/css" href="/static/css/vue-multiselect.min.css" media="screen">
<script src="/static/js/vue-multiselect.min.js"></script>
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
    //字段关联外表对照关系
    if(typeof Field2tables == 'undefined')
    {
        Field2tables =[];
    }
    var oldgetdata=[];
    var <?=$this::vueel()?> =new Vue({
            components: {
                Multiselect: window.VueMultiselect.default
            },
            data: {
                //请求页面模型
                requestmodel:requestmodel,
                //ajax接受到的结果集
                alldata: alldata,
                oldalldata:[],
                openeditflag:"",
                openedittagname:"",
                openeditiitem:"",
                tmpindex: 0,
                modelname: modelname,
                reloadfield:reloadfield,
                searchform:searchform,
                draggable:draggable
            },
        methods: {
                addTag:function(newTag) {
                    eval('model=this.alldata.'+this.modelname);
                    model[this.tmpindex][this.openedittagname].push(newTag)
                    //this.value.push(tag)
                },
                //请求页面接口新数据
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
                    this.action();
                },

                //以下是点击编辑的切换状态
                openedit:function (id,index,item,tagname) {
                    this.tmpindex = index;
                    this.openeditflag = id;
                    this.openeditiitem = item;
                    this.openedittagname = tagname;
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
        }).$mount("#<?=$this::vueel()?>");

    //拉取数据
    <?=$this::vueel()?>. action();

    //管辖之内,数据变动，提交上传
    eval('watchmodel={object:<?=$this::vueel()?>.$data.alldata.'+modelname+',name:"'+modelname+'"}');
    eval('watchmodeled={object:<?=$this::vueel()?>.$data.alldata.'+modelname+'ed,name:"'+modelname+'ed"}');
    [watchmodel,watchmodeled].forEach(function(watchmodelItem,itemindex) {
        watchmodelItem.object.forEach(function (item,index) {
            for (var tagname in item) {
                //如果是外关联别的表格，那么在本表写入格式的明文的json字符串
                if($.inArray(tagname,Field2tables) != -1)
                {
                    if(item[tagname][0]=='[')
                        item[tagname]=JSON.parse(item[tagname]);
                    else
                        item[tagname]=[];
                }
                console.log('alldata.'+watchmodelItem.name+'.'+index+"."+tagname)
                console.log("->alldata."+modelname+'.'+index+"."+tagname)
                //绑定操作
                <?=$this::vueel()?>.$watch('alldata.'+watchmodelItem.name+'.'+index+"."+tagname,function (newVal, oldVal) {
                //<?=$this::vueel()?>.$watch("alldata."+modelname+'.'+index+"."+tagname,function (newVal, oldVal) {
                    console.log("有数据发生改变.");
                    //如果没标志要修改的字段名字。退出.
                    if(!this.openedittagname)
                    {
                        console.log("没有指明标记的标签名字.");
                        return false;
                    }
                    if(typeof newVal =='object')
                    {
                        newVal=JSON.stringify(newVal);
                    }
                    //发送数据,编辑当前字段的值
                    $.ajax({
                        dataType: "json",
                        method: "GET",
                        url: '<?=$this->getEditAjaxUrl()?>',
                        data: {
                            'id':this.openeditflag,
                            'name':this.openedittagname,
                            'value':newVal
                        },
                        success: function (result) {
                            if($.inArray(<?=$this::vueel()?>.$data.openedittagname,<?=$this::vueel()?>.$data.reloadfield) != -1)
                            {
                                //如果带有多选下拉框，只能刷新页面了
                                if([].toString()==Field2tables.toString())
                                {
                                    <?=$this::vueel()?>.action();
                                    ajaxSuccess(result,<?=$this::vueel()?>.$data.openeditiitem);
                                }else
                                {
                                    window.location.reload();
                                }
                            }
                        },
                        error:function (XMLHttpRequest,textStatus) {
                            ajaxError(textStatus,<?=$this::vueel()?>.$data.openeditiitem)
                        },
                        complete:function (XMLHttpRequest, textStatus) {
                            <?=$this::vueel()?>.$data.openedittagname='';
                        }
                    });
                });

            }
        })
    });

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
    });

</script>