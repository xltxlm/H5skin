<?php /** @var \xltxlm\h5skin\component\Idate $this */
if(!defined(__FILE__))
{
    $vueid=md5(get_class($this));
    define(__FILE__,true);
?>
<script type="text/x-template" id="c-<?=$vueid?>">
    <div>
        <input :id="'c-<?=$vueid?>-'+this.name" type="hidden" :name="this.name" value="">
        <span v-if="edit">
            <Date-picker v-if="fulldate" type="datetime" format="yyyy-MM-dd HH:mm"  v-model="this.value"  @input="updateValue"    ></Date-picker>
            <Date-picker v-else type="datetime" format="yyyy-MM-dd"  v-model="this.value" @input="updateValue" ></Date-picker>
        </span>
        <span v-else >
            <span :title="this.value" v-if="timeago" v-html="window.timeago(null, 'zh_CN').format(this.value)"></span>
            <span :title="this.value" v-else v-text="this.value"></span>
        </span>
    </div>
</script>
<script type="application/javascript">
    Vue.component("idate",
        {
            template:"#c-<?=$vueid?>",
            props:[
                'timeago',
                'edit',
                'fulldate',
                'ajaxurl',
                'id',
                'name',
                'value'
            ],
            methods: {
                updateValue: function () {
                    $('c-<?=$vueid?>-'+this.name).val(this.value);
                    this.$emit('input', this.value);
                }
            }
        }
    );
</script>
<?php } ?>

<idate <?php if($this->getModel()){?>v-model="<?=$this->getModel()?>"<?php }?> ajaxurl="<?=$this->getAjaxEditUrl()?>" <?php if($this->isEdit()){?>:id="<?=$this->getId()?>"<?php }?> name="<?=$this->getName()?>" :edit="<?=$this->isEdit()?'true':'false'?>" :fulldate="<?=$this->isFulldate()?'true':'false'?>" :timeago="<?=$this->isTimeAgo()?'true':'false'?>" ></idate>
