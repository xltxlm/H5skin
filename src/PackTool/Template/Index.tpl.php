<?php /** @var \xltxlm\h5skin\PackTool\MakeCtroller $this */
?>
<<?='?'?>php
/** @var <?=$this->getClassName()?> $this */
use <?=$this->getClassName()?>;
use <?=$this->getClassName()?>RequestCopy;
<?php if($this->isMakeDelete()){?>use <?=$this->getClassName()?>DeleteDo;<?php }?>

use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Type;
use <?=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>''])?>Copy;
<?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
    $isEnumFunction=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']).'Type::'.$property->getName().'IsEnum();';
    $enum=false;
    eval('$enum='.$isEnumFunction);
    if($enum){
?>
use <?=$this->getTableModelClassNameReflectionClass()->getNamespaceName()?>\enum\Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>;

<?php }}?>
use xltxlm\h5skin\Traits\PageBarHtml;
use xltxlm\h5skin\SelectTPL;
use xltxlm\h5skin\Traits\DatePicker;;
<?php if($this->isMakeAdd()){?>use <?=$this->getClassName()?>Add;<?php }?>

?>
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
                <div class="box-body">

                    <?php foreach ($this->getTableModelClassNameReflectionClass()->getProperties() as $property){
                        $isEnumFunction=strtr($this->getTableModelClassNameReflectionClass()->getName(),['Model'=>'']).'Type::'.$property->getName().'IsEnum();';
                        $enum=false;
                        eval('$enum='.$isEnumFunction);
                        ob_start();
                     ?>
                        <<?='?'?>=(new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Copy)()[<?=$this->getShortName()?>RequestCopy::<?=$property->getName()?>()]?>
                        <?php  $fieldShowName=trim(ob_get_clean()); ?>


                        <!--  <?=$property->getName()?>  -->
                    <div class="form-group col-md-2 <<?='?'?>= $this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>() ? 'has-error' : '' ?> ">
                        <label  class="<<?='?'?>= $this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>() ? 'label label-danger' : '' ?>" for="<?=$property->getName()?>">
                            <?=$fieldShowName?>
                        </label>
                    <?php if($enum){?>
                            <<?='?'?>=(new SelectTPL())
                        ->setOptions([
                            "全部"=>NULL
                        ]+Enum<?=$this->getShortName()?><?=ucfirst($property->getName())?>::ALL())
                                ->setClassName('form-control')
                                ->setName(<?=$this->getShortName()?>RequestCopy::<?=$property->getName()?>())
                                ->__invoke()?>
                    <?php }else{?>
                                <input type="text"
                                       class="form-control <<?='?'?>php if(<?=strtr($this->TableModelClassNameReflectionClass->getShortName(),['Model'=>''])?>Type::<?=$property->getName()?>IsDate()){?><<?='?'?>=DatePicker::daterangepicker()?><<?='?'?>php }?>"
                                       name="<<?='?'?>= <?=$this->getShortName()?>RequestCopy::<?=$property->getName()?>() ?>"
                                       value="<<?='?'?>=$this->get<?=$this->getShortName()?>Request()->get<?=$property->getName()?>()?>"
                                       id="<<?='?'?>= <?=$this->getShortName()?>RequestCopy::<?=$property->getName()?>() ?>" placeholder="<?=$property->getName()?>">
                    <?php }?>
                    </div>
                    <?php }?>

                    <!--  排序  -->
                    <div class="form-group col-md-2 <<?='?'?>= $this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy() ? 'has-error' : '' ?> ">
                        <label  class="<<?='?'?>= $this->get<?=$this->getShortName()?>Request()->getWebPageOrderBy() ? 'label label-danger' : '' ?>" for="webPageOrderBy">
                            排序依据
                        </label>
                        <<?='?'?> $ALLFields=(new <?=strtr($this->TableModelClassNameReflectionClass->getShortName(),['Model'=>''])?>Copy)()?>
                        <<?='?'?>=(new SelectTPL())
                            ->setOptions([
                                    "排序"=>NULL
                                ]+array_combine(array_values($ALLFields),array_keys($ALLFields)))
                            ->setClassName('form-control')
                            ->setName('webPageOrderBy')
                            ->__invoke()?>
                    </div>


                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">搜索数据</button>
                </div>
            </form>
        </div>
        <!-- /.box -->

    </div>
</div>



<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Responsive Hover Table</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <<?='?'?>=(new PageBarHtml($this))()<?='?'?>>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <?php foreach ($this->TableModelClassNameReflectionClass->getProperties() as $property){ ob_start();?>
                        <<?='?'?>=(new <?=strtr($this->getTableModelClassNameReflectionClass()->getShortName(),['Model'=>''])?>Copy)()[<?=$this->getShortName()?>RequestCopy::<?=$property->getName()?>()]?>
                        <?php  $fieldShowName=trim(ob_get_clean()); ?>
                        <th><?=$fieldShowName?></th>
                        <?php }?>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <<?='?'?>php foreach ($this->get<?=$this->TableModelClassNameReflectionClass->getShortName()?>() as $model) { ?>
                        <tr>
                            <?php foreach ($this->TableModelClassNameReflectionClass->getProperties() as $property){?>
                                <!--  <?=$property->getName()?>  -->
                            <td><<?='?'?>= $model->get<?=ucfirst($property->name)?>() ?></td>
                            <?php }?>
                            <td>
                                <?php if($this->isMakeDelete()){?><a href="<<?='?'?>= <?=$this->getShortName()?>DeleteDo::url([<?=$this->getShortName()?>RequestCopy::id() => $model->getId()]) ?>"
                                   onclick="return confirm('确认删除?')">删除</a><?php }?>

                                <?php if($this->isMakeAdd()){?><a href="<<?='?'?>= <?=$this->getShortName()?>Add::url([<?=$this->getShortName()?>RequestCopy::id() => $model->getId()]) ?>"
                                >编辑</a><?php }?>
                            </td>
                        </tr>
                    <<?='?'?>php } ?>
                    </tbody>
                </table>
                <<?='?'?>=(new PageBarHtml($this))()<?='?'?>>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>


<<?='?'?>= (new DatePicker($this))->setTimePicker(false)->setSingleDatePicker(false)->__invoke() ?>