<!-- Previous & Next Articles Starts -->
<div class="clearfix"></div>
                    
<!-- PRE & NEXT Article -->
<div class="col-xs-12 no-padding margin-top-30">
    <div class="col-xs-12 col-sm-6 no-left-padding preArticleDiv">
        {if isset($article->previous_article)}
        {if $article->type_id == 1}
        <a href="{$APP_BASE_URL}article/{$article->previous_article->perma_link|lower}" class="linkDarkBlack width_100">
        {else if $article->type_id == 2 || $article->type_id == 3}
        <a href="{$APP_BASE_URL}insight/{$article->previous_article->perma_link|lower}" class="linkDarkBlack width_100">
        {/if}
            <p><i class="fa fa-angle-left"></i> READ PREVIOUS</p>
            <div class="col-xs-12 no-padding preNextArticle">
                <div class="col-xs-7 no-left-padding">
                    <p>{$article->previous_article->title}</p>
                </div>
                <div class="col-xs-5 no-padding">
                    {if $article->type_id == 3}
                        <div class="videoLink">
                            <a href="{$APP_BASE_URL}insight/{$article->previous_article->perma_link|lower}">
                                <p style="position:absolute; width:100%; height:100%; top:0">
                                </p>
                            </a>
                            <iframe src="https://www.youtube.com/embed/{$article->previous_article->video_id}" height="160" width="90%" allowfullscreen="" frameborder="0"></iframe>
                        </div>
                    {else}
                    <img src="{$APP_BASE_URL}image/article?file_name={$article->previous_article->id}/{$article->previous_article->thumbnail_image}" class="img-responsive width_100" alt="">
                    {/if}
                </div>
            </div>
        </a>
        {/if}
    </div>
    <div class="col-xs-12 col-sm-6 no-right-padding nextArticleDiv">
        {if isset($article->next_article)}
        {if $article->type_id == 1}
        <a href="{$APP_BASE_URL}article/{$article->next_article->perma_link|lower}" class="linkDarkBlack width_100">
        {else if $article->type_id == 2 || $article->type_id == 3}
        <a href="{$APP_BASE_URL}insight/{$article->next_article->perma_link|lower}" class="linkDarkBlack pull-right width_100">
        {/if}
        
            <p class="pull-right">READ NEXT <i class="fa fa-angle-right"></i></p>
            <div class="col-xs-12 no-padding preNextArticle">
                <div class="col-xs-5 no-padding">                              
                    {if $article->type_id == 3}
                        <div class="videoLink">
                            <a href="{$APP_BASE_URL}insight/{$article->next_article->perma_link|lower}">
                                <p style="position:absolute; width:100%; height:100%; top:0">
                                </p>
                            </a>
                            <iframe src="https://www.youtube.com/embed/{$article->next_article->video_id}" height="160" width="90%" allowfullscreen="" frameborder="0"></iframe>
                        </div>
                    {else}
                    <img src="{$APP_BASE_URL}image/article?file_name={$article->next_article->id}/{$article->next_article->thumbnail_image}" class="img-responsive width_100" alt="">
                    {/if}
                </div>
                <div class="col-xs-7 no-right-padding">
                    <p>{$article->next_article->title}</p>
                </div>
            </div>
        </a>
        {/if}
    </div>
</div>
<!-- Previous & Next Articles Ends -->