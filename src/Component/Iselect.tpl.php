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
                :id="this.id"
                :options='this.option'
                multiple
                :taggable="true"
                @tag="addTag"
                :close-on-select="false"
                :hide-selected="true"
                :max="5"
                placeholder="请选择"
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
            <i-select v-if="!this.tag" v-model="this.value" filterable clearable :multiple="this.multiple" @on-change="updateValue">
                <i-option v-for='(item,index) in this.option' :value="item.value" :key="item.value" v-text="item.label"></i-option>
            </i-select>
            <iselect2 v-else v-model="this.value" :id="this.id"  :name="this.name"  :option='this.optionvalues' @on-change="updateValue"></iselect2>
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
                    loading:false
                };
            },
            props:[
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
            methods: {
                updateValue: function (value) {
                    //如果没有修改，那么不要提交
                    if(value == this.value)
                    {
                        return false;
                    }
                    //this.$data.loading=true;
                    //发送数据,编辑当前字段的值
                    if(this.multiple)
                        newvalue=JSON.stringify(value);
                    else
                        newvalue=value;
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
                            ajaxSuccess(result);
                        }
                    });
                }
            }
        }
    );

</script>
<?php } ?>

<iselect <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" :id="<?=$this->getId()?>" name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" :option='<?=$this->getOption()?>' :multiple="<?=$this->isMultiple()?'true':'false'?>" :tag="<?=$this->isTag()?'true':'false'?>" :optionvalues='<?=$this->getOptionValues()?>' ></iselect>
