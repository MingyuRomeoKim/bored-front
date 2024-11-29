<?php

namespace App\Traits;

trait BuilderTrait
{
    /**
     * Dynamically build an instance of the class.
     *
     * @param array $attributes
     * @return self
     */
    public static function builder(array $attributes = []): self
    {
        $instance = new self();

        foreach ($attributes as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->{$key} = $value;
            }
        }

        return $instance;
    }

    /**
     * Allow setting properties dynamically.
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function set(string $key, $value): self
    {
        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        }

        return $this;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

}
