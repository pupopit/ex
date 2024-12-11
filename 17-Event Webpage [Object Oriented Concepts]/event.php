<?php
class Event {
    public $label;
    public $font_size;
    public $color;

    // Constructor to initialize event properties
    public function __construct($label, $font_size, $color) {
        $this->label = $label;
        $this->font_size = $font_size;
        $this->color = $color;
    }

    // Destructor for cleanup
    public function __destruct() {
        // Optional cleanup code (if needed)
    }

    // Method to display event
    public function show_event() {
        echo "<div style='font-size: {$this->font_size}; color: {$this->color}; margin-bottom: 10px;'>{$this->label}</div>";
    }
}
?>
