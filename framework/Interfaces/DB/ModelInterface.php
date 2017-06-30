<?php

namespace Framework\Interfaces\DB;

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
     *
     */
    public function fill(array $unsafeAttributes);

    /**
     * Update attributes of this model.
     *
     * Attributes passed to this function should be safe.
     */
    public function forceFill(array $attributes);
}
