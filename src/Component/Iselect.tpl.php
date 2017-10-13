<?php /** @var  \xltxlm\h5skin\component\Iselect $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>

<script type="text/x-template" id="i-select2">
    <div style="width: 250px;">
        <span :value="this.value"></span>
        <multiselect
                v-model="this.value"
                @input="updateValue(this.value)"
                :key="this.id"
                :id="this.id"
                :options='this.option'
                multiple
                :taggable="this.addTag"
                @tag="addTag"
                :close-on-select="false"
                :hide-selected="true"
                :max="5"
                placeholder="请选择"
                @remove="remove"
        >
        </multiselect>
    </div>
</script>
<script type="application/javascript">
    Vue.component('iselect2', {
        template: "#i-select2",
        components: {
            Multiselect: window.VueMultiselect.default
        },
        data:function () {
            return  {
                loading:false
            }
        },
        props: [
            'addTag',
            'taggable',
            'name',
            'value',
            "id",
            'option'
        ],
        methods: {
            updateValue: function (value) {
                newvalue=JSON.stringify(value);
                $.ajax({
                    dataType: "json",
                    method: "POST",
                    context:this,
                    url: '<?=$this->getAjaxEditUrl()?>',
                    data: {
                        'id':this.id,
                        'name':this.name,
                        'value':newvalue
                    },
                    success: function (result) {
                        // 通过 input 事件发出数值
                        this.$emit('input', value);
                        this.$data.loading=false;
                    }
                });
            },
            remove:function (removedOption, id) {
                var index = this.value.indexOf(removedOption);
                if(index > -1)
                {
                    this.value.splice(this.value, 1);
                }
            },
            addTag:function(newTag) {
                this.value.push(newTag)
                this.updateValue(this.value);
            }
        }

    });
</script>

<script type="text/x-template" id="c-<?=$vueid?>">
    <div>
        <span :value="this.value"></span>
        <span v-if="this.edit">
            <!--     人工开启编辑的情况下       -->
            <span v-if="this.tag || this.multiple || editing==true">
                <span v-if="!this.tag"  >
                    <input type="hidden" :id="'hidden_select_'+ this.id + this.name"  >
                    <i-select style="width: 250px" :key="this.id+this.name" v-model="this.value" filterable clearable :multiple="this.multiple" @on-change="updateValue">
                        <i-option v-for='(item,index) in this.option' :value="item.value"    v-text="item.label"></i-option>
                    </i-select>
                </span>
                <iselect2 v-else v-model="this.value" :addTag="this.addTag" :taggable="this.tag" :id="this.id" :key="this.id+this.name" :name="this.name"  :option='this.optionvalues' @on-change="updateValue"></iselect2>
                <br><a href="javascript:void(0)" @click="editing=false;">只读</a>
            </span>
            <!--     默认情况下，关闭编辑       -->
            <span v-else>
                <span v-if="!this.multiple"  ><span v-text="this.value"></span></span>
                <span v-else>
                    <span v-if="this.tag" v-text="this.value"></span>
                    <span v-else >
                        <ul>
                            <li v-for='(item,index) in this.option' v-if="$.inArray(item.value,value)!=-1"  v-text="item.label"></li>
                        </ul>
                    </span>
                </span>
                <br><a href="javascript:void(0)" @click="editing=true;">编辑</a>
            </span>
        </span>
        <span v-else v-text="this.value"></span>
    </div>
</script>

<script type="application/javascript">
    Vue.component("iselect",
        {
            template:"#c-<?=$vueid?>",
            data:function()
            {
                return {
                    editing:false,
                    //只有初始化成功之后，才能有触发修改的动作
                    initValuedo:[],
                    loading:false
                };
            },
            updated: function () {
                this.initValue();
            },
            props:[
                'addTag',
                'tag',
                'multiple',
                'optionvalues',
                'option',
                'edit',
                'ajaxurl',
                'id',
                'name',
                'value'
            ],
            watch: {
                id:function () {
                    this.editing = false;
                }
            },
            methods: {
                initValue:function () {
                    if(this.multiple) {
                        $('#hidden_select_' + this.id + this.name).val(JSON.stringify(this.value));
                    }
                    else
                    {
                        $('#hidden_select_' + this.id + this.name).val(this.value);
                    }
                    this.initValuedo[this.id]=true;
                },
                updateValue: function (value) {
                    if(!this.initValuedo[this.id])
                    {
                        return false;
                    }
                    //如果没有修改，那么不要提交
                    if(this.multiple)
                    {
                        if(JSON.stringify(value) == $('#hidden_select_'+this.id + this.name).val())
                        {
                            return false;
                        }
                    }
                    else {
                        if (value == this.value) {
                            return false;
                        }
                    }
                    this.value=value;
                    //this.$data.loading=true;
                    //发送数据,编辑当前字段的值
                    if(this.multiple)
                    {
                        newvalue=JSON.stringify(value);
                    }
                    else
                    {
                        newvalue=value;
                    }
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        context:this,
                        url: '<?=$this->getAjaxEditUrl()?>',
                        data: {
                            'id':this.id,
                            'name':this.name,
                            'value':newvalue
                        },
                        success: function (result) {
                            // 通过 input 事件发出数值
                            this.$data.loading=false;
                            if(!this.multiple)
                            {
                                this.$data.editing=false;
                            }
                            ajaxSuccess(result);
                            this.initValue();
                        },
                        error:function()
                        {
                            notyf.alert("修改失败!");
                            this.$data.loading=false;
                        }
                    });
                }
            }
        }
    );

</script>
<?php } ?>

<iselect <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" :id="<?=$this->getId()?>" name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" :option='<?=$this->getOption()?>' :multiple="<?=$this->isMultiple()?'true':'false'?>" :addTag="<?=$this->isAddTag()?'true':'false'?>" :tag="<?=$this->isTag()?'true':'false'?>" :optionvalues='<?=$this->getOptionValues()?>' ></iselect>
