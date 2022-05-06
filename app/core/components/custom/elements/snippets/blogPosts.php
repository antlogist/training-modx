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
    $publishedon = $value->publishedon;

    echo $wrapper['start'];

    renderImage($imageUrl, $value->pagetitle);

    renderTitle($value->pagetitle);
    renderDate($publishedon);
    renderIntro($value->introtext);
    renderReadMore($value->uri, 'Читать');

    echo $wrapper['end'];
}

function renderDate($date) {
    echo  '<small>' . date('d/m/Y', $date) . '</small>';
}

function renderWrapper() {
    return array(
        'start'  => '<div class="my-5">',
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
    echo '<h2 class="mb-0 pb-0">'. $title .'</h2>';
}

function renderIntro($intro) {
    echo '<div class="mt-1 mb-3">' . $intro . '</div>';
}

function renderReadMore($link = '#', $text = 'Читать') {
    echo '<a href="' . $link . '" class="btn btn-warning btn-sm">' . $text . '</a>';
}