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
    Vue.use(VueLazyload);
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
            //求和饼图对比
            chartDatapie:{
                columns: [],
                rows: [
                ]
            },
            //第一指标对比
            newchartDatapie:{
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
                        var model=this.alldata[this.modelname];
                        this.chartData.rows=[];
                        this.chartDatapie.rows=[];
                        this.newchartDatapie.columns=this.chartData.columns;
                        for (model_index in model)
                        {
                            this.chartData.rows[model_index]={};
                            for(columns_index in this.chartData.columns)
                            {
                                //第一个指标，代表的是横轴
                                if(columns_index==0)
                                {
                                    eval('var chartDatacolumns_value=model[model_index].'+this.chartData.columns[columns_index]);
                                    this.newchartDatapie.rows[model_index]={};
                                    this.newchartDatapie.rows[model_index][this.chartData.columns[columns_index]]=model[model_index][this.chartData.columns[columns_index]];
                                }
                                else
                                {
                                    if(typeof  this.chartDatapie.rows[columns_index-1] =='undefined' )
                                    {
                                        this.chartDatapie.rows[columns_index-1]={};
                                        eval('this.chartDatapie.rows[columns_index-1].'+this.chartData.columns[0]+'="'+this.chartData.columns[columns_index]+'"')
                                    }
                                    eval('var chartDatacolumns_value=parseFloat(model[model_index].'+this.chartData.columns[columns_index]+')');
                                    //饼图对比，只针对第一个指标，多余的指标采用求和对比
                                    if(columns_index==1)
                                    {
                                        this.newchartDatapie.rows[model_index]['data']=chartDatacolumns_value;
                                    }
                                    //坑爹的数学计算
                                    if(model_index==0)
                                    {
                                        eval('this.chartDatapie.rows[columns_index-1].data=chartDatacolumns_value')
                                    }else
                                    {
                                        eval('this.chartDatapie.rows[columns_index-1].data+=chartDatacolumns_value')
                                    }
                                }
                                eval('this.chartData.rows[model_index].'+this.chartData.columns[columns_index]+'=chartDatacolumns_value')
                            }
                        }
                        //倒序排列下
                        this.chartData.rows.sort(function(a, b){
                            var a1= eval('a.'+<?=$this::vueel()?>.$data.chartDatacolumns_date), b1= eval('b.'+<?=$this::vueel()?>.$data.chartDatacolumns_date);
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
                        if($.inArray(oldvalue,defaultvalue)!=-1)
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