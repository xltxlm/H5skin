<?php /** @var  \xltxlm\h5skin\Traits\VueLink $this */
use xltxlm\h5skin\Request\UserCookieModelCopy; ?>

<script src="/static/js/picker-range.js"></script>
<script>
    if(typeof viewform === 'undefined')
    {
        viewform =[];
    }
    //同期对比
    if(requestmodel.sametime == '')
    {
        requestmodel.sametime =false;
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
        data: {
            //用来标注一个事情是否正在存在
            set:new Set(),
            searchfield:'',
            //画图表采用的配置
            chartDatacolumns_date:"",
            chartDatacolumns_more:[],
            chartData:{
                columns: [],
                rows: [
                ]
            },
            chartDatapie:{
                columns: [],
                rows: [
                ]
            },
            chartSettings:{},
            chartSettingspie:{
                metrics: 'data',
                dataType: 'KMB'
            },
            //数据项查看控制面板
            viewformshow:false,
            viewform:viewform,
            //请求页面模型
            requestmodel:requestmodel,
            //ajax接受到的结果集
            alldata: alldata,
            //正在请求改变字段锁
            editinglock:false,
            //自增id的值
            openeditflag:"",
            //字段名称
            openedittagname:"",
            openeditiitem:"",
            tmpindex: 0,
            modelname: modelname,
            //修改之后，会导致页面数据刷新的字段
            reloadfield:reloadfield,
            draggable:draggable,
            __init:false
        },
        watch:{
            "chartDatacolumns_date":{
                handler:function(newVal, oldVal) {
                    this.chartData.columns[0]=newVal;
                    this.chartDatapie.columns[0]=newVal;
                    this.vchart();
                }
            },
            "chartDatacolumns_more":{
                handler:function(newVal, oldVal) {
                    if(this.chartDatacolumns_date=="")
                        return;
                    this.chartData.columns=[];
                    this.chartData.columns=[].concat([this.chartDatacolumns_date]);
                    for (index in newVal)
                    {
                        this.chartData.columns=this.chartData.columns.concat([newVal[index]]);
                    }
                    this.chartDatapie.columns=this.chartData.columns;
                    this.vchart();
                }
            }
        },
        methods: {
                vchart:function () {
                    try {
                        //修改数据值
                        eval('model=this.alldata.'+this.modelname);
                        this.chartData.rows=[];
                        this.chartDatapie.rows=[];
                        for (index in model)
                        {
                            this.chartData.rows[index]={};
                            for(index1 in this.chartData.columns)
                            {
                                if(index1==0)
                                {
                                    eval('var chartDatacolumns_value=model[index].'+this.chartData.columns[index1]);
                                }
                                else
                                {
                                    if(typeof  this.chartDatapie.rows[index1-1] =='undefined' )
                                    {
                                        this.chartDatapie.rows[index1-1]={};
                                        eval('this.chartDatapie.rows[index1-1].'+this.chartData.columns[0]+'="'+this.chartData.columns[index1]+'"')
                                    }
                                    eval('var chartDatacolumns_value=parseFloat(model[index].'+this.chartData.columns[index1]+')');
                                    //坑爹的数学计算
                                    if(index==0)
                                    {
                                        eval('this.chartDatapie.rows[index1-1].data=chartDatacolumns_value')
                                    }else
                                    {
                                        eval('this.chartDatapie.rows[index1-1].data+=chartDatacolumns_value')
                                    }
                                }
                                eval('this.chartData.rows[index].'+this.chartData.columns[index1]+'=chartDatacolumns_value')

                            }
                        }

                        //倒序排列下
                        this.chartData.rows.sort(function(a, b){
                            //console.log([a,b])
                            var a1= eval('a.'+<?=$this::vueel()?>.$data.chartDatacolumns_date), b1= eval('b.'+<?=$this::vueel()?>.$data.chartDatacolumns_date);
                            //console.log([a1,b1])
                            if(a1== b1) return 0;
                            return a1> b1? 1: -1;
                        });
                    }catch (e)
                    {
                        console.log(e)
                    }
                },
                batch:function (name,newvalue,defaultvalue) {
                    //情场，别的不能处理
                    this.openedittagname="";
                    console.log("设置修改字段名字："+this.openedittagname);
                    eval('model=this.alldata.'+this.modelname);
                    model.forEach(function (item,index) {
                        eval('oldvalue=item.'+name);
                        if(oldvalue==defaultvalue)
                        {
                             //发送数据,编辑当前字段的值
                            $.ajax({
                                dataType: "json",
                                method: "POST",
                                async:false,
                                url: '<?=$this->getEditAjaxUrl()?>',
                                data: {
                                    'id':item.id,
                                    'name':name,
                                    'value':encodeURIComponent(newvalue)
                                }
                            });
                            eval('item.'+name+'="'+newvalue+'"');
                        }
                    });
                    this.requestmodelaction();
                },
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
                            <?=$this::vueel()?>.$data.alldata = result;
                            //顺带刷新图表
                            <?=$this::vueel()?>.vchart();
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
                                        <?=$this::vueel()?>.$watch('alldata.'+watchmodelItem.name+'.'+index+"."+tagname,function (newVal, oldVal,abcc) {
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
                                            //纠正日期格式
                                            if(newVal.indexOf('"')!=-1 && newVal.indexOf('000Z')!=-1)
                                            {
                                                newVal=newVal.replace(/"/g,"");
                                                var a=(new Date(newVal));
                                                newVal=(a.getFullYear()+"-"+(a.getMonth()+1)+"-"+a.getDate()+" "+a.getHours()+":"+a.getMinutes()+":"+a.getSeconds());
                                            }

                                            //console.log("锁住")
                                            this.editinglock=true;
                                            ajaxdata={
                                                'id':this.openeditflag,
                                                'name':this.openedittagname,
                                                'value':encodeURIComponent(newVal)
                                            };

                                            //发送数据,编辑当前字段的值
                                            $.ajax({
                                                dataType: "json",
                                                method: "POST",
                                                url: '<?=$this->getEditAjaxUrl()?>',
                                                data: ajaxdata,
                                                success: function (result) {
                                                    name=<?=$this::vueel()?>.$data.openedittagname;
                                                    //console.log("更新数据接口完毕.");
                                                    //指定的字段，会刷新页面内容
                                                    if($.inArray(name,<?=$this::vueel()?>.$data.reloadfield) != -1)
                                                    {
                                                        //取消字段的编辑
                                                        <?=$this::vueel()?>.$data.openedittagname='';
                                                        //console.log("动态刷新.");
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
                            <?=$this::vueel()?>.$data.__init = true;
                        }
                    });
                },
                //修改了分页条的数目
                page:function (pageID) {
                    this.alldata.pageObject.pageID=pageID;
                    this.requestmodel.pageID=pageID;
                },
                //修改了每页展示的条目
                pagesize:function(pagesize)
                {
                    this.requestmodel.prepage=pagesize;
                },
                /**
                 * 动态新增数据,然后动态刷新内容
                 */
                addnewalldata:function (url)
                {
                    $.ajax({
                        dataType: "json",
                        method: "GET",
                        url:url,
                        data:this.requestmodel,
                        async:false,
                        success: function (result) {
                            <?=$this::vueel()?>.requestmodelaction();
                            ajaxSuccess(result,<?=$this::vueel()?>.$data.openeditiitem);
                        }
                    });
                },
                //以下是点击编辑的切换状态
                openedit:function (id,index,item,tagname) {
                    if(this.openeditflag == id && this.openedittagname == tagname)
                    {
                        return;
                    }
                    //console.log('标记编辑名字:'+tagname);
                    if(this.editinglock)
                    {
                        //console.log('上个字段还么释放');
                        return false;
                    }
                    this.openeditflag = id;
                    this.tmpindex = index;
                    this.openeditiitem = item;
                    this.openedittagname = tagname;
                },
                closeedit:function () {
                    if(this.editinglock)
                    {
                        return false;
                    }
                    this.tmpindex = '';
                    this.openeditflag = '';
                    this.openedittagname = '';
                },
                // 以下是表格拖的功能 index:被压元素的坑
                drop: function (index, event) {
                    if(this.draggable==false)
                        return false;
                    //取消字段的编辑
                    <?=$this::vueel()?>.$data.openedittagname='';
                    eval('model=this.alldata.'+this.modelname);
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        url: '<?=$this->getDragAjaxUrl()?>',
                        async:false,
                        data:{
                            'from':model[this.tmpindex],
                            'to':model[index]
                        },
                        success: function (result) {
                            <?=$this::vueel()?>.requestmodelaction();
                            ajaxSuccess(result,<?=$this::vueel()?>.$data.openeditiitem);
                        },
                        error:function (XMLHttpRequest,textStatus) {
                            ajaxError(textStatus,<?=$this::vueel()?>.$data.openeditiitem)
                        }
                    });
                },
                dragover: function (event) {
                    if(this.draggable==false)
                        return false;
                    event.preventDefault();
                },
                dragstart: function (index, event) {
                    if(this.draggable==false)
                        return false;
                    this.tmpindex = index;
                },
                //数据统计的直接对比
                compardirect:function (name) {
                    this.compardelete(name);
                    this.set.add('compar'+name+'direct');
                    eval('model=this.alldata.'+this.modelname);
                    var length=model.length;
                    for(index in model)
                    {
                        try{
                            if(index < length-1)
                            {
                                index2=1+ parseInt(index);
                                eval('var me = parseInt(model[index].'+name+')');
                                eval('var to = parseInt(model[index2].'+name+')');
                                ratio = ((me-to)/to*100).toString();
                                ratio = ratio.substr(0,ratio.indexOf(".")+3);
                                if(to > me)
                                {
                                    eval('model[index].'+name+'=\"<font color=red>'+me+'('+ratio+'%)</font>\"');
                                }else
                                {
                                    eval('model[index].'+name+'=\"<font color=green>'+me+'('+ratio+'%)</font>\"');
                                }
                            }
                        }catch (e)
                        {
                            console.log(e.message)
                        }
                    }
                },
                //当前页面加入邮件报表里面
                AddPagelist:function(parentid,ctroller_class,search,viewform)
                {
                    $.ajax(
                        {
                            url:"/?c=Pagelist/PagelistInsertDo",
                            async:false,
                            data:{
                                parentid:parentid,
                                ctroller_class:ctroller_class,
                                search:search,
                                viewform:viewform
                            },
                            success: function (result) {
                                window.location.href="/?c=Pagelist/Pagelist&parentid="+parentid
                            }
                        }
                    );
                },
                //添加当前条目到监控系统里面
                addItemAlert:function(pid,name,fieldname,ctroller_class,table_class,pagename)
                {
                    $.ajax(
                        {
                            url:"/?c=Mailalert/MailalertInsertDo",
                            async:false,
                            data:{
                                pid:pid,
                                name:name,
                                fieldname:fieldname,
                                ctroller_class:ctroller_class,
                                table_class:table_class,
                                pagename:pagename
                            },
                            success: function (result) {
                                window.location.href="/?c=Mailalert/Mailalert&status=通过&pid="+pid
                            }
                        }
                    );
                },
                compardelete:function (name) {
                    this.set.delete('compar'+name+'direct');
                    this.set.delete('compar'+name+'-1 day');
                    this.set.delete('compar'+name+'-2 day');
                    this.set.delete('compar'+name+'-1 week');
                    this.set.delete('compar'+name+'-1 month');
                },
                //数据统计的服务端对比
                compar:function (name,frequency) {
                    this.compardelete(name);
                    //取消掉标注
                    if(frequency!='')
                    {
                        this.set.add('compar'+name+frequency)
                    }
                    eval('model=this.alldata.'+this.modelname);
                    for(index in model)
                    {
                        var data={
                            name:name,
                            day:frequency,
                            index:index,
                            item:model[index]
                        };
                        $.ajax({
                            context:{
                                request:data,
                                model:model
                            },
                            dataType: "json",
                            method: "POST",
                            url: '<?=$this->getUrl()?>Compar',
                            data:data,
                            async:true,
                            success: function (result) {
                                if(result.value){
                                    eval('this.model[this.request.index].'+this.request.name+'=result.value');
                                }
                            }
                        });
                    }
                }
            }
        }).$mount("#<?=$this::vueel()?>");

    //拉取数据
    <?=$this::vueel()?>.requestmodelaction();

</script>