{extends file='layouts/layout.tpl'}


{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/forum.css">
{/block}

{block name="content"}

{assign pag_url strstr(uri_string(), 'page/', true) }
{if strlen(trim($pag_url)) <= 0}{assign pag_url uri_string()|cat:"/"}{/if}

<!-- Forum Headding -->

<input type="hidden" id="currentShowType"  name="currentShowType" value="{if isset($response.currentShowType)}{$response.currentShowType}{/if}" />
<div class="forumHeader bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>FORUMS {if $response.selectedCategory}: {$response.selectedCategory|urldecode|upper}{/if}</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li class="active">Forums</li>
            </ol>
        </div>
    </div>
</div>

<!-- Related Catogery -->

<div class="container bg-white">   
    <div class="selectCategory">
        <div class="col-xs-12 padding-vertical-50">
            <div class="col-xs-12 col-sm-7 no-padding pull-right">
                <button class="btn btn-box-orange pull-right newThread" id="add_new_threads">NEW THREAD</button>
            </div>
            <div class="col-xs-12 col-sm-5 col-md-5 no-padding text-orange">
                <h2 class="no-margin">Recent Threads</h2>
            </div>

        </div>       
    </div>
	<div class="col-xs-12 col-sm-9 no-padding" ng-show="showLatest">
        <div class="sortby row no-margin forumList border-bottom-light-grey border-width-1 padding-right-1">
            <div class="col-xs-3 col-sm-1 date no-padding text-dark-gray">Sort by :</div> 
            <div class="col-xs-6 col-sm-9 border-horizontal-light-grey border-width-1 sortbyfields">
                 {literal}
                 <button class="btn forumSortButton text-dark-gray" ng-class="{'active':showLatest}" ng-click="showLatestArticles();">Latest</button>
                <button class="btn margin-left-10 forumSortButton text-dark-gray" ng-class="{'active':showPopular}"  ng-click="showPopularArticles();">Popular</button>
                 {/literal}
            </div>
            <div class="col-xs-3 col-sm-2 border-width-1 view_replies">
                <div class="comments text-dark-gray">Views</div>
                <div class="replies text-dark-gray">Replies</div>
            </div>
            <div class="horizontalLine col-xs-12 no-margin border-width-2 padding-right-1">            
            </div>
        </div>

		{if isset($response.forums)}
		<!--<pre>{print_r($response.trending_forums)}</pre>-->
        {foreach from=$response.forums name=forum item=forum}
            <div class="row no-margin forumList border-bottom-light-grey border-right-light-grey  border-width-1 bg-glass-grey">
                <div class="col-xs-3 col-sm-1 date padding-vertical-20">
                    {if isset($forum->author->linkedin_picture_url) && strlen(trim($forum->author->linkedin_picture_url)) > 0}
                        <img src="{$forum->author->linkedin_picture_url}" alt="" class="img-responsive center-margin width_85 border-2-orange" />
                    {else if isset($forum->author->profile_pic) && strlen(trim($forum->author->profile_pic)) > 0}
                        <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$forum->author->profile_pic}" alt=""  class="img-responsive center-margin width_85 border-2-orange"/>
                    {else}
                        <img src="{$MEDIA_FILES_URL}/images/user.png" alt=""  class="img-responsive center-margin width_85 border-2-orange"/>
                    {/if}
                </div>
                <div class="col-xs-6 col-sm-9 border-horizontal-light-grey border-width-1 padding-20">
                    <h4 class="no-top-margin"><a href="{$APP_BASE_URL}forum/{$forum->perma_link|lower}" class="text-sky-blue">{$forum->title|truncate:45}</a></h4>
                    <p class="text-gray text-medium">By {$forum->author->first_name} {$forum->author->last_name} in <a href="{$APP_BASE_URL}forums/category/{$forum->category->title|lower|urlencode}" class="text-gray">{$forum->category->title}</a>, <span>{$forum->created_at|date_format:'M d, Y'} at {$forum->created_at|date_format:'h:i A'} </span> </p>
                    <!-- <p class="text-gray padding-vertical-15">{$forum->summary}</p>
                    <a href="{$APP_BASE_URL}forum/{$forum->perma_link|lower}" class="text-orange">Continue reading &nbsp; <i class="fa fa-arrow-right"></i></a> -->
                </div>
                <div class="col-xs-3 col-sm-2 border-width-1 padding-20">
                    <div class="col-xs-7 no-padding">
                        <div class="comments text-gray margin-bottom-10">{$forum->view_count}</div>
                    </div>
                    <div class="col-xs-2 no-padding"> <i class="fa fa-eye"></i></div>
                    <div class="clearfix"></div>
                    <div class="col-xs-7 no-padding"><div class="replies text-gray">{$forum->answers|count}</div></div>
                    <div class="col-xs-2 no-padding"> <i class="fa fa-reply"></i></i></div>
                </div>
            </div>
            <div class="clearfix"></div>
        {foreachelse}
            <h3 class="no-top-margin">No Forums Found!</h3>
        {/foreach}
        {else}
            <h3 class="no-top-margin">No Forums Found!</h3>
        {/if}

		<div class="clearfix"></div> 
		<div class="col-xs-12 no-padding">
			{if $response.count > 10}
            <div class="articlePagination margin-bottom-20 col-xs-12">
                <ul class="pagination">
                    <!-- displayHide -->
                    {if $response.forumsPagination.curPage > 1}
                    <li class="previous">
                        <a href="{$APP_BASE_URL}{$pag_url}page/{$response.forumsPagination.prev}"><i class="fa fa-angle-left"></i></a></li>
                    {/if}
                    {foreach from=$response.forumsPagination.pages item=page}
                    <li {if $page == $response.forumsPagination.curPage}class="active"{/if}>
                        <a href="{$APP_BASE_URL}{$pag_url}page/{$page}">{$page}</a>
                    </li>
                    {/foreach}
                    {if $response.forumsPagination.curPage < $response.forumsPagination.lastPage}
                    <li class="next">
                        <a href="{$APP_BASE_URL}{$pag_url}page/{$response.forumsPagination.next}"><i class="fa fa-angle-right"></i></a></li>
                    {/if}
                </ul>
            </div>
            {/if}
		</div>
	</div>
    
    <div class="col-xs-12 col-sm-9 no-padding" ng-show="showPopular">
        <div class="sortby row no-margin forumList border-bottom-light-grey border-width-1 padding-right-1">
            <div class="col-xs-3 col-sm-1 date no-padding text-dark-gray">Sort by :</div> 
            <div class="col-xs-6 col-sm-9 border-horizontal-light-grey border-width-1 sortbyfields">
                 {literal}
                 <button class="btn forumSortButton text-dark-gray" ng-class="{'active':showLatest}" ng-click="showLatest=true;showPopular=false;">Latest</button>
                <button class="btn margin-left-10 forumSortButton text-dark-gray" ng-class="{'active':showPopular}"  ng-click="showLatest=false;showPopular=true;">Popular</button>
                 {/literal}
            </div>
            <div class="col-xs-3 col-sm-2 border-width-1 view_replies">
                <div class="comments text-dark-gray">Views</div>
                <div class="replies text-dark-gray">Replies</div>
            </div>
            <div class="horizontalLine col-xs-12 no-margin border-width-2 padding-right-1">            
            </div>
        </div>
		{if isset($response.popular_forums)}
            {foreach from=$response.popular_forums name=forum item=forum}
            <div class="row no-margin forumList border-bottom-light-grey border-right-light-grey border-width-1 bg-glass-grey">
                <div class="col-xs-3 col-sm-1 date padding-vertical-20">
                    {if isset($forum->author->linkedin_picture_url) && strlen(trim($forum->author->linkedin_picture_url)) > 0}
                        <img src="{$forum->author->linkedin_picture_url}" alt="" class="img-responsive center-margin width_85 border-2-orange" />
                    {else if isset($forum->author->profile_pic) && strlen(trim($forum->author->profile_pic)) > 0}
                        <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$forum->author->profile_pic}" alt=""  class="img-responsive center-margin width_85 border-2-orange"/>
                    {else}
                        <img src="{$MEDIA_FILES_URL}/images/user.png" alt=""  class="img-responsive center-margin width_85 border-2-orange"/>
                    {/if}
                </div>
                <div class="col-xs-6 col-sm-9 border-horizontal-light-grey border-width-1 padding-20">
                    <h4 class="no-top-margin"><a href="{$APP_BASE_URL}forum/{$forum->perma_link|lower}" class="text-sky-blue">{$forum->title|truncate:45}</a></h4>
                    <p class="text-gray text-medium">By {$forum->author->first_name} {$forum->author->last_name} in <a href="{$APP_BASE_URL}forums/category/{$forum->category->title|lower|urlencode}" class="text-gray">{$forum->category->title}</a>, <span>{$forum->created_at|date_format:'M d, Y'} at {$forum->created_at|date_format:'h:i A'} </span> </p>
                    <!-- <p class="text-gray padding-vertical-15">{$forum->summary}</p>
                    <a href="{$APP_BASE_URL}forum/{$forum->perma_link|lower}" class="text-orange">Continue reading &nbsp; <i class="fa fa-arrow-right"></i></a> -->
                </div>
                <div class="col-xs-3 col-sm-2 border-width-1 padding-20">
                    <div class="col-xs-7 no-padding">
                        <div class="comments text-gray margin-bottom-10">{$forum->view_count}</div>
                    </div>
                    <div class="col-xs-2 no-padding"> <i class="fa fa-eye"></i></div>
                    <div class="clearfix"></div>
                    <div class="col-xs-7 no-padding"><div class="replies text-gray">{$forum->answers|count}</div></div>
                    <div class="col-xs-2 no-padding"> <i class="fa fa-reply"></i></i></div>
                </div>
            </div>
            
            <div class="clearfix"></div>
        {foreachelse}
            <h3 class="no-top-margin">No Forums Found!</h3>
        {/foreach}
        {else}
            <h3 class="no-top-margin">No Forums Found!</h3>
        {/if}
			
		<div class="clearfix"></div> 
		<div class="col-xs-12 no-padding">
            {if $response.count > 10}
            <div class="articlePagination margin-bottom-20 col-xs-12">
                <ul class="pagination">
                    <!-- displayHide -->
                    {if $response.forumsPagination.curPage > 1}
                    <li class="previous">
                        <a href="{$APP_BASE_URL}{$pag_url}page/{$response.forumsPagination.prev}"><i class="fa fa-angle-left"></i></a></li>
                    {/if}
                    {foreach from=$response.forumsPagination.pages item=page}
                    <li {if $page == $response.forumsPagination.curPage}class="active"{/if}>
                        <a href="{$APP_BASE_URL}{$pag_url}page/{$page}">{$page}</a>
                    </li>
                    {/foreach}
                    {if $response.forumsPagination.curPage < $response.forumsPagination.lastPage}
                    <li class="next">
                        <a href="{$APP_BASE_URL}{$pag_url}page/{$response.forumsPagination.next}"><i class="fa fa-angle-right"></i></a></li>
                    {/if}
                </ul>
            </div>
            {/if}
		</div>
	</div>

    <div class="col-xs-12 col-sm-3">
        <div ng-controller="forumController">
            <h4 class="text-bold text-gray  padding-bottom-10 no-top-margin">CATEGORIES</h4>
            <div class="filterForum">
                <!-- <p class="pull-left text-medium no-margin font-family-light padding-vertical-5 text-white text-bold">FILTER</p> -->
                <ul>
                    {if isset($response.forumcategories)}
                        <li><i class="fa fa-arrow-circle-right text-orange"></i><a href="{$APP_BASE_URL}forums" {if $response.selectedCategory eq ''}class="active"{/if}>ALL FORUMS</a></li>
                        {foreach from=$response.forumcategories name=category item=category}
                            {if $smarty.foreach.category.index < 4}
                            <li><i class="fa fa-arrow-circle-right text-orange"></i><a href="{$APP_BASE_URL}forums/category/{$category->title|lower|urlencode}" {if $response.selectedCategory|lower eq $category->title|lower|urlencode}class="active"{/if}>{$category->title|UPPER}</a></li>
                            {/if}
                            
                            {if $smarty.foreach.category.index >= 4}
                                {if $smarty.foreach.category.index == 4}
                                    <li>
                                        <div class="dropdown categorydropdown">
                                            <ul class="articleDropdown">
                                {/if}
                                            <li><i class="fa fa-arrow-circle-right text-orange"></i><a href="{$APP_BASE_URL}forums/category/{$category->title|lower|urlencode}" {if $response.selectedCategory|lower eq $category->title|lower|urlencode}class="active"{/if}>{$category->title|UPPER}</a></li>
                                {if $smarty.foreach.category.last}
                                            </ul>
                                        </div>
                                        <a href="#" class="dropdown-toggle" type="button" id="forumMore"><span class="text-orange">MORE</span><span class="no-display text-orange">LESS</span></a>
                                    </li>
                                {/if}
                            {/if}
                        {/foreach}
                    {/if}
                </ul>
            </div>
            <div class="clearfix"></div>
             <h4 class="text-bold text-gray padding-vertical-10">TRENDING THREAD</h4>
            <div class="recentpost">
                {if isset($response.trending_forums)}
                    <ul>
                    {foreach from=$response.trending_forums item=popular name=popular}
                        <li>
                            <div class="col-xs-12 padding-vertical-10 border-bottom border-dark">
                                <div class="col-xs-1 no-padding">
                                    <i class="fa fa-chevron-right"></i>
                                </div>
                                <div class="col-xs-11 no-padding">
                                    <a href="{$APP_BASE_URL}forum/{$popular->perma_link}" class="text-metallic-blue text-bold">{$popular->title}</a>
                                    <div class="text-gray">{$popular->created_at|date_format:'d M y'}</div>
                                </div>
                            </div>
                        </li>
                    {/foreach}
                    </ul>
                    {/if}
            </div>
            <!-- <div class="clearfix"></div>
             <h4 class="text-bold text-gray padding-vertical-10">ARCHIVE</h4>
            <div class="archieve">
                <ul>
                    <li><i class="fa fa-arrow-circle-right text-gray"></i><a href="#" {if $response.selectedCategory eq ''}class="active"{/if}>2015</a></li>
                    <li><i class="fa fa-arrow-circle-right text-gray"></i><a href="#" {if $response.selectedCategory eq ''}class="active"{/if}>2014</a></li>
                    <li><i class="fa fa-arrow-circle-right text-gray"></i><a href="#" {if $response.selectedCategory eq ''}class="active"{/if}>2013</a></li>
                </ul>
            </div> -->
        </div>
    </div>
</div>

{/block}