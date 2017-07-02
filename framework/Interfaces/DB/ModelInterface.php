<?php
namespace Framework\Interfaces\DB;

/**
 * An interface that models should implement. This ensures that repositories
 * will be able to use them.
 */
interface ModelInterface
{
    /**
     * Get unique identifier for this mode.
     * Returns null if the model is not persisted.
     *
     * @return null|int
     */
    public function getId();

    /**
     * Update attributes of this model.
     *
     * Attributes passed to this function should be considered unsafe, so should
     * be sanitized before being used.
     */
    public function fill(array $unsafeAttributes);

    /**
     * Update attributes of this model.
     *
     * Attributes passed to this function should be safe.
     */
    public function forceFill(array $attributes);

    /**
     * Create a new instance of an object based on an attributes array.
     *
     * This is used by repositories to build objects from database data
     */
    public static function build(array $attributes) : ModelInterface;
}
