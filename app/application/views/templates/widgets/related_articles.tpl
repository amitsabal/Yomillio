<!-- Related Articles Starts -->

<div class="clearfix"></div>
<div class="relatedArticle" {if $article->related_articles|@count == 0} style="display:none" {/if}>
    <div class="relatedHeading col-xs-12 no-padding">
        <h4 class="text-bold text-gray padding-vertical-10">RELATED </h4>
    </div>
    <div class="clearfix"></div>
    <div class="relatedArticleContent">
        {if isset($article->related_articles)}
        {foreach from=$article->related_articles item=rarticle name=related}
        <span>
            {if $rarticle->type_id == 1}
            <a class="col-xs-12 no-padding margin-top-20 border-bottom-light-grey" href="{$APP_BASE_URL}article/{$rarticle->perma_link|lower}">

                <img src="{$APP_BASE_URL}image/article?file_name={$rarticle->id}/{$rarticle->banner_image}" class="img-responsive width_40 pull-left" alt="">
                <div class="col-xs-7 no-right-padding">
                    <p class="text-metallic-blue text-bold word-warp text-medium" >{$rarticle->title}</p>
                </div>
                <div class="clearfix"></div>
            </a>
            {else if $rarticle->type_id == 2}
            <a class="col-xs-12 no-padding margin-top-20 border-bottom-light-grey" href="{$APP_BASE_URL}insight/{$rarticle->perma_link|lower}">

                <img src="{$APP_BASE_URL}image/article?file_name={$rarticle->id}/{$rarticle->banner_image}" class="img-responsive width_40 pull-left" alt="">
                <div class="col-xs-7 no-right-padding">
                    <p class="text-metallic-blue text-bold word-warp text-medium" >{$rarticle->title}</p>
                </div>
                <div class="clearfix"></div>
                </a>
            {else}
            <div class="col-xs-12 no-padding margin-top-20 border-bottom-light-grey">
                <div class="col-xs-5 no-padding">
                    <div class="videoLink">
                        <a href="{$APP_BASE_URL}insight/{$rarticle->perma_link|lower}">
                            <p style="position:absolute; width:100%; height:100%; top:0">
                            </p>
                        </a>
                        <iframe src="https://www.youtube.com/embed/{$rarticle->video_id}" height="160" width="100%" allowfullscreen="" frameborder="0"></iframe>
                    </div>
                </div>                                    
                <div class="col-xs-7 no-right-padding">
                    <a href="{$APP_BASE_URL}insight/{$rarticle->perma_link|lower}"  style="text-decoration:none;">
                    <p class="text-metallic-blue text-bold word-warp text-medium" style="height:160px">{$rarticle->title}</p>
                </a>
                </div>
            </div>
           {/if}
        </span>
        {/foreach}
        {/if}
    </div>
</div>
<div class="clearfix"></div>

<!-- Related Articles Ends -->