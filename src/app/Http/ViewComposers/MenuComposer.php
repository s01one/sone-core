<?php

namespace sOne\Core\app\Http\ViewComposers;

use sOne\Core\app\Models\Content;
use sOne\Core\app\Models\Context;
use Illuminate\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        $currentDomain = request()->getHttpHost();
        $context = Context::where('name', $currentDomain)->first();

        $items = Content::whereNull('parent_id')
            ->where('context_id', $context->id)
            ->with('children')
            ->orderBy('lft')
            ->get();

        return $view->with('items', $items);
    }
}
