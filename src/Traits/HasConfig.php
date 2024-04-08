<?php

namespace Iyuu\SiteManager\Traits;

/**
 * 配置
 */
trait HasConfig
{
    /**
     * 配置
     * @var array
     */
    protected array $config = [];

    /**
     * 构造函数
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * 转换当前数据为JSON字符串
     * @param int $options json参数
     * @return string
     */
    public function toJson(int $options = JSON_UNESCAPED_UNICODE): string
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * 转数组
     * @return array
     */
    final public function toArray(): array
    {
        return $this->config;
    }

    /**
     * 当对不可访问属性调用 isset() 或 empty() 时，__isset() 会被调用
     * @param string $name
     * @return bool
     */
    final public function __isset(string $name): bool
    {
        return isset($this->config[$name]);
    }

    /**
     * 当对不可访问属性调用 unset() 时，__unset() 会被调用
     * @param string $name
     */
    final public function __unset(string $name)
    {
        unset($this->config[$name]);
    }

    /**
     * 当访问不可访问属性时调用
     * @param string $name
     * @return mixed
     */
    final public function __get(string $name)
    {
        return $this->get($name);
    }

    /**
     * 在给不可访问（protected 或 private）或不存在的属性赋值时，__set() 会被调用。
     * @param string $key
     * @param mixed $value
     */
    final public function __set(string $key, mixed $value)
    {
        $this->set($key, $value);
    }

    /**
     * 获取配置项参数【支持 . 分割符】
     * @param string|null $key
     * @param null $default
     * @return mixed
     */
    final public function get(?string $key = null, $default = null): mixed
    {
        if (null === $key) {
            return $this->config;
        }
        $keys = explode('.', $key);
        $value = $this->config;
        foreach ($keys as $index) {
            if (!isset($value[$index])) {
                return $default;
            }
            $value = $value[$index];
        }
        return $value;
    }

    /**
     * 设置 $this->data
     * @param string|null $key
     * @param mixed $value
     * @return self
     */
    final public function set(?string $key, mixed $value): self
    {
        if ($key === null) {
            $this->config[] = $value;
        } else {
            $this->config[$key] = $value;
        }
        return $this;
    }

    // ArrayAccess

    #[\ReturnTypeWillChange]
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->config);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset): void
    {
        unset($this->config[$offset]);
    }
}