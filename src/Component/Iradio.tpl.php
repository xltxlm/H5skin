<?php /** @var \xltxlm\h5skin\component\Iradio $this */
if(!defined(__FILE__))
{
$vueid=md5(get_class($this));
define(__FILE__,true);
?>

<script type="text/x-template" id="c-<?=$vueid?>">
    <div>
        <span v-if="this.edit">
            <Spin v-show="this.loading" size="large"></Spin>
            <RadioGroup v-if="this.option.length<=6" v-show="!this.loading" v-model="this.value" @on-change="updateValue" vertical>
                <Radio v-for="(item,index) in this.option" :label="item"></Radio>
            </RadioGroup>
            <select v-else v-show="!this.loading" v-model="this.value" size="6" @input="updateValue($event.target.value)">
                <option v-for="(item,index) in this.option" :value="item" v-text="item"></option>
            </select>
        </span>
        <span v-else v-text="this.value"></span>
    </div>
</script>

<script type="application/javascript">
    Vue.component("iradio",
        {
            template:"#c-<?=$vueid?>",
            data:function()
            {
                return {
                    loading:false
                };
            },
            props:[
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
                    if($.inArray(value ,this.option)==-1)
                    {
                        return false;
                    }
                    //this.$data.loading=true;
                    //发送数据,编辑当前字段的值
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        context:this,
                        url: '<?=$this->getAjaxEditUrl()?>',
                        data: {
                            'id':this.id,
                            'name':this.name,
                            'value':encodeURIComponent(value)
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

<iradio <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" :id="<?=$this->getId()?>" name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" :option='<?=$this->getOption()?>'></iradio>
