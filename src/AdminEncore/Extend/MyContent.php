<?php


namespace Kiwi\Core\AdminEncore\Extend;


use Encore\Admin\Layout\Content;

class MyContent extends Content
{
    public function render()
    {
        $items = [
            'header' => $this->title,
            'description' => $this->description,
            'breadcrumb' => $this->breadcrumb,
            '_content_' => $this->build(),
            '_view_' => $this->view,
            '_user_' => $this->getUserData(),
        ];

        return view('admin.content', $items)->render();
    }
}
