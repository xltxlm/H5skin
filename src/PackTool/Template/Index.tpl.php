<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */
$TableName=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>'']);
$TableNameLong=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']);
?>
<<?='?'?>php
/** @var <?=$this->getClassName()?> $this */
use <?=static::$rootNamespce?>\Setting\Page;
use <?=$this->getClassName()?>;
use <?=$this->getClassName()?>Request;
<?php if(strpos($this->getShortName(),'log')!==strlen($this->getShortName())-3){?>
use <?=$this->getClassName()?>log;
use <?=$TableNameLong?>logModel;
<?php }?>
use xltxlm\h5skin\Traits\Timepicker;
use xltxlm\h5skin\Request\UserCookieModelCopy;
<?php if($this->isMakeDelete()){?>use <?=$this->getClassName()?>DeleteDo;<?php }?>

use <?=$TableNameLong?>Type;
use <?=$this->getTableModelClassNameReflectionClass()->getName()?>;
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isEnumFunction=$TableNameLong.'Type::'.$property->getName().'IsEnum();';
    $enum=false;
    eval('$enum='.$isEnumFunction);
    if($enum){
?>
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>;
<?php }}?>
<?php if($this->isExcel()){?>use <?=$this->getClassName()?>Excel;

<?php }?>
use <?=$this->getClassName()?>Ajax;
<?php if($this->isAjaxEdit()){?>
use <?=$this->getClassName()?>AjaxEdit;

<?php }?>
use xltxlm\helper\Hdir\Dir;
use xltxlm\helper\Hclass\ConvertObject;
use xltxlm\h5skin\Traits\PageBarHtml;
use xltxlm\h5skin\SelectTPL;
use xltxlm\h5skin\Traits\DatePicker;
use xltxlm\h5skin\Traits\VueLink;
<?php if($this->isMakeAdd()){?>use <?=$this->getClassName()?>Add;<?php }?>

?>

<div id="<<?='?'?>=VueLink::vueel()?>" >
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php if($this->isMakeAdd()){?><a type="button" class="btn bg-purple margin"
                                                       href="<<?='?'?>= <?=$this->getShortName()?>Add::urlNoFollow() ?>">+添加新数据</a><?php }?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="<<?='?'?>= <?=$this->getShortName()?>::url() ?>" method="post">
                <!--       隐藏的分页条         -->
                <input type="hidden" name="<?='<'?>?=UserCookieModelCopy::pageID()?>" value="<?='<'?>?=$this->getPageObject()->getPageID()?>">
                <div class="box-body">

                    <!--  分页  -->
                    <div class="form-group col-md-1 ">
                        <label   > 分页 </label>
                        <<?='?'?>=(new SelectTPL())
                        ->setOptions([
                        "分页"=>NULL
                        ]+array_combine(range(1,200,30),range(1,200,30))
                        )
                        ->setClassName('form-control')
                        ->setDefault($this->getPageObject()->getPrepage())
                        ->setName('prepage')
                        ->setSelect2(false)
                        ->setVmodel('alldata.pageObject.prepage')
                        ->__invoke()?>
                    </div>

                    <?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
                        if(strpos($property->getName(),'elasticsearch')===0){continue;}
                        $isEnumFunction= $TableNameLong.'Type::'.$property->getName().'IsEnum();';
                        $enum=false;
                        eval('$enum='.$isEnumFunction);

                        $IsIntFunction= $TableNameLong.'Type::'.$property->getName().'IsInt();';
                        $IsInt=false;
                        eval('$IsInt='.$IsIntFunction);

                        ob_start();
                     ?>
                        <<?='?'?>=(new <?=$TableName?>Model)()[<?=$TableName?>Model::<?=$property->getName()?>()]?>
                        <?php  $fieldShowName=trim(ob_get_clean()); ?>


                        <!--  <?=$property->getName()?>  -->
                    <div :class="{'has-error':requestmodel.<?=$property->getName()?>}" class="form-group col-md-1">
                        <label  :class="{'label label-danger':requestmodel.<?=$property->getName()?>}"  for="<?=$property->getName()?>">
                            <?=$fieldShowName?>
                        </label>
                        <?php if($IsInt){?><span class="pull-right">批量查询</span><?php }?>
                    <?php if($enum){?>
                            <<?='?'?>=(new SelectTPL())
                        ->setOptions([
                            "全部"=>NULL
                        ]+Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>::ALL())
                                ->setDefault($this->get<?=$this->getShortName()?>Request()->get<?=ucfirst($property->getName())?>())
                                ->setClassName('form-control')
                                ->setName(<?=$TableName?>Model::<?=$property->getName()?>())
                                ->setVmodel('requestmodel.<?=$property->getName()?>')
                                ->__invoke()?>
                    <?php }else{?>
                                <input title="<?=$fieldShowName?>" type="text"
                                       class="form-control <<?='?'?>php if(<?=$TableName?>Type::<?=$property->getName()?>IsDate()){?><<?='?'?>=DatePicker::daterangepicker()?><<?='?'?>php }?>  <<?='?'?>php if(<?=$TableName?>Type::<?=$property->getName()?>IsTime()){?><<?='?'?>=Timepicker::getTimepickerCss()?><<?='?'?>php }?>"
                                       name="<<?='?'?>= <?=$TableName?>Model::<?=$property->getName()?>() ?>"
                                       <<?='?'?>php if(!<?=$TableName?>Type::<?=$property->getName()?>IsDate()){?>v-model="requestmodel.<?=$property->getName()?>"<<?='?'?>php }else{?>value="<<?='?'?>=$this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>()?>"<<?='?'?>php }?>
                                       id="<<?='?'?>= <?=$TableName?>Model::<?=$property->getName()?>() ?>" placeholder="<<?='?'?>=(new <?=$TableName?>Model)()[<?=$TableName?>Model::<?=$property->getName()?>()]?>">
                    <?php }?>
                    </div>
                    <?php }?>

                    <!--  排序  -->
                    <div class="form-group col-md-1 <<?='?'?>= $this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy() ? 'has-error' : '' ?> ">
                        <label  class="<<?='?'?>= $this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy() ? 'label label-danger' : '' ?>" for="webPageOrderBy">
                            排序依据
                        </label>
                        <<?='?'?> $ALLFields=(new <?=$this->TableModelClassNameReflectionClass->getShortName()?>)()?>
                        <<?='?'?>=(new SelectTPL())
                            ->setOptions([
                                    "排序"=>NULL
                                ]+array_combine(array_values($ALLFields),array_keys($ALLFields)))
                            ->setClassName('form-control')
                            ->setDefault($this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy())
                            ->setName('webPageOrderBy')
                            ->__invoke()?>
                    </div>



                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" id="<?=$buttonid=md5(__LINE__)?>" onclick="var f=$('#<?=$buttonid?>').parents('form'); f.attr('action','<<?='?'?>=<?=$this->getShortName()?>::url()?>');f.submit();" class="btn btn-primary">搜索数据</button>
                    <?php if($this->isExcel()){?>
                    <<?='?'?>php if(is_file(__DIR__.'/<?=$this->getShortName()?>Excel.php')){?><a id="<?=$buttonid=md5(__LINE__)?>"  onclick="var f=$('#<?=$buttonid?>').parents('form'); f.attr('action','<<?='?'?>=<?=$this->getShortName()?>Excel::url()?>');f.submit();" class="btn btn-primary">当前页面数据另存为Excel</a><<?='?'?>php } ?>
                    <?php }?>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </div>
</div>

<?php if(strpos($this->getShortName(),'log')!==strlen($this->getShortName())-3) {?>
<template v-for=" (idata,iindex) in [alldata.<?='<'?>?=<?=$this->getShortName()?>Ajax::<?=$TableName?>Model()?>,alldata.<?='<'?>?=<?=$this->getShortName()?>Ajax::<?=$TableName?>Model()?>ed]">
<?php }else{?>
<template v-for=" (idata,iindex) in [alldata.<?='<'?>?=<?=$this->getShortName()?>Ajax::<?=$TableName?>Model()?>]">
<?php }?>
<div class="row" v-if="idata">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">数据</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <div v-if="iindex == 0 "><<?='?'?>=(new PageBarHtml($this))->setVue(true)->__invoke()<?='?'?>></div>
                <table class="table table-hover">
                    <thead>
                <tr>
                    <?php foreach ($this->TableModelClassNameReflectionClass->getProperties() as $property){
                        if(strpos($property->getName(),'elasticsearch')===0){continue;}
                        ob_start();?>
                    <<?='?'?>=(new <?=$this->getTableModelClassNameReflectionClass()->getShortName()?>)()[<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>::<?=$property->getName()?>()]?>
<?php  $fieldShowName=trim(ob_get_clean()); ?>
                        <!--  <?=$property->getName()?>  --><th><?=$fieldShowName?></th>
<?php }?>
                    <th>操作</th>
                </tr>
                    </thead>
                    <tbody>


<!--  vue形式展示的网页格式  -->
                        <template v-for="(item,index) in idata">
<!--          vue编辑状态下的页面              -->
                <?php if($this->isAjaxEdit()){?>
                        <tr @mouseover="openedit(item.id)" @click="openedit(item.id)" <?php if(!$this->isAjaxEditOnly()){?>@blur="openedit(0)" v-show="openeditflag == item.id"  @drop="drop(index,$event)" @dragover="dragover" draggable="true" @dragstart="dragstart(index,$event)" <?php }?>>
                            <?php foreach ($this->TableModelClassNameReflectionClass->getProperties() as $property){
                                if(strpos($property->getName(),'elasticsearch')===0){continue;}
                                $isEnumFunction= $TableNameLong.'Type::'.$property->getName().'IsEnum();';
                                $isenum=false;
                                eval('$isenum='.$isEnumFunction);
                            ?>
<?php
    $AutoIncrement = $property->getName() == call_user_func([(new \ReflectionClass($TableNameLong))->newInstance(), 'getAutoIncrement']);
    $isAjaxEditField = in_array($property->getName(),$this->getAjaxEditField());
    //不可编辑的字段,可以被格式化
    if(!$isAjaxEditField){     ?>
            <?php if(in_array($property->getName(),$this->getAjaxhowfield())){?>
            <!--  <?=$property->getName()?>  --><td v-html="<?='<'?>?=<?=$TableName?>Model::<?=$property->name?>VueFunction(false,'<?=$property->getName()?>') ?>"></td>
            <?php }else{?>
            <!--  <?=$property->getName()?>  --><td ><<?='?'?>= <?=$TableName?>Model::<?=$property->name?>Vue() ?></td>
            <?php }?>
<?php }elseif ($isenum){ ?>
            <!--  <?=$property->getName()?>  --><td>
                    <<?='?'?>=(new SelectTPL())
                        ->setOptions(Enum<?=$this->getShortName().ucfirst($property->getName())?>::ALL())
                        ->setName(<?=$TableName?>Model::<?=$property->name?>())
                        ->setVOnChange('editField')
                        ->setQuick(true)
                        ->setVmodel(<?=$TableName?>Model::<?=$property->name?>Vue(false))
                        ->setAttr(':disabled="openeditflag != item.id"')
                    ->__invoke()?>
<?php }else{ ?>
            <!--  <?=$property->getName()?>  --><td><input  :disabled="openeditflag != item.id" @keyup="editField()" class="<<?='?'?>php if(<?=$TableName?>Type::<?=$property->getName()?>IsDate()){?><<?='?'?>=DatePicker::daterangepicker()?><<?='?'?>php }?>" style="width: 100%" title="" name="<<?='?'?>=<?=$TableName?>Model::<?=$property->name?>()?>" type="text" v-model="<<?='?'?>= <?=$TableName?>Model::<?=$property->name?>Vue(false) ?>"></td>
<?php }?>
<?php }?>
                            <td><?php if(strpos($this->getShortName(),'log')!==strlen($this->getShortName())-3){?><a target="_blank" :href="'<?='<'?>?=<?=$this->getShortName()?>log::url()?>&<?='<'?>?=<?=$this->getShortName()?>logModel::pid()?>='+<?='<'?>?=<?=$this->getShortName()?>logModel::idVue(false)?>">日志</a><?php }?></td>
                        </tr>

                <?php }?>

                        </template>


                    </tbody>
                </table>
                <div v-if="iindex == 0 "><<?='?'?>=(new PageBarHtml($this))->setVue(true)->__invoke()<?='?'?>></div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<div v-else="">没有数据</div>
</template>
</div>
    <?='<'?>? $Properties=(new \ReflectionClass(<?=$TableName?>Ajax::class))->getProperties();
    $define=[];
    foreach ($Properties as $Propertie)
    {
        $define[$Propertie->getName()]='';
    }
    ?>
<script>
    //查询表单的数据字段列表
    var requestmodel=<?='<'?>?=(new ConvertObject(new <?=$this->getShortName()?>Request))->toJson()?>;
    //ajax返回的数据结构
    var alldata=<?='<'?>?=json_encode($define,JSON_UNESCAPED_UNICODE)?>;
    //修改值之后,可以重新刷新界面的字段
    var reloadfield=<?=$this->getReloadfield()?>;
</script>
<?php if($this->isAjax()){?>
<<?='?'?>=(new VueLink)->setUrl(<?=$this->getShortName()?>Ajax::url())<?php if($this->isAjaxEdit() && strpos($this->getShortName(),'log')!==strlen($this->getShortName())-3 ){?>->setEditAjaxUrl(<?=$this->getShortName()?>AjaxEdit::url())<?php }?>->__invoke()?>
<?php } ?>

<<?='?'?>= (new DatePicker())->setTimePicker(false)->setSingleDatePicker(false)->__invoke() ?>
<<?='?'?>= (new Timepicker())->setInterval(30)->__invoke() ?>
<script>
    //监控分页条设置的改变
    vueel.$watch('alldata.pageObject.prepage',function () {
        $.get('<?='<'?>?=Page::url()?>&prepage='+this.alldata.pageObject.prepage)
    });
</script>
<script>
<?='<'?>?php
$jss = (new Dir(__DIR__.'/<?=$this->getShortName()?>/'))
    ->setPreg('.js$')
    ->setOnlyFile(true)
    ->__invoke();
foreach ($jss as $js)
{
    include $js->getRealPath();
}
?>
</script>
