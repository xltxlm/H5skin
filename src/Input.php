<?php
/**
 * Created by PhpStorm.
 * User: xialintai
 * Date: 2016/12/20
 * Time: 11:10.
 */

namespace xltxlm\h5skin;

use xltxlm\template\Template;

/**
 * 通用的输入框类型
 * Class input.
 */
final class Input extends Template
{
    /** @var string id */
    protected $id = '';
    /** @var string form 表单名称 */
    protected $name = '';
    /** @var string 表单类型 */
    protected $type = '';
    /** @var string 展示的文字 */
    protected $text = '';
    /** @var string 值 */
    protected $value = '';

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return Input
     */
    public function setValue(string $value): Input
    {
        $this->value = $value;

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
     *
     * @return Input
     */
    public function setId(string $id): Input
    {
        $this->id = $id;

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
     *
     * @return Input
     */
    public function setName(string $name): Input
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Input
     */
    public function setType(string $type): Input
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Input
     */
    public function setText(string $text): Input
    {
        $this->text = $text;

        return $this;
    }
}
