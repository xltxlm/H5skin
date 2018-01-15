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
            <RadioGroup :key="this.id+this.name" v-if="this.option.length<=7" v-show="!this.loading" v-model="this.value" @on-change="updateValue" :vertical="vertical">
                <Radio v-for="(item,index) in this.option" :label="item" :class="{ 'badge bg-green':  value == item && value == greenvalue, 'badge bg-red': value == item && value == redvalue }"></Radio>
            </RadioGroup>
            <select v-else :key="this.id+this.name" v-show="!this.loading" v-model="this.value" size="6" @input="updateValue($event.target.value)">
                <option v-for="(item,index) in this.option" :value="item" v-text="item"></option>
            </select>
        </span>
        <span v-else :class="{ 'badge bg-green':this.value && this.value==this.greenvalue, 'badge bg-red':this.value && this.value==this.redvalue }" >
            <span v-if="this.showfield" v-html="eval(this.name+'(value,this.item);')"></span>
            <span v-else v-text="value"></span>
        </span>
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
                'vertical',
                'option',
                'edit',
                'item',
                'showfield',
                'ajaxurl',
                'id',
                'name',
                'value',
                'greenvalue',
                'redvalue'
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
                    this.$data.loading=true;
                    //发送数据,编辑当前字段的值
                    $.ajax({
                        dataType: "json",
                        method: "POST",
                        context:this,
                        url: this.ajaxurl,
                        data: {
                            'id':this.id,
                            'name':this.name,
                            'value':encodeURIComponent(value),
                            //需要附加的字段
                            'moredata':window.moredata
                        },
                        success: function (result) {
                            // 通过 input 事件发出数值
                            this.$emit('input', value);
                            //通知外部：本控件的值被修改了
                            vueel.$emit(this.name+'change', this.item,value,this.value);
                            this.$data.loading=false;
                            ajaxSuccess(result);
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

<?php } if($this->isInit()){ return false;}?>

<iradio <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>"  <?php if($this->isEdit()){?>:id="<?=$this->getId()?>"<?php }?>  name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" :showfield="<?=$this->isShowfield()?'true':'false'?>"  <?php if($this->getItem()){?>:item="<?=$this->getItem()?>"<?php }?> :option='<?=$this->getOption()?>' :vertical='<?=$this->isVertical()?'true':'false'?>'  greenvalue="<?=$this->getGreenvalue()?>"  redvalue="<?=$this->getRedvalue()?>"></iradio>
