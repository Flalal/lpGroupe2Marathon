<?php

namespace App;

final class AppEvent
{
    const RECETTE_ADD = "app.recette.add";
    const RECETTE_EDIT = "app.recette.edit";
    const RECETTE_DELETE = "app.recette.delete";

    const EDIT_ARTICLE = 'app.article.edit';
    const CREATE_ARTICLE = 'app.article.create';
    const DELETE_ARTICLE = 'app.article.delete';

    const COMMENT_ADD = "app.comment.add";

    const VOTE_ADD = "app.vote.add";
}