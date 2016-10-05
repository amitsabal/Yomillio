{extends file='layouts/layout.tpl'}

{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/search.css">
{/block}

{block name="js"}
    <script type="text/javascript">
        pageName = '{$response.pageTitle|upper}';
    </script>
{/block}

{block name="content"}

{assign pag_url strstr(uri_string(), 'page/', true) }
{if strlen(trim($pag_url)) <= 0}{assign pag_url uri_string()|cat:"/"}{/if}

<div class="viewAllArticle bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.pageTitle|upper}</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li class="active">Search</li>
            </ol>
        </div>
    </div>
</div>
		<div class="container bg-white">
			<!-- Search Button -->
			
			<!-- Search Result -->
             <div class="col-xs-12 padding-vertical-50">
                <div class="col-xs-12 col-sm-7 no-padding pull-right">
                    <a href="{$APP_BASE_URL}article/create"><button class="btn btn-box-orange pull-right">NEW ARTICLE</button></a>
                    <div class="filterArticles col-xs-4 pull-right">
                        <button type="button" class="btn btn-box-blue dropdown-toggle filterArticlesbutton pull-right" data-toggle="dropdown">
                        <span data-bind="label" class="selectedCategory">{if !isset($response.selectedCategory) || $response.selectedCategory eq ''}ALL{else}{$response.selectedCategory|upper}{/if}</span>&nbsp;<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                    <a href="{$APP_BASE_URL}search/{$response.keyword|lower}" class="{if !isset($response.selectedCategory)}active{/if}">ALL</a>
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
                    <div class="input-group searchResultearch">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-md-12">
                            
                            <form  name="searchForm" method="post">
                            <div class="input-group">
                                <input type="text" class="form-control searchControl" placeholder="Search" id="searchControl" value="{if isset($response.keyword)}{urldecode($response.keyword|trim|upper)}{/if}" name="keyword"/>
                                <div class="input-group-btn">
                                    <button type="button" class="btn user-btn" onClick="document.forms['searchForm'].action='{$APP_BASE_URL}search/'+document.getElementById('searchControl').value;document.forms['searchForm'].submit();">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div><!-- /btn-group -->
                            </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /input-group -->
                <i class="text-gray">{$response.count} results</i>
                </div>
            </div>
			 
			{if isset($response.articles)}
            <div class="col-xs-12 no-padding">
                {foreach from=$response.articles item=article name=article}
                    <div class="singleSearchResult col-xs-12 no-padding">
                        <div class="col-xs-12 col-sm-6 searchResultImg no-padding">
                            <div class="col-md-12 no-padding resultTypeImg">
                                {if $article->type_id == 1}
                                <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}">
                                {else if $article->type_id == 3}
                                <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}" video-play-hover>
                                {else if $article->type_id == 2}
                                <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}">
                                {/if}
                                {if $article->type_id == 2}
                                <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->thumbnail_big_image}&w=570&h=270" class="img-responsive width_90 radius-3 border-bottom-light-grey">
                                {else if $article->type_id == 1}
                                <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->thumbnail_big_image}&w=570&h=270" class="img-responsive width_90 radius-3 border-bottom-light-grey">
                                {else}
                                <div class="videoLink">
                                    <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}">
                                        <p style="position:absolute; width:100%; height:100%; top:0">
                                        </p>
                                    </a>
                                    <iframe src="https://www.youtube.com/embed/{$article->video_id}" height="270" width="90%" allowfullscreen="" frameborder="0"></iframe>
                                </div>
                                {/if}
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 searchResultContent no-padding">
                            <h3 class="text-bold font-family-bold">
                                {if $article->type_id == 1}
                                <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}"  class="linkDarkBlack">
                                {else if $article->type_id == 3}
                                <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}" video-play-hover  class="linkDarkBlack">
                                {else if $article->type_id == 2}
                                <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}"  class="linkDarkBlack">
                                {/if}{$article->title}</a>
                            </h3>
                            <p class="text-blue">By <span class="authorName">
                                {if isset($article->author) && $article->author != '' && $article->author != null}
                                    {$article->author->first_name} {$article->author->last_name}
                                {elseif isset($article->admin_author) && $article->admin_author != '' && $article->admin_author != null}
                                    {$article->admin_author->first_name} {$article->admin_author->last_name}
                                {/if}
                                </span> on {$article->published_at|date_format}
                            </p>
                            <div class="text-gray searchResultContentDesc">
                                {$article->content|strip_tags|truncate:500}
                            </div>
                            <div class="socialLinks">
                                <div class="btn btn-box-blue inline-block">
                                    <i class="fa fa-link inline-block"></i>
                                </div> 
                                <div class="text-gray inline-block resultTypeComments">
                                {$article->comments|count} COMMENTS
                                </div>
                                <div class="articleFooter no-padding">
                                    <div class="socicalIcon articleShareIcon">
                                        {if $article->type_id == 1}
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}article/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
                                        {else if $article->type_id == 2}
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
                                        {else if $article->type_id ==3}
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg">
                                        </a>
                                        <a href="https://plus.google.com/share?url={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                                        <a href="https://twitter.com/home?status={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}insight/{$article->perma_link|lower}" target="_blank">
                                            <img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
                                        {/if}
                                    </div>
                                </div> 
                            </div>
                            {if $article->type_id == 1}
                            <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}" class="btn btn-box-blue articlereadmore">                                
                            {else if $article->type_id == 2}
                            <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}" class="btn btn-box-blue articlereadmore">
                            {else if $article->type_id == 3}
                            <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}" class="btn btn-box-blue articlereadmore">
                            {/if}
                        VIEW DETAILS</a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                {foreachelse}
                    <div class="singleSearchResult col-xs-12 no-padding" style="min-height: 135px">
                        <div class="col-xs-12 no-padding">
                            No Articles Found!
                        </div>
                    </div>
                    <div class="clearfix"></div>
                {/foreach}
            </div>
            {/if}
            
            {if $response.count > 5}
            <div class="articlePagination col-xs-12">
                <ul class="pagination">
                    <!-- displayHide -->
                    {if $response.allArticlesCountPagination.curPage > 1}
					<li class="previous">
						<a href="{$APP_BASE_URL}{$pag_url}page/{$response.allArticlesCountPagination.prev}"  ><i class="fa fa-angle-left"></i></a></li>
					{/if}
					{foreach from=$response.allArticlesCountPagination.pages item=page}
					<li {if $page == $response.allArticlesCountPagination.curPage}class="active"{/if}>
						<a href="{$APP_BASE_URL}{$pag_url}page/{$page}" class="text-white">{$page}</a>
					</li>
					{/foreach}
					{if $response.allArticlesCountPagination.curPage < $response.allArticlesCountPagination.lastPage}
					<li class="next">
						<a href="{$APP_BASE_URL}{$pag_url}page/{$response.allArticlesCountPagination.next}" class="text-white"> <i class="fa fa-angle-right"></i></a></li>
					{/if}
                </ul>
            </div>
            {/if}
		</div>

{/block}