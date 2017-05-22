<?php
if (!defined(__FILE__)) {
    ?>
    <!-- Select2 -->
    <link rel="stylesheet" href="/static/css/select2.min.css">
    <script src="/static/js/select2.min.js"></script>
    <script src="/static/js/jquery.sumoselect.min.js"></script>
    <link href="/static/css/sumoselect.css" rel="stylesheet"/>
    <script>
        //多选下拉框
        $(function () {
            //Initialize Select2 Elements
            $(".sumoselect").SumoSelect({search: true, searchText: 'Enter here.', placeholder: '请选择'});
        });
    </script>

    <script type="text/x-template" id="select2-template">
        <select>
            <slot></slot>
        </select>
    </script>


    <script>
        Vue.component('select2', {
            props: ['options', 'value'],
            template: '#select2-template',
            mounted: function () {
                var vm = this;
                $(this.$el)
                    .val(this.value)
                    // init select2
                    .select2({ data: this.options })
                    // emit event on change.
                    .on('change', function () {
                        vm.$emit('input', this.value)
                    })
            },
            watch: {
                value: function (value) {
                    // update value
                    $(this.$el).val(value)
                },
                options: function (options) {
                    // update options
                    $(this.$el).select2({ data: options })
                }
            },
            destroyed: function () {
                $(this.$el).off().select2('destroy')
            }
        });

    </script>

    <?php
    define(__FILE__, true);
}
?>
<?php /** @var \xltxlm\h5skin\SelectTPL $this */ ?>
<select<?=$this->isVue()?'2':''?> <?php if($this->isRequired()){?>required<?php }?> <?=join("  ",$this->getAttr())?> style="font-size:18px;" <?if($this->isQuick()){?>size="<?=count($this->getOptions())?>"<?php }?> class="<?= $this->getClassName() ?> <?= $this->isMultiple() ? 'sumoselect ' : ($this->isSelect2() ? 'select2' : '') ?>"
        name="<?= $this->getName() ?>" <?= $this->getVmodel() ?> <?= $this->getVOnChange() ?> id="<?= $this->getId() ?>"
    <?= $this->isMultiple() ? ' multiple="multiple" ' : '' ?>
        title="<?= $this->getName() ?>">
    <?php $i=0; foreach ($this->getOptions() as $showText => $value) { $i++;?>
        <option value="<?= $value ?>" <?php if ($this->getDefault() == $value){ ?>selected<?php } ?>><?= $showText ?></option>
    <?php } ?>
</select<?=$this->isVue()?'2':''?>>

<?php if(!$this->isVue() && $this->isSelect2()){?>
<script>
    //单选下拉框
    $(function () {
        //Initialize Select2 Elements
        $("<?= $this->getId()?'#'.$this->getId():'' ?> [name=<?= $this->getName() ?>]").select2();
    });
</script>
<?php }?>