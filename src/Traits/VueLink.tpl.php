<?php /** @var  \xltxlm\h5skin\Traits\VueLink $this */
use xltxlm\h5skin\Request\UserCookieModelCopy; ?>

<link rel="stylesheet" type="text/css" href="/static/css/vue-multiselect.min.css" media="screen">
<script src="/static/js/vue-multiselect.min.js"></script>
<script src="/static/js/picker-range.js"></script>
<script>
    //searchform 可以由网页自定义.如果没有定义,那么默认搜索框是关闭的
    if(typeof searchform === 'undefined')
    {
        searchform =false;
    }
    //selectfields 页面上下拉框的字段名称
    if(typeof selectfields === 'undefined')
    {
        selectfields =[];
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
    var watchedObject=[];
    var <?=$this::vueel()?> =new Vue({
        components: {
            Multiselect: window.VueMultiselect.default,
            datepicker:datepicker
        },
        data: {
            //请求页面模型
            requestmodel:requestmodel,
            //ajax接受到的结果集
            alldata: alldata,
            //正在请求改变字段锁
            editinglock:false,
            //自增id
            openeditflag:"",
            //字段名称
            openedittagname:"",
            openeditiitem:"",
            tmpindex: 0,
            modelname: modelname,
            reloadfield:reloadfield,
            //是否展开搜索框
            searchform:searchform,
            draggable:draggable
        },
        watch:{
            //如果搜索框有改动，那么刷新数据
            "requestmodel": {
                handler:function(newVal, oldVal) {
                    this.requestmodelaction();
                },
                deep: true
            }
        },
        methods: {
                addTag:function(newTag) {
                    eval('model=this.alldata.'+this.modelname);
                    model[this.tmpindex][this.openedittagname].push(newTag)
                },

                //请求页面接口新数据
                requestmodelaction: function () {
                    this.openedittagname = '';
                    //发送数据,查询内容
                    $.ajax({
                        dataType: "json",
                        method: "GET",
                        url: '<?=$this->getUrl()?>',
                        data: this.requestmodel,
                        async:false,
                        success: function (result) {
                            <?=$this::vueel()?>. $data.alldata = result;

                            //管辖之内,数据变动，提交上传
                            eval('watchmodel={object:<?=$this::vueel()?>.$data.alldata.'+modelname+',name:"'+modelname+'"}');
                            eval('watchmodeled={object:<?=$this::vueel()?>.$data.alldata.'+modelname+'ed,name:"'+modelname+'ed"}');
                            [watchmodel,watchmodeled].forEach(function(watchmodelItem,itemindex) {
                                watchmodelItem.object.forEach(function (item,index) {
                                    //之前已经绑定了，不需要再绑定监听
                                    if(watchedObject[watchmodelItem.name+'@'+index] == true)
                                    {
                                        //console.log(watchmodelItem.name+'@'+index+"之前已经监听过了");
                                        return;
                                    }
                                    //标记已经监听
                                    watchedObject[watchmodelItem.name+'@'+index]=true;
                                    for (var tagname in item) {
                                        var itamvalue=item[tagname];
                                        //如果是外关联别的表格，那么在本表写入格式的明文的json字符串
                                        if($.inArray(tagname,Field2tables) != -1)
                                        {
                                            if(itamvalue[0]=='[')
                                                itamvalue=JSON.parse(itamvalue);
                                            else
                                                itamvalue=[];
                                        }
                                        //绑定操作
                                        <?=$this::vueel()?>.$watch('alldata.'+watchmodelItem.name+'.'+index+"."+tagname,function (newVal, oldVal) {
                                            //console.log("有数据发生改变.");
                                            //如果没标志要修改的字段名字。退出.
                                            if(!this.openedittagname)
                                            {
                                                //console.log("没有指明标记的标签名字.");
                                                return false;
                                            }
                                            if(typeof newVal =='object')
                                            {
                                                newVal=JSON.stringify(newVal);
                                            }
                                            console.log("锁住")
                                            this.editinglock=true;
                                            //发送数据,编辑当前字段的值
                                            $.ajax({
                                                dataType: "json",
                                                method: "POST",
                                                url: '<?=$this->getEditAjaxUrl()?>',
                                                data: {
                                                    'id':this.openeditflag,
                                                    'name':this.openedittagname,
                                                    'value':encodeURIComponent(newVal)
                                                },
                                                success: function (result) {
                                                    name=<?=$this::vueel()?>.$data.openedittagname;
                                                    console.log("更新数据接口完毕.");
                                                    //指定的字段，会刷新页面内容
                                                    if($.inArray(name,<?=$this::vueel()?>.$data.reloadfield) != -1)
                                                    {
                                                        //取消字段的编辑
                                                        <?=$this::vueel()?>.$data.openedittagname='';
                                                        console.log("动态刷新.");
                                                        <?=$this::vueel()?>.requestmodelaction();
                                                    }
                                                    //下拉框的修改会提示修改成功
                                                    if($.inArray(name,selectfields) != -1)
                                                    {
                                                        ajaxSuccess(result,<?=$this::vueel()?>.$data.openeditiitem);
                                                    }
                                                    <?=$this::vueel()?>.$data.editinglock = false;
                                                },
                                                error:function (XMLHttpRequest,textStatus) {
                                                    ajaxError(textStatus,<?=$this::vueel()?>.$data.openeditiitem);
                                                    <?=$this::vueel()?>.$data.editinglock = false;
                                                }
                                            });
                                        });
                                    }
                                })
                            });

                        }
                    });
                },
                //以下是分页条
                pageBar:function (pageid) {
                    this.requestmodel.pageID=pageid;
                },

                //以下是点击编辑的切换状态
                openedit:function (id,index,item,tagname) {
                    if(this.openeditflag == id && this.openedittagname == tagname)
                    {
                        return;
                    }
                    console.log('标记编辑名字:'+tagname);
                    if(this.editinglock)
                    {
                        console.log('上个字段还么释放');
                        return false;
                    }
                    this.openeditflag = id;
                    this.tmpindex = index;
                    this.openeditiitem = item;
                    this.openedittagname = tagname;
                },
                closeedit:function () {
                    if(this.editinglock)
                        return false;
                    console.log("取消了编辑:"+this.openedittagname);
                    this.tmpindex = '';
                    this.openeditflag = '';
                    this.openedittagname = '';
                },
                // 以下是表格拖的功能 index:被压元素的坑
                drop: function (index, event) {
                    //取消字段的编辑
                    <?=$this::vueel()?>.$data.openedittagname='';
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
                                <?=$this::vueel()?>.requestmodelaction();
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
    <?=$this::vueel()?>.requestmodelaction();

</script>