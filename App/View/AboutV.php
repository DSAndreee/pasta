<?php
class AboutV extends Neo\View {

    public function __construct($flags = null, $data = null)
    {
        // overload and keep parent ctor.
        parent::__construct($flags, $data);

        // here we go
        $this->append_code('<div class="about">')->append_template('about.md')->append_code('</div>');
    }

}
