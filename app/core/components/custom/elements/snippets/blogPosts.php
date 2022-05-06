<?php
$posts = $modx->newQuery('modResource');
$posts->where(array(
    'parent:IN' => array(6),
    'deleted' => false,
    'hidemenu' => false,
    'published' => true,
));
$posts->sortby('menuindex', 'ASC');
$posts->limit(10);
$resources = $modx->getCollection('modResource', $posts);

foreach($resources as $key => $value) {

    $wrapper = renderWrapper();
    $imageUrl = $value->getTVValue('image');

    echo $wrapper['start'];

    renderImage($imageUrl, $value->pagetitle);

    renderTitle($value->pagetitle);
    renderIntro($value->introtext);
    renderReadMore($value->uri, 'Читать');

    echo $wrapper['end'];
}

function renderWrapper() {
    return array(
        'start'  => '<div class="my-3">',
        'end'    => '</div>'
    );
}

function renderImage($url, $alt) {
    if(!$url) {
        return;
    }

    echo '<img src="' . $url . '" alt="' . $alt . '" class="img-fluid">';
}

function renderTitle($title) {
    echo '<h2>'. $title .'</h2>';
}

function renderIntro($intro) {
    echo '<div class="mb-3">' . $intro . '</div>';
}

function renderReadMore($link = '#', $text = 'Читать') {
    echo '<a href="' . $link . '" class="btn btn-warning btn-sm">' . $text . '</a>';
}