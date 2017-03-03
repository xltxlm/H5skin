<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */?>
<<?='?'?>php
/**
* Created by PhpStorm.
* User: xialintai
* Date: 2017/3/1
* Time: 19:35.
*/

namespace <?=$this->getClassNameSpace()?>;
use kuaigeng\abconfig\vendor\xltxlm\h5skin\src\Traits\DatePicker;
use <?=strtr($this->TableModelClassNameReflectionClass->getName(),['Model'=>''])?>Copy;
use <?=strtr($this->TableModelClassNameReflectionClass->getName(),['Model'=>''])?>Type;
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isEnumFunction=strtr($this->TableModelClassNameReflectionClass->getName(),['Model'=>'']).'Type::'.$property->getName().'IsEnum();';
    $enum=false;
    eval('$enum='.$isEnumFunction);
    if($enum){
?>
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>;

<?php }}?>
use xltxlm\h5skin\SelectTPL;
?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Horizontal Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" action="<<?='?'?>= <?=$this->getShortName()?>AddDo::url() ?>" method="post">
                <div class="box-body">
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isEnumFunction=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']).'Type::'.$property->getName().'IsEnum();';
    $enum=false;
    eval('$enum='.$isEnumFunction);
    ob_start();?>
    <<?='?'?>=(new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Copy)()[<?=$this->getShortName()?>RequestCopy::<?=$property->getName()?>()]?>
    <?php  $fieldShowName=trim(ob_get_clean()); ?>


    <!--  <?=$property->getName()?>  -->
                    <div class="form-group">
                        <label for="<?=$property->getName()?>" class="col-sm-2 control-label"><?=$fieldShowName?></label>
                        <div class="col-sm-6">
                            <?php if($enum){?>
                                <<?='?'?>=(new SelectTPL())
                                ->setOptions(Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>::ALL())
                                ->setClassName('form-control')
                                ->__invoke()?>
                            <?php }else{ ?>
                                <input type="text"
                                       class="form-control <<?='?'?>php if(<?=strtr($this->TableModelClassNameReflectionClass->getShortName(),['Model'=>''])?>Type::<?=$property->getName()?>IsDate()){?><<?='?'?>=DatePicker::daterangepicker()?><<?='?'?>php }?>"
                                       id="<<?='?'?>= <?=$this->getShortName()?>RequestCopy::<?=$property->getName()?>() ?>"
                                       name="<<?='?'?>= <?=$this->getShortName()?>RequestCopy::<?=$property->getName()?>() ?>"
                                       value="<<?='?'?>= $this->get<?=$this->getTableModelClassNameReflectionClass()->getShortName()?>()->get<?=$property->getName()?>() ?>"
                                       required
                                       placeholder="<?=$fieldShowName?>">
                            <?php } ?>
                        </div>
                    </div>
<?php }?>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-info pull-right">提交新数据</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
    </div>
</div>

<<?='?'?>= (new DatePicker($this))->setTimePicker(false)->__invoke() ?>

