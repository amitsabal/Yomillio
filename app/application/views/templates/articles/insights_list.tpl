{extends file='layouts/layout.tpl'}


{block name="css"}
    <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/viewAll.css">
{/block}


{block name="content"}

{assign pag_url strstr(uri_string(), 'page/', true) }
{if strlen(trim($pag_url)) <= 0}{assign pag_url uri_string()|cat:"/"}{/if}

<!-- Search Result Headding -->
{include file='popups/newarticle.popup.tpl'}    

<input type="hidden" id="currentShowInsightType"  name="currentShowInsightType" value="{if isset($response.currentShowType)}{$response.currentShowType}{/if}" />
<div class="viewAllInsights bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.pageTitle|upper}</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li class="active">Insights</li>
            </ol>
        </div>
    </div>
</div>

<!-- Filter of search result -->

<div class="container bg-white">
    <div class="selectCategory">
        <div class="col-xs-12 padding-vertical-50">
            <div class="col-xs-12 col-sm-7 no-padding pull-right">
                <a href="{$APP_BASE_URL}article/create"><button class="btn btn-box-orange newArticle pull-right">NEW ARTICLE</button></a>
                <div class="filterInsights col-xs-6 col-sm-8 col-md-9 pull-right">
                    <button type="button" class="btn btn-box-blue dropdown-toggle filterArticlesbutton pull-right" data-toggle="dropdown">
                    <span data-bind="label" class="selectedCategory">{if !isset($response.selectedCategory) || $response.selectedCategory eq ''}ALL{else}{$response.selectedCategory|upper}{/if}</span>&nbsp;<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        
                        <li>
                            <a href="{$APP_BASE_URL}search/" class="{if !isset($response.selectedCategory) || $response.selectedCategory eq ''}active{else}{/if}">ALL</a>
                        </li>
                        
                        {foreach from=$response.categories name=key item=category}
                            <li>
                                <a href="{$APP_BASE_URL}search/category/{$category->title|lower}" class="{if isset($response.selectedCategory) && $response.selectedCategory|lower == $category->title|lower}active{/if}">{$category->title|upper}</a>
                            </li>
                        {/foreach}
                        
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-5 no-padding">
                {literal}
                <button class="btn btn-box-grey col-xs-4 latestButton" ng-class="{'active':showLatest}" ng-click="showLatestInsights();">LATEST</button>
                <button class="btn btn-box-grey col-xs-4 margin-left-10 popularButton" ng-class="{'active':showPopular}"  ng-click="showPopularInsights();">POPULAR</button>
                {/literal}
            </div>
        </div>       
    </div>
    <div class="col-xs-12 article no-padding" ng-show="showLatest">
        <div id="loadingLatest" class="text-center loading"></div>
        {foreach $response.latestInsights as $key => $insights}
            <div class="clearfix"></div>
            <div ng-cloak>
                <div class="col-xs-12 singleArticle no-padding margin-bottom-10">
                    <div class="col-xs-12 col-sm-6 articleImg no-padding margin-bottom-5">
                        {if $insights->type_id == 2}
                        <a href="{$APP_BASE_URL}insight/{$insights->perma_link|lower}" class="linkBlack">
                            <img src="{$APP_BASE_URL}image/article?file_name={$insights->id}/{$insights->thumbnail_big_image}" class="img-responsive width_90 radius-3 border-bottom-light-grey">
                        </a>
                        {else if $insights->type_id == 3}
                            <div class="videoLink">
                                <a href="{$APP_BASE_URL}insight/{$insights->perma_link|lower}">
                                    <p style="position:absolute; width:100%; height:100%; top:0">
                                    </p>
                                </a>
                                <iframe src="https://www.youtube.com/embed/{$insights->video_id}" height="270" width="90%" allowfullscreen="" frameborder="0"></iframe>
                            </div>
                        {/if}
                    </div>
                    <div class="col-xs-12 col-sm-6 articleContent no-padding">
                        <h3 class="text-bold text-gray no-top-margin">
                        <a href="{$APP_BASE_URL}insight/{$insights->perma_link|lower}" class="linkBlack">
                            {$insights->title}</a></h3>
                            <p class="text-blue">By
                        <span class="authorName">
                            {if isset($insights->author) && $insights->author != '' && $insights->author != null}
                                {$insights->author->first_name} {$insights->author->last_name}
                            {elseif isset($insights->admin_author) && $insights->admin_author != '' && $insights->admin_author != null}
                                {$insights->admin_author->first_name} {$insights->admin_author->last_name}
                            {/if}
                        </span>
                        on <span>{$insights->published_at|date_format}</span></p>
                        <div class="text-gray articleContentDesc">
                                    {$insights->content|strip_tags|truncate:500}</div>
                            <div class="socialLinks">
                                <div class="btn btn-box-blue inline-block">
                                    <i class="fa fa-link inline-block"></i>
                                </div>                    
                                <div class="articleComments text-gray inline-block"><span>{count($insights->comments)}</span> COMMENTS</div>
                                <div class="articleFooter no-padding">
                                    <div class="socicalIcon articleShareIcon">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}insight/{$insights->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url={$APP_BASE_URL}insight/{$insights->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status={$APP_BASE_URL}insight/{$insights->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}insight/{$insights->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>           
                                    </div>
                                </div> 
                            </div>
                            <a href="{$APP_BASE_URL}insight/{$insights->perma_link|lower}" class="btn btn-box-blue articlereadmore">
                        VIEW DETAILS</a>
                    </div>
                </div>
                {if $key%3 == 0}
                    <div class="clearfix visible-xs"></div>
                {elseif $key%3 == 1}
                    <div class="clearfix visible-sm"></div>
                {elseif $key%3 == 2}
                    <div class="clearfix visible-md visible-lg"></div>
                {/if}
            </div>
        {/foreach}
        {if $response.allInsightsCount > 9}
        <div class="articlePagination col-xs-12">
            <ul class="pagination">
                {if $response.allInsightsPagination.curPage > 1}
                <li class="previous">
                    <a href="{$APP_BASE_URL}{$pag_url}page/{$response.allInsightsPagination.prev}"  ><i class="fa fa-angle-left"></i></a></li>
                {/if}
                {foreach from=$response.allInsightsPagination.pages item=page}
                <li {if $page == $response.allInsightsPagination.curPage}class="active"{/if}>
                    <a href="{$APP_BASE_URL}{$pag_url}page/{$page}" class="text-white">{$page}</a>
                </li>
                {/foreach}
                {if $response.allInsightsPagination.curPage < $response.allInsightsPagination.lastPage}
                <li class="next">
                    <a href="{$APP_BASE_URL}{$pag_url}page/{$response.allInsightsPagination.next}" class="text-white"> <i class="fa fa-angle-right"></i></a></li>
                {/if}
            </ul>
        </div>
        {/if}
    </div>
    <div class="col-xs-12 article no-padding" ng-show="showPopular">
        
        {foreach $response.popularInsights as $key => $insights}
            <div class="clearfix"></div>
            <div ng-cloak>
                <div class="col-xs-12 singleArticle no-padding margin-bottom-10">
                    <div class="col-xs-12 col-sm-6 articleImg no-padding margin-bottom-5">
                        {if $insights->type_id == 2}
                        <a href="{$APP_BASE_URL}insight/{$insights->perma_link|lower}" class="linkBlack">
                            <img src="{$APP_BASE_URL}image/article?file_name={$insights->id}/{$insights->thumbnail_big_image}" class="img-responsive width_90 radius-3 border-bottom-light-grey">
                        </a>
                        {else if $insights->type_id == 3}                        
                            <div class="videoLink">
                                <a href="{$APP_BASE_URL}insight/{$insights->perma_link|lower}">
                                    <p style="position:absolute; width:100%; height:100%; top:0">
                                    </p>
                                </a>
                                <iframe src="https://www.youtube.com/embed/{$insights->video_id}" height="270" width="90%" allowfullscreen="" frameborder="0"></iframe>
                            </div>
                        {/if}
                    </div>
                    <div class="col-xs-12 col-sm-6 articleContent no-padding">
                        <h3 class="text-bold text-gray no-top-margin">
                        <a href="{$APP_BASE_URL}insight/{$insights->perma_link|lower}" class="linkBlack">
                            {$insights->title}</a></h3>
                        <div class="text-gray articleContentDesc">
                                    {$insights->content|strip_tags|truncate:500}</div>
                            <div class="socialLinks">
                                <div class="btn btn-box-blue inline-block">
                                    <i class="fa fa-link inline-block"></i>
                                </div>                    
                                <div class="articleComments text-gray inline-block"><span>{count($insights->comments)}</span> COMMENTS</div>
                                <div class="articleFooter no-padding">
                                    <div class="socicalIcon articleShareIcon">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}insight/{$insights->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url={$APP_BASE_URL}insight/{$insights->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status={$APP_BASE_URL}insight/{$insights->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}insight/{$insights->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>                                        
                                    </div>
                                </div>  
                            </div>
                            <a href="{$APP_BASE_URL}insight/{$insights->perma_link|lower}" class="btn btn-box-blue articlereadmore">
                        VIEW DETAILS</a>
                    </div>
                </div>
                {if $key%3 == 0}
                    <div class="clearfix visible-xs"></div>
                {elseif $key%3 == 1}
                    <div class="clearfix visible-sm"></div>
                {elseif $key%3 == 2}
                    <div class="clearfix visible-md visible-lg"></div>
                {/if}
            </div>
        {/foreach}
        
        {if $response.allInsightsCount > 9}
        <div class="articlePagination col-xs-12">
            <ul class="pagination">
                <!-- displayHide -->
                {if $response.allInsightsPagination.curPage > 1}
                <li class="previous">
                    <a href="{$APP_BASE_URL}{$pag_url}page/{$response.allInsightsPagination.prev}" class="text-white"><i class="fa fa-angle-left"></i></a></li>
                {/if}
                {foreach from=$response.allInsightsPagination.pages item=page}
                <li {if $page == $response.allInsightsPagination.curPage}class="active"{/if}>
                    <a href="{$APP_BASE_URL}{$pag_url}page/{$page}" class="text-white">{$page}</a>
                </li>
                {/foreach}
                {if $response.allInsightsPagination.curPage < $response.allInsightsPagination.lastPage}
                <li class="next">
                    <a href="{$APP_BASE_URL}{$pag_url}page/{$response.allInsightsPagination.next}" class="text-white"><i class="fa fa-angle-right"></i></a></li>
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
    <script type="text/javascript">
        pageName = "{$response.pageTitle|upper}";
    </script>
{/block}