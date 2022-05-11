<?php
$postsPerPage = 10;
$p = intval($_GET['p']);

// DB request
$posts = $modx->newQuery('modResource');
$posts->where(array(
    'parent:IN' => array(6),
    'deleted' => false,
    'hidemenu' => false,
    'published' => true,
    'context_key' => 'web'
));

// Total posts
$totalPosts = $modx->getCount('modResource', $posts);

// Sorting rows
$posts->sortby('id', 'DESC');

// Count page
if ($p > 0) {
    $currentPage = $p - 1;
} else if (!$p || $p <= 0) {
    $currentPage = 0;
}

$posts->limit($postsPerPage, $postsPerPage * $currentPage);

// Get collection 
$resources = $modx->getCollection('modResource', $posts);

// Main loop
foreach ($resources as $key => $value) {
    $imageUrl = $value->getTVValue('image');
    $publishedon = $value->publishedon;

    $output = $modx->getChunk('blogPost', array(
        'pagetitle'     => $value->pagetitle,
        'imageUrl'      => $imageUrl,
        'publishedon'   => date('d/m/Y', $publishedon),
        'introtext'     => $value->introtext,
        'pageLink'      => $value->uri
    ));
    
    echo $output;
}

// Pagination loop
$pages = ceil($totalPosts / $postsPerPage);
if ($pages > 1) {
    for ($i = 1; $i <= $pages; $i++) {
        renderPagination($i, $currentPage);
    }
}

// Pagination rendering
function renderPagination($number, $currentPage)
{

    if ($currentPage === $number - 1) {
        echo '<a href="/blog/?p=' . $number . '" class="d-inline-block btn btn-warning mx-1">' . $number . '</a>';
    } else {
        echo '<a href="/blog/?p=' . $number . '" class="d-inline-block btn btn-outline-dark mx-1">' . $number . '</a>';
    }
}
