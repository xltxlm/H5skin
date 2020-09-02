<?php /** @var  \xltxlm\h5skin\Traits\VueLink $this */ ?>

<script>
    if (typeof viewform === 'undefined') {
        viewform = [];
    }
    if (typeof created === 'undefined') {
        var created = function () {
        };
    }
    //selectfields 页面上下拉框的字段名称
    if (typeof selectfields === 'undefined') {
        selectfields = [];
    }
    //draggable 是否可以拖拽排序
    if (typeof draggable === 'undefined') {
        draggable = false;
    }
    //modelname 当前项目的模型名称
    if (typeof modelname == 'undefined') {
        modelname = '';
    }
    Vue.use(VueLazyload);
    var Vuemixin = {
        data: function () {
            return {
                //当前正在处理的行数据
                currentitem: {},
                //点击某个字段，需要展开的对应下级表格
                showSubTable: [],
                //用来标注一个事情是否正在存在
                set: new Set(),
                //当前正处在搜索的字段
                searchfield: '',
                //画图表采用的配置
                chartDatacolumns_date: "",
                chartDatacolumns_more: [],
                chartData: {
                    columns: [],
                    rows: []
                },
                //求和饼图对比
                chartDatapie: {
                    columns: [],
                    rows: []
                },
                //第一指标对比
                newchartDatapie: {
                    columns: [],
                    rows: []
                },
                chartSettings: {},
                chartSettingspie: {
                    metrics: 'data',
                    dataType: 'KMB'
                },
                //数据项查看控制面板
                viewformshow: false,
                viewform: viewform,
                //请求页面模型
                requestmodel: requestmodel,
                //ajax接受到的结果集
                alldata: alldata,
                //自增id的值
                openeditflag: "",
                //正在编辑的字段名称
                openedittagname: "",
                openeditiitem: "",
                tmpindex: 0,
                modelname: modelname,
                draggable: draggable,
                requestinit: false
            }
        },
        created: function () {
            console.log(['created','this.requestmodelaction']);
            this.requestmodelaction();
        },
        updated: function () {
            this.$nextTick(function () {
                //刷新显示逻辑
                created(this);
                //页面加载完毕之后，发出iframe高度调整消息
                var info = {
                    message: "来自updated，发出的高度调整消息，scrollHeight："+document.body.scrollHeight+"，clientHeight："+document.body.clientHeight,
                    height: Math.max(document.body.scrollHeight, document.body.clientHeight),
                    url: window.location.href,
                };
                window.parent.postMessage(info, '*');
            });
        },
        methods: {
            //切换开关
            showSubTableChange: function (名称) {
                索引 = this.showSubTable.indexOf(名称);
                在数组里面 = (索引 != -1);
                if (在数组里面) {
                    this.showSubTable.splice(索引, 1);
                } else {
                    this.showSubTable.push(名称);
                }
            },
            //批量提交操作
            batch: function (name, newvalue, defaultvalue) {
                eval('model=this.alldata.' + this.modelname);
                model.forEach(function (item, index) {
                    oldvalue = item[name];
                    if ($.inArray(oldvalue, defaultvalue) != -1) {
                        //发送数据,编辑当前字段的值
                        $.ajax({
                            dataType: "json",
                            method: "POST",
                            async: true,
                            context: this,
                            url: '<?=$this->getEditAjaxUrl()?>',
                            data: {
                                'id': item.id,
                                'name': name,
                                'value': encodeURIComponent(newvalue)
                            },
                            success: function (result) {
                                ajaxSuccess(result);
                            }
                        });
                        item[name] = newvalue;

                    }
                });
                console.log(['batch','this.requestmodelaction']);
                this.requestmodelaction();
            },

            //请求页面接口新数据
            requestmodelaction: function () {
                //发送数据,查询内容
                $.ajax({
                    dataType: "json",
                    method: "GET",
                    url: '<?=$this->getUrl()?>',
                    data: $.paramfix(this.requestmodel),
                    context: this,
                    //没有初始化之前，第一次采用异步方式加载数据，加快速度
                    async: !this.requestinit,
                    success: function (result) {
                        this.alldata = result;
                        eval('model=this.alldata.' + this.modelname);
                        if(model.length<=1){//👈👈---- 如果结果只有一条数据，那么不需要进行拖拽
                            this.draggable=false;
                        }
                        this.requestinit = true;
                    }
                });
            },
            //修改了分页条的数目
            page: function (pageID) {
                this.alldata.pageObject.pageID = pageID;
                this.requestmodel.pageID = pageID;
            },
            //修改了每页展示的条目
            pagesize: function (pagesize) {
                this.requestmodel.prepage = pagesize;
            },
            /**
             * 动态新增数据,然后动态刷新内容
             */
            addnewalldata: function (url) {
                $.ajax({
                    dataType: "json",
                    method: "POST",
                    url: url,
                    data: this.requestmodel,
                    async: false,
                    context: this,
                    success: function (result) {
                        console.log(['addnewalldata','this.requestmodelaction']);
                        this.requestmodelaction();
                        ajaxSuccess(result, this.openeditiitem);
                    }
                });
            },
            // 以下是表格拖的功能 index:被压元素的坑
            drop: function (index, event) {
                if (this.draggable == false)
                    return false;
                //取消字段的编辑
                eval('model=this.alldata.' + this.modelname);
                $.ajax({
                    dataType: "json",
                    method: "POST",
                    url: '<?=$this->getDragAjaxUrl()?>',
                    async: false,
                    data: {
                        'from': model[this.tmpindex],
                        'to': model[index]
                    },
                    context: this,
                    success: function (result) {
                        console.log(['drop','this.requestmodelaction']);
                        this.requestmodelaction();
                        ajaxSuccess(result, this.openeditiitem);
                    },
                    error: function (XMLHttpRequest, textStatus) {
                        ajaxError(textStatus, this.openeditiitem)
                    }
                });
            },
            dragover: function (event) {
                if (this.draggable == false)
                    return false;
                event.preventDefault();
            },
            dragstart: function (index, event) {
                if (this.draggable == false)
                    return false;
                this.tmpindex = index;
            },
            //数据统计的直接对比
            compardirect: function (name) {
                this.compardelete(name);
                this.set.add('compar' + name + 'direct');
                eval('model=this.alldata.' + this.modelname);
                var length = model.length;
                for (index in model) {
                    try {
                        if (index < length - 1) {
                            index2 = 1 + parseInt(index);
                            eval('var me = parseInt(model[index].' + name + ')');
                            eval('var to = parseInt(model[index2].' + name + ')');
                            ratio = ((me - to) / to * 100).toString();
                            ratio = ratio.substr(0, ratio.indexOf(".") + 3);
                            if (to > me) {
                                eval('model[index].' + name + '=\"<font color=red>' + me + '(' + ratio + '%)</font>\"');
                            } else {
                                eval('model[index].' + name + '=\"<font color=green>' + me + '(' + ratio + '%)</font>\"');
                            }
                        }
                    } catch (e) {
                        console.log(e.message)
                    }
                }
            },
            compardelete: function (name) {
                this.set.delete('compar' + name + 'direct');
                this.set.delete('compar' + name + '-1 day');
                this.set.delete('compar' + name + '-2 day');
                this.set.delete('compar' + name + '-1 week');
                this.set.delete('compar' + name + '-1 month');
            },
            //数据统计的服务端对比
            compar: function (name, frequency) {
                this.compardelete(name);
                //取消掉标注
                if (frequency != '') {
                    this.set.add('compar' + name + frequency)
                }
                eval('model=this.alldata.' + this.modelname);
                for (index in model) {
                    var data = {
                        name: name,
                        day: frequency,
                        index: index,
                        item: model[index]
                    };
                    $.ajax({
                        context: {
                            request: data,
                            model: model
                        },
                        dataType: "json",
                        method: "POST",
                        url: '<?=$this->getUrl()?>Compar',
                        data: data,
                        async: true,
                        success: function (result) {
                            if (result.value) {
                                eval('this.model[this.request.index].' + this.request.name + '=result.value');
                            }
                        }
                    });
                }
            }
        }
    };

</script>