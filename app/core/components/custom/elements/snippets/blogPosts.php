<?php

// DB request
$posts = $modx->newQuery('modResource');
$posts->where(array(
    'parent:IN' => array(6),
    'deleted' => false,
    'hidemenu' => false,
    'published' => true,
));
$posts->sortby('menuindex', 'ASC');
$posts->limit(10);

// Get collection 
$resources = $modx->getCollection('modResource', $posts);

// Main loop
foreach($resources as $key => $value) {

    $wrapper = renderWrapper();
    $imageUrl = $value->getTVValue('image');
    $publishedon = $value->publishedon;

    echo $wrapper['start'];

    renderImage($imageUrl, $value->pagetitle);

    renderTitle($value->pagetitle);
    renderDate($publishedon);
    renderIntro($value->introtext);
    renderReadMore($value->uri, 'Читать');

    echo $wrapper['end'];
}

// Wrapper rendering
function renderWrapper() {
    return array(
        'start'  => '<div class="my-5">',
        'end'    => '</div>'
    );
}

// Date rendering
function renderDate($date) {
    echo  '<small>' . date('d/m/Y', $date) . '</small>';
}

// Image rendering
function renderImage($url, $alt) {
    if(!$url) { return; }

    echo '<img src="' . $url . '" alt="' . $alt . '" class="img-fluid">';
}

// Title rendering
function renderTitle($title) {
    echo '<h2 class="mb-0 pb-0">'. $title .'</h2>';
}

// Short description rendering
function renderIntro($intro) {
    echo '<div class="mt-1 mb-3">' . $intro . '</div>';
}

// Read more button rendering
function renderReadMore($link = '#', $text = 'Читать') {
    echo '<a href="' . $link . '" class="btn btn-warning btn-sm">' . $text . '</a>';
}
