<?php

namespace App;

final class AppEvent
{
    const RECETTE_ADD = "app.recette.add";
    const RECETTE_EDIT = "app.recette.edit";

    const ARTICLE_EDIT = 'app.article.edit';
    const ARTICLE_CREATE = 'app.article.create';

    const COMMENT_ADD = "app.comment.add";
    const COMMENT_DELETE = "app.comment.delete";
    const COMMENT_EDIT = "app.comment.edit";

    const VOTE_ADD = "app.vote.add";
}