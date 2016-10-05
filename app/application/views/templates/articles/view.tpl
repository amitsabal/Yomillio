{extends file='layouts/layout.tpl'}

{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/articleView.css" />
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/jquery.tagit.css">
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/tagit.ui-zendesk.css">
<script type="text/javascript">
    var articleId = {$response.article->id};
    var commentsCount = {$response.article->comments|count};
</script>

{/block}

{block name="meta"}
{assign article $response.article}

{if isset($article->id)}
    {if isset($article->meta)}
    <meta content="{$article->meta->description}" name="description" />
    <meta content="{$article->meta->author}" name="author" />
    <meta content="{$article->meta->keywords}" name="keywords" />
    
    <meta property="og:title" content="{$article->meta->ogTitle}" />
    <meta property="og:type" content="{$article->meta->ogType}" />
    <meta property="og:image" content="{$article->meta->ogImage}" />
    <meta property="og:description" content="{$article->meta->ogDescription}" />
    {/if}
{/if}
{/block}

{block name="content"}
<!-- Article Content -->
{assign article $response.article}


{include file='popups/newarticle.popup.tpl'}
<div class="viewAllArticle bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.pageTitle|upper}</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
               <li><a href="{$APP_BASE_URL}articles" class="text-dark-gray">Articles</a></li>
              <li class="active">View</li>
            </ol>
        </div>
    </div>
</div>
<div class="articlePageContent" ng-model="article">
    <div class="container bg-white">
        <div class="col-xs-12 no-padding padding-vertical-50"> 
            <!-- Article Author Name -->
                <!-- Article Image & News Letter -->
            <div class="col-xs-12 visible-xs no-padding">
            <!-- Article Heading -->
                <div class="col-xs-3 no-padding pull-right">
                    <a href="{$APP_BASE_URL}article/create"><button class="btn btn-box-orange pull-right">NEW ARTICLE</button></a>
                </div>
            </div>
            {if isset($article->id)}
            <div class="col-xs-12 no-padding">
                <div class="col-xs-12 col-sm-9 no-padding padding-right-10">                    
                <div class="col-xs-3 col-sm-1 date no-padding">
                    <div class="padding-5 background-box-grey width_90 center">
                        <p class="text-gray text-extra-large no-margin padding-5">{$article->published_at|date_format:'M'|UPPER}</p>
                        <p class="text-gray text-24 text-bold no-margin">{$article->published_at|date_format:'d'}</p>
                    </div>
                </div>                
                <div class="btn-group col-xs-9 col-sm-11">
                    <h1 class="text-extra-extra-large font-family-bold padding-top-20 text-metallic-blue">{$article->title}</h1>
                </div>
                
                <div class="clearfix"></div>
                
            <div class="col-xs-12 no-padding margin-top-25">
                    <div class="shareButton bg-white fixedShare hidden-xs hidden-sm" fixed-share>
                        {if $article->type_id == 1}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://plus.google.com/share?url={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://twitter.com/home?status={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
                        {else if $article->type_id == 3}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://plus.google.com/share?url={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://twitter.com/home?status={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
                        {/if}
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-xs-3 col-sm-1 no-padding">
                        {if !isset($article->author_img)}
                        <img src="{$MEDIA_FILES_URL}images/Admin_new.png" class="width_90 center-margin border-2-orange radius-5">
                        {else}
                        <img src="{$article->author_img}" class="width_90 center-margin border-2-orange radius-5">
                        {/if}
                    </div>
                    <div class="col-sm-11 col-xs-9">
                        <div class="col-xs-12 margin-top-25 no-padding">
                            {if $article->type_id != 3}
                            <span>
                                <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->banner_image}" alt="Article Image" class="img-responsive width_100 radius-3 border-bottom-light-grey"/>
                            </span>
                            {/if}
                            {if $article->type_id == 3}
                            <span>
                                <div class= "embed-responsive embed-responsive-75  radius-3 border-bottom-light-grey">{$article->video_link}</div>
                            </span>
                            {/if}
                        </div>
                        <!-- <div class="clearfix"></div>
                        <div class="shareButton margin-top-25 hidden-md hidden-lg">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank" class="margin-right-10">
                                <img src="{$MEDIA_FILES_URL}images/facebookButton.jpg" alt="">
                            </a>
                            <a href="https://plus.google.com/share?url={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank" class="margin-right-10">
                                <img src="{$MEDIA_FILES_URL}images/TwitterButton.jpg" alt="">
                            </a>
                        </div> -->
                        <div class="clearfix"></div>
                        <!-- Article Information -->
                        <div class="articleInformation margin-top-25">
                            {if $article->type_id == 1}
                            <div class="font-family-light">{$article->content}</div>
                            {else}
                            <div class="font-family-light">{$article->summary}</div>
                            {/if}
                        </div>
                        <div class="clearfix"></div>
                        {if $article->content != ''}
                        <div class="shareButton margin-top-25 hidden-md hidden-lg">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank" class="margin-right-10">
                                <img src="{$MEDIA_FILES_URL}images/facebookButton.jpg" alt="">
                            </a>
                            <a href="https://plus.google.com/share?url={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank" class="margin-right-10">
                                <img src="{$MEDIA_FILES_URL}images/TwitterButton.jpg" alt="">
                            </a>
                        </div>
                        {/if}       

                        <div class="text-medium text-gray margin-top-25">Posted By<span class="text-medium text-orange">
                            {$article->author} </span>
                        </div>             
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                </div>
                <!-- Comments -->
                    {include file='widgets/comments.tpl'}
					
                    {include file='widgets/prev_next_articles.tpl'}
                </div>
                <div class="col-xs-12 col-sm-3 no-padding padding-left-10">
                    <div class="col-xs-12 hidden-xs no-padding">
                        <!-- Article Heading -->
                        <div class="col-xs-3 no-padding pull-right">
                            <a href="{$APP_BASE_URL}article/create"><button class="btn btn-box-orange pull-right newArticle ">NEW ARTICLE</button></a>
                        </div>
                    </div>
                    
                    {include file='widgets/related_articles.tpl'}
                    
                    {include file='widgets/article_tags.tpl'}
                </div>
                
                <!-- Recommended -->
                {include file='widgets/recommended_articles.tpl'}
                {else}
                <div class="col-xs-12 no-padding margin-top-25">
                    No Articles Found!
                </div>
                {/if}
            </div>            
        </div>
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