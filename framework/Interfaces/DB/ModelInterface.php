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
     * Update the attributes of this model. Should handle sanitation
     */
    public function fill(array $unsafeAttributes);
}
