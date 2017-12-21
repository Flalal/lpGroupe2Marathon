<?php

namespace App;

final class AppEvent
{
    const RECETTE_ADD = "app.recette.add";
    const RECETTE_EDIT = "app.recette.edit";
    const RECETTE_DELETE = "app.recette.delete";

    const ARTICLE_EDIT = 'app.article.edit';
    const ARTICLE_CREATE = 'app.article.create';
    const ARTICLE_DELETE = 'app.article.delete';

    const COMMENT_ADD = "app.comment.add";

    const VOTE_ADD = "app.vote.add";
}