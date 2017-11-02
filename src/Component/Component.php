<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2017/9/3
 * Time: 13:17
 */

namespace xltxlm\h5skin\Component;


trait Component
{
    /** @var string */
    protected $name = "";
    /** @var string */
    protected $id = "";

    /** @var string 动态编辑提交的url地址 */
    protected $ajaxEditUrl = "";
    /** @var string 绑定的模型 */
    protected $model = "";
    /** @var string 是否可以编辑 */
    protected $edit = false;
    /** @var bool 是否格式化数据 */
    protected $htmlformat = false;

    /** @var string 整行数据的model */
    protected $item = "";
    /** @var string 当值等于的时候，显示红色 */
    protected $redvalue = '';
    /** @var string 当值等于的时候，显示绿色 */
    protected $greenvalue = '';
    /** @var bool 是否格式化展示 */
    protected $showfield = false;
    /** @var bool 是否只显示模板 */
    protected $init = false;

    /**
     * @return bool
     */
    public function isInit(): bool
    {
        return $this->init;
    }

    /**
     * @param bool $init
     * @return static
     */
    public function setInit(bool $init)
    {
        $this->init = $init;
        return $this;
    }


    /**
     * @return string
     */
    public function getItem(): string
    {
        return $this->item;
    }

    /**
     * @param string $item
     * @return static
     */
    public function setItem(string $item)
    {
        $this->item = $item;
        return $this;
    }


    /**
     * @return bool
     */
    public function isHtmlformat(): bool
    {
        return $this->htmlformat;
    }

    /**
     * @param bool $htmlformat
     * @return static
     */
    public function setHtmlformat(bool $htmlformat)
    {
        $this->htmlformat = $htmlformat;
        return $this;
    }


    /**
     * @return string
     */
    public function getAjaxEditUrl(): string
    {
        return $this->ajaxEditUrl;
    }

    /**
     * @param string $ajaxEditUrl
     * @return static
     */
    public function setAjaxEditUrl(string $ajaxEditUrl)
    {
        $this->ajaxEditUrl = $ajaxEditUrl;
        return $this;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return static
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return static
     */
    public function setModel(string $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string
     */
    public function isEdit(): bool
    {
        return $this->edit;
    }

    /**
     * @param bool $edit
     * @return static
     */
    public function setEdit(bool $edit)
    {
        $this->edit = $edit;
        return $this;
    }

    /**
     * @return string
     */
    public function getGreenvalue(): string
    {
        return $this->greenvalue;
    }

    /**
     * @param string $greenvalue
     * @return static
     */
    public function setGreenvalue(string $greenvalue)
    {
        $this->greenvalue = $greenvalue;
        return $this;
    }

    /**
     * @return string
     */
    public function getRedvalue(): string
    {
        return $this->redvalue;
    }

    /**
     * @param string $redvalue
     * @return static
     */
    public function setRedvalue(string $redvalue)
    {
        $this->redvalue = $redvalue;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowfield(): bool
    {
        return $this->showfield;
    }

    /**
     * @param bool $showfield
     * @return static
     */
    public function setShowfield(bool $showfield)
    {
        $this->showfield = $showfield;
        return $this;
    }


}