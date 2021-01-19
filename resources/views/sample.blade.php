<?php $pages = TCG\Voyager\Models\Page::first() ?>
    @can('browse', $pages)
        You can browse pages
    @else
        You are unable to browse pages
    @endcan
