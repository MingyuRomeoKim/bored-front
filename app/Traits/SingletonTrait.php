<?php

namespace App\Traits;

trait SingletonTrait
{
    /**
     * The single instance of the class.
     *
     * @var self|null
     */
    private static ?self $instance = null;

    /**
     * Get the single instance of the class.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Prevent direct instantiation.
     */
    private function __construct()
    {
        // Optional: Initialize your singleton properties here
    }

    /**
     * Prevent cloning of the instance.
     */
    private function __clone()
    {
        // Do nothing
    }

    /**
     * Prevent unserialization of the instance.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
