<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

Breadcrumbs::for('resources.news', function ($trail) {
    $trail->parent('home');
    $trail->push('Новости', route('resources.news'));
});

Breadcrumbs::for('resources.laws', function ($trail) {
    $trail->parent('home');
    $trail->push('Законы', route('resources.laws'));
});

Breadcrumbs::for('resources.laws.show', function ($trail, $item) {
    $trail->parent('resources.laws');
    $trail->push($item->title, route('resources.laws.show', $item->slug));
});

Breadcrumbs::for('resources.diplomas', function ($trail) {
    $trail->parent('home');
    $trail->push('Дипломы', route('resources.diplomas'));
});

Breadcrumbs::for('resources.diplomas.show', function ($trail, $item) {
    $trail->parent('resources.diplomas');
    $trail->push($item->title, route('resources.diplomas.show', $item->slug));
});

Breadcrumbs::for('resources.seminar', function ($trail) {
    $trail->parent('home');
    $trail->push('Семинары', route('resources.seminar'));
});

Breadcrumbs::for('resources.seminar.show', function ($trail, $item) {
    $trail->parent('resources.seminar');
    $trail->push($item->title, route('resources.seminar.show', $item->slug));
});

Breadcrumbs::for('resources.news.show', function ($trail, $item) {
    $trail->parent('resources.news');
    $trail->push($item->title, route('resources.news.show', $item->slug));
});
