<!-- Recommended Articles Starts -->
<div class="clearfix"></div>
<div class="recommended col-xs-12 no-padding margin-top-50" {if $article->recommended_articles|@count == 0} style="display:none" {/if}>
    <div class="recommendedHeading col-xs-12 no-padding">
        <h4 class="text-bold text-gray">
            RECOMMENDED
        </h4>
    </div>
    <div class="clearfix"></div>
    <div class="recommendedContentDiv padding-top-10 col-xs-12 no-padding">
        {if isset($article->recommended_articles)}
        {foreach from=$article->recommended_articles item=recomended}
        <span>
            {if $recomended->type_id == 1}
            <a class="col-xs-12 col-sm-6 col-md-3 margin-bottom-20 no-padding" href="{$APP_BASE_URL}article/{$recomended->perma_link|lower}">
                <div class="recomendedImg">
                    <img src="{$APP_BASE_URL}image/article?file_name={$recomended->id}/{$recomended->thumbnail_image}" class="img-responsive" />
                </div>
                <div class="recommendedContent padding-top-10 text-bold center center-margin">
                    <p class="text-dark-gray">{$recomended->title}</p>
                </div>
            </a>
            {else if $recomended->type_id == 2}
            <a class="col-xs-12 col-sm-6 col-md-3 margin-bottom-20 no-padding" href="{$APP_BASE_URL}insight/{$recomended->perma_link|lower}">
                <div class="recomendedImg">
                    <img src="{$APP_BASE_URL}image/article?file_name={$recomended->id}/{$recomended->thumbnail_image}" class="img-responsive" />
                </div>
                <div class="recommendedContent padding-top-10 text-bold center center-margin">
                    <p class="text-dark-gray">{$recomended->title}</p>
                </div>
            </a>
            {else}
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="videoLink">
                    <a href="{$APP_BASE_URL}insight/{$recomended->perma_link|lower}">
                        <p style="position:absolute; width:100%; height:100%; top:0">
                        </p>
                    </a>
                    <iframe src="https://www.youtube.com/embed/{$recomended->video_id}" height="134" width="90%" allowfullscreen="" frameborder="0"></iframe>
                </div>
                <a href="{$APP_BASE_URL}insight/{$recomended->perma_link|lower}" class="col-xs-12 margin-bottom-20 no-padding">
                    <div class="recommendedContent padding-top-10 text-bold center center-margin">
                        <p class="text-dark-gray">{$recomended->title}</p>
                    </div>
                </a>
            </div>

            {/if}
                
        </span>
        {/foreach}
        {/if}
    </div>
</div>
<!-- Recommended Articles Ends -->