<?php

namespace anuncielo\View\Components;

use Illuminate\View\Component;

class MetaTtags extends Component
{
    public $title;
    public $description;
    public $image;
    public $type;
    public $publishedTime;
    public $section;
    public $schema;

    public function __construct(
        $title = null,
        $description = null,
        $image = null,
        $type = 'website',
        $publishedTime = null,
        $section = null,
        $schema = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->type = $type;
        $this->publishedTime = $publishedTime;
        $this->section = $section;
        $this->schema = $schema;
    }

    public function render()
    {
        return view('components.meta-ttags');
    }
} 