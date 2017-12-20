<?php
/**
 * Created by PhpStorm.
 * User: florian.flahaut
 * Date: 20/12/17
 * Time: 11:55
 */

namespace App;


class AppEvent
{
    const EDIT_ARTICLE = 'app.article.edit';
    const CREATE_ARTICLE = 'app.article.create';
    const DELETE_ARTICLE = 'app.article.delete';
}