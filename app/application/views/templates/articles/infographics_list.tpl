{extends file='layouts/layout.tpl'}


{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/viewAll.css">
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/jquery.tagit.css">
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/tagit.ui-zendesk.css">
{/block}

{block name="content"}

<!-- Search Result Headding -->

{include file='popups/newarticle.popup.tpl'}    

<div class="viewAllArticle bg-light-black">
    <div class="container">
        <div class="col-xs-12 no-pading">
            <div class="font-family-light text-26 text-white margin-vertical-10 font-italic">INFOGRAPHICS</div>
        </div>
    </div>
</div>
<!-- Filter of search result -->
<div class="container bg-light-blue no-padding">

    <div class="filterArticles">
        <ul>
            <li><a href="{$APP_BASE_URL}infographics/" class="{if !isset($response.selectedCategory) || $response.selectedCategory eq ''}active{else}{/if}">ALL</a></li>
            {foreach from=$response.categories item=category name=category}
            {if $smarty.foreach.category.index <= 4}
            <li>
                <a href="{$APP_BASE_URL}infographics/category/{$category->title|lower}" class="{if isset($response.selectedCategory) && $response.selectedCategory|lower == $category->title|lower}active{/if}">{$category->title|upper}</a>
            </li>
            {/if}
            
            {if $smarty.foreach.category.index > 4}
            {if $smarty.foreach.category.index == 5}
            <li class="pull-right">
                <div class="dropdown">
                    <a href="#" class="linkWhite dropdown-toggle" type="button" id="filterResultMore" data-toggle="dropdown">MORE <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu articleDropdown" role="menu" aria-labelledby="filterResultMore">
                        {/if}
                        <li role="presentation">
                            <a href="{$APP_BASE_URL}infographics/category/{$category->title|lower}" class="{if isset($response.selectedCategory) && $response.selectedCategory == $category->title}active{/if}">{$category->title|upper}</a>
                        </li>
            {if $smarty.foreach.category.last}
                    </ul>
                  </div>
            </li>
            {/if}
            {/if}
            {/foreach}
        </ul>
    </div>
</div>
{literal}
<div class="container no-padding bg-white">
    <div class="selectCategory">
        <div class="col-xs-12 padding-top-30 padding-bottom-30">
            <div class="btn-group col-sm-6 col-xs-12 no-padding padding-bottom-10">
                <!--  ng-class="{'active':showLatest}" ng-click="showLatestArticles();" -->
                <button class="btn btn-popular col-xs-6 col-md-4 active" ng-class="{'active':showLatest}" ng-click="showLatestArticles();">LATEST</button>
                <!--  ng-class="{'active':showPopular}"  ng-click="showPopularArticles();" -->
                <button class="btn btn-popular col-xs-6 col-md-4" ng-class="{'active':showPopular}"  ng-click="showPopularArticles();">POPULAR</button>
            </div>
             <div class="col-sm-6 col-xs-12 no-padding">
                <button class="btn btn-popular pull-right active" id="add_new_article">New Article</button>
            </div>
        </div>
    </div>
{/literal}
    <div class="col-xs-12 article no-padding" ng-show="showLatest">
        {if isset($response.latestArticles)}
        {foreach from=$response.latestArticles item=article name=latest}
            <div class="col-xs-12 col-sm-6 singleInfographic singleArticle" single-article-hover>
                <div class="col-xs-12 col-sm-6 no-padding">
                    <div class="col-xs-12 padding-bottom-5 no-padding infographicHeader">
                        <a href="{$APP_BASE_URL}infographics/category/{$article->category->title|lower}"><span class="infographicType text-blue">{$article->category->title|upper}</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 no-padding infographicTypeImg">
                        <a href="{$APP_BASE_URL}infographic/{$article->perma_link|lower}">
                            <img src="{$MEDIA_FILES_URL}uploads/images/articles/{$article->id}/{$article->thumbnail_image}" class="img-responsive width_100">
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 no-padding">
                    <div class="col-xs-12 no-padding text-light-gray infographicComments pull-right text-right">
                        <span>{if isset($article->comments) && $article->comments|count > 0}{$article->comments|count}{else}0{/if}</span> COMMENTS
                    </div>
                    <div class="col-xs-12">
                        <h3 class="text-bold font-family-bold">
                            <a href="{$APP_BASE_URL}infographic/{$article->perma_link|lower}" class="linkDarkBlack">{$article->title}</a>
                        </h3>
                        <p>By 
                            <span class="authorName text-blue">
                        {if isset($article->author) && $article.author != null}
                            {$article->author->first_name} {$article->author->last_name}
                        {else}
                            {$article->admin_author->first_name} {$article->admin_author->last_name}
                        {/if}
                        </span>
                        on {$article->created_at|date_format:'M d, Y'}</p>
                        <p class="text-gray">{if strlen($article->title) > 45}
                            {$article->summary|truncate:180}
                            {else}
                            {$article->summary|truncate:250}
                            {/if}...</p>
                    </div>
                    <div class="col-md-12 articleFooter">
                        <a href="#" class="text-gray shareIcon" style="visibility: hidden;">
                            <img src="{$MEDIA_FILES_URL}images/share.jpg" class="padding-right-10 margin-3">{if isset($article->share_count)}{$article->share_count}{/if} SHARES
                        </a>
                        <div class="socicalIcon articleShareIcon">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank">
                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg">
                            </a>
                            <a href="https://plus.google.com/share?url={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank">
                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                            <a href="https://twitter.com/home?status={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank">
                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                            <a href="#"><img class="margin-3" src="{$MEDIA_FILES_URL}images/pin.jpg" ng-hide="true"></a>
                            <a href="#"><img class="margin-3" src="{$MEDIA_FILES_URL}images/instagram.jpg" ng-hide="true"></a>
                            <a href="#"><img class="margin-3" src="{$MEDIA_FILES_URL}images/youtube.jpg" ng-hide="true"></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank">
                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-xs"></div>
            {if $smarty.foreach.latest.index % 2 == 1}
            <div class="clearfix visible-sm visible-md visible-lg"></div>
            {/if}
            <!-- <div class="clearfix" ng-if="$index%2 == 2"></div> -->
        {/foreach}
        {/if}
        
        <div class="clearfix"></div>
        {if $response.allArticlesCount > 9}
        <div class="articlePagination col-xs-12">
            <ul class="pagination">
                <!-- displayHide -->
                {if $response.allArticlesCountPagination.curPage > 1}
                <li class="previous">
                    <a href="{$APP_BASE_URL}infographics/page/{$response.allArticlesCountPagination.prev}"><i class="fa fa-angle-double-left"></i> Previous</a></li>
                {/if}
                {foreach from=$response.allArticlesCountPagination.pages item=page}
                <li {if $page == $response.allArticlesCountPagination.curPage}class="active"{/if}>
                    <a href="{$APP_BASE_URL}infographics/page/{$page}">{$page}</a>
                </li>
                {/foreach}
                {if $response.allArticlesCountPagination.curPage < $response.allArticlesCountPagination.lastPage}
                <li class="next">
                    <a href="{$APP_BASE_URL}infographics/page/{$response.allArticlesCountPagination.next}">Next <i class="fa fa-angle-double-right"></i></a></li>
                {/if}
            </ul>
        </div>
        {/if}
    </div>
    <div class="col-xs-12 article" ng-show="showPopular">
        {if isset($response.popularArticles)}
        {foreach from=$response.popularArticles item=article name=latest}
            <div class="col-xs-12 col-sm-6 singleInfographic singleArticle" single-article-hover>
                <div class="col-xs-12 col-sm-6 no-padding">
                    <div class="col-xs-12 padding-bottom-5 no-padding infographicHeader">
                        <a href="{$APP_BASE_URL}infographics/category/{$article->category->title|lower}"><span class="infographicType text-blue">{$article->category->title|upper}</span></a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 no-padding infographicTypeImg">
                        <a href="{$APP_BASE_URL}infographic/{$article->perma_link|lower}">
                            <img src="{$MEDIA_FILES_URL}uploads/images/articles/{$article->id}/{$article->thumbnail_image}" class="img-responsive width_100">
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 no-padding">
                    <div class="col-xs-12 no-padding text-light-gray infographicComments pull-right text-right">
                        <span>{$article->comments|count}</span> COMMENTS
                    </div>
                    <div class="col-xs-12">
                        <h3 class="text-bold font-family-bold">
                            <a href="{$APP_BASE_URL}infographic/{$article->perma_link|lower}" class="linkDarkBlack">{$article->title}</a>
                        </h3>
                        <p>By 
                            <span class="authorName text-blue">
                        {if isset($article->author) && $article.author != null}
                            {$article->author->first_name} {$article->author->last_name}
                        {else}
                            {$article->admin_author->first_name} {$article->admin_author->last_name}
                        {/if}
                        </span>
                        on {$article->created_at|date_format:'M d, Y'}</p>
                        <p class="text-gray">{if strlen($article->title) > 45}
                            {$article->summary|truncate:180}
                            {else}
                            {$article->summary|truncate:250}
                            {/if}...</p>
                    </div>
                    <div class="col-md-12 articleFooter">
                        <a href="#" class="text-gray shareIcon" style="visibility: hidden;">
                            <img src="{$MEDIA_FILES_URL}images/share.jpg" class="padding-right-10 margin-3"> SHARES
                        </a>
                        <div class="socicalIcon articleShareIcon">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank">
                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg">
                            </a>
                            <a href="https://plus.google.com/share?url={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank">
                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                            <a href="https://twitter.com/home?status={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank">
                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                            <a href="#"><img class="margin-3" src="{$MEDIA_FILES_URL}images/pin.jpg" ng-hide="true"></a>
                            <a href="#"><img class="margin-3" src="{$MEDIA_FILES_URL}images/instagram.jpg" ng-hide="true"></a>
                            <a href="#"><img class="margin-3" src="{$MEDIA_FILES_URL}images/youtube.jpg" ng-hide="true"></a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank">
                                <img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-xs"></div>
            {if $smarty.foreach.latest.index % 2 == 1}
            <div class="clearfix visible-sm visible-md visible-lg"></div>
            {/if}
            <!-- <div class="clearfix" ng-if="$index%2 == 2"></div> -->
        {/foreach}
        {/if}
        
        <div class="clearfix"></div>
        {if $response.allArticlesCount > 9}
        <div class="articlePagination col-xs-12">
            <ul class="pagination">
                <!-- displayHide -->
                {if $response.allArticlesCountPagination.curPage > 1}
                <li class="previous">
                    <a href="{$APP_BASE_URL}infographics/page/{$response.allArticlesCountPagination.prev}"><i class="fa fa-angle-double-left"></i> Previous</a></li>
                {/if}
                {foreach from=$response.allArticlesCountPagination.pages item=page}
                <li {if $page == $response.allArticlesCountPagination.curPage}class="active"{/if}>
                    <a href="{$APP_BASE_URL}infographics/page/{$page}">{$page}</a>
                </li>
                {/foreach}
                {if $response.allArticlesCountPagination.curPage < $response.allArticlesCountPagination.lastPage}
                <li class="next">
                    <a href="{$APP_BASE_URL}infographics/page/{$response.allArticlesCountPagination.next}">Next <i class="fa fa-angle-double-right"></i></a></li>
                {/if}
            </ul>
        </div>
        {/if}
    </div>
</div>

{/block}
{block name="js"}    
    <script src="{$MEDIA_FILES_URL}js/bower_components/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="{$MEDIA_FILES_URL}js/tag-it.min.js" type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
    <script src="{$MEDIA_FILES_URL}js/bower_components/adapters/jquery.js" type="text/javascript"></script>
    <script src="{$MEDIA_FILES_URL}js/ckEditorCode.js" type="text/javascript"></script>
{/block}