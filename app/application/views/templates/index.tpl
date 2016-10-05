{extends file='layouts/layout.tpl'}

{block name="css"}
    <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/carousel.css">
    <link rel="stylesheet" href="{$MEDIA_FILES_URL}css/pgwslider.min.css">
{/block}

{block name="js"}
    <script src="{$JS_FILES}jquery.gallery.js"></script>
    <script src="{$JS_FILES}modernizr.custom.53451.js"></script>
    <script src="{$JS_FILES}pgwslider.min.js"></script>
{/block}

{block name="content"}

<div class="banner container-fluid no-padding">
    <div id="homePageBanner" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <!-- <ol class="carousel-indicators">
        <li data-target="#homePageBanner" data-slide-to="0" class="active"></li>
      </ol> -->
      <div class="carousel-inner" role="listbox">
        <div class="item active" id="item1">
          <img class="hidden-xs first-slide width_100" src="{$MEDIA_FILES_URL}images/Cover Page.jpg" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h1 class="text-extra-large"><span class="bg-darkorange padding-horizontal-5">Return 2 India</span></h1>
              <p>The web's most interactive community with all the resources you need to consider all informed move back</p>
              <a class="btn btn-lg btn-box-blue registerButton" href="#" role="button" {if isset($smarty.session) && isset($smarty.session.session_user)} style="display: none;"{/if}>Register Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="featured col-xs-12 no-padding margin-top-50" id="waterwheel-carousel">
    <div class="col-xs-12 center">
        <p class="text-brightorange text-45">Featured</p>
        <p class="width_65 center-margin padding-bottom-15">An exclusive community for Indians who want to move contribute to the promising India story. This is your go to place on the web for all resources to help you make informed decisions.</p>
    </div>
    <div id="dg-container" class="hidden-xs col-xs-12 dg-container">
        <div class="dg-wrapper">
            {if isset($response.featured) && $response.featured|count > 0}
                {foreach from=$response.featured item=article name=featured}   
                    {if $article->type_id == 1}
                    <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}" class="col-xs-12 no-padding imgDivLink">
                    {else if $article->type_id == 2}
                    <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}" class="col-xs-12 no-padding imgDivLink">
                    {else if $article->type_id == 3}
                    <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}" class="col-xs-12 no-padding imgDivLink">
                    {/if}
                        <h3>{if strlen($article->title) > 30}
                            {$article->title|truncate:35}...
                            {else}
                            {$article->title}
                            {/if}</h3>
                        {if $smarty.foreach.featured.index == 0}
                        <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->featured_image_large}&w=560&h=310" class="img-responsive width_100" />
                        {else}
                        <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->featured_image_large}&w=560&h=310" class="img-responsive width_100" />
                        {/if}
                    </a>
                {/foreach}
            {/if}
        </div>
        <nav>   
            <span class="dg-prev"><i class="fa fa-angle-left"></i></span>
            <span class="dg-next"><i class="fa fa-angle-right"></i></span>
        </nav>
    </div>
    <ul class="pgwSlider visible-xs" id="feature_mobile">
        {if isset($response.featured) && $response.featured|count > 0}
            {foreach from=$response.featured item=article name=featured}  
                <li> 
                {if $article->type_id == 1}
                <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}" class="col-xs-12 no-padding imgDivLink">
                {else if $article->type_id == 2}
                <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}" class="col-xs-12 no-padding imgDivLink">
                {else if $article->type_id == 3}
                <a href="{$APP_BASE_URL}insight/{$article->perma_link|lower}" class="col-xs-12 no-padding imgDivLink">
                {/if}
                    <h3>{if strlen($article->title) > 30}
                            {$article->title|truncate:40}
                            {/if}...</h3>
                    {if $smarty.foreach.featured.index == 0}
                    <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->featured_image_large}&w=270&h=270" class="img-responsive width_100" />
                    {else}
                    <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->featured_image_large}&w=270&h=270" class="img-responsive width_100" />
                    {/if}
                </a>
                </li>
            {/foreach}
        {/if}
    </ul>
</div>
<div class="clearfix"></div>
<div class="container" ng-cloak>
    <div class="selectCategory">
        <div class="clearfix"></div>
        <div class="col-xs-12 padding-top-30 padding-bottom-per-5">
            <div class="col-xs-12 col-sm-8 col-md-6 no-padding padding-bottom-10">
                {literal}
                <button class="btn btn-box-grey col-xs-4" ng-class="{'active':showLatest}" ng-click="showLatestArticles();">LATEST</button>
                <button class="btn btn-box-grey col-xs-4 margin-left-10" ng-class="{'active':showPopular}"  ng-click="showPopularArticles();">POPULAR</button>
                {/literal}
            </div>
        </div>
    </div>
        
    <div class="col-xs-12 article no-padding margin-bottom-10" ng-show="showLatest">
        {if isset($response.latest) && $response.latest|count > 0}
        {foreach from=$response.latest item=article name=latest}
        {if $smarty.foreach.latest.index > 3}
        {else}
            <div class="col-xs-12 col-sm-6 col-md-3 singleArticle" single-article-hover>
                <div class="clearfix"></div>
                <div class="col-md-12 no-padding articleImg">
                    <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}">
                        <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->thumbnail_image}&w=270&h=270" class="img-responsive width_100">
                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 articleContent homePageArticle no-padding">
                    <h4 class="text-bold center">
                        <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}" class="text-dark-gray">{$article->title}</a></h4>
                    <p class="text-gray center text-medium">
                        {$article->content|strip_tags|truncate:200}</p>
                </div>
                <div class="col-xs-12">
                    <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}" class="btn btn-box-darkblue readmore margin-vertical-per-12">Read More</a>
                </div>
            </div>
            {if $smarty.foreach.latest.index%3 == 0}
            <div class="clearfix visible-xs"></div>
            {/if}
            {if $smarty.foreach.latest.index%3 == 1}
            <div class="clearfix visible-sm"></div>
            {/if}
            {if $smarty.foreach.latest.index%3 == 2}
            <div class="clearfix visible-xs"></div>
            {/if}
        {/if}
        {/foreach}
        {/if}
    </div>
    <div class="col-xs-12 article no-padding" ng-show="showPopular">
        {if isset($response.popular) && $response.popular|count > 0}
            {foreach from=$response.popular item=article name=popular}
            {if $smarty.foreach.popular.index > 3}
            {else}
            <div class="col-xs-12 col-sm-6 col-md-3 singleArticle" single-article-hover>
                <div class="clearfix"></div>
                <div class="col-md-12 no-padding articleImg">
                    <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}">
                        <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->thumbnail_image}&w=270&h=270" class="img-responsive width_100">
                    </a>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 articleContent homePageArticle no-padding">
                    <h4 class="text-bold center">
                       <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}" class="text-dark-gray">{$article->title}</a></h4>
                    <p class="text-gray center text-medium">
                        {$article->content|strip_tags|truncate:200}</p>
                </div>
                <div class="col-xs-12">
                    <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}" class="btn btn-box-darkblue readmore margin-vertical-per-12">Read More</a>
                </div>
            </div>
            {if $smarty.foreach.popular.index%3 == 0}
            <div class="clearfix visible-xs"></div>
            {/if}
            {if $smarty.foreach.popular.index%3 == 1}
            <div class="clearfix visible-sm"></div>
            {/if}
            {if $smarty.foreach.popular.index%3 == 2}
            <div class="clearfix visible-xs"></div>
            {/if}
            {/if}
            {/foreach}
            {/if}
        </div>

    <div class="col-xs-12 no-padding" {if $response.latestVideos|count > 0 && $response.popularVideos|count > 0} style="display:block" {else} style="display:none" {/if}>
        <p class="text-brightorange center text-45 margin-vertical-per-6">Videos</p>
    </div>
      
    <div class="col-xs-12 article no-padding margin-bottom-10" ng-show="showLatest">
        {if isset($response.latestVideos) && $response.latestVideos|count > 0}
        {foreach from=$response.latestVideos item=video name=latestVideos}
        {if $smarty.foreach.latestVideos.index > 3}
        {else}
            <div class="col-xs-12 col-sm-6 col-md-3 singleArticle" single-article-hover>
                <div class="clearfix"></div>
                <div class="col-md-12 no-padding articleImg">
                    <div class="videoLink">
                        <a href="{$APP_BASE_URL}insight/{$video->perma_link|lower}">
                            <p style="position:absolute; width:100%; height:100%; top:0">
                            </p>
                        </a>
                        <iframe src="https://www.youtube.com/embed/{$video->video_id}" height="270" width="100%" allowfullscreen="" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 articleContent homePageArticle no-padding">
                    <h4 class="text-bold center">
                        <a href="{$APP_BASE_URL}insight/{$video->perma_link|lower}" class="text-dark-gray">{$video->title}</a>
                </div>
                <div class="col-xs-12">
                    <a href="{$APP_BASE_URL}insight/{$video->perma_link|lower}" class="btn btn-box-darkblue readmore margin-vertical-per-12">Read More</a>
                </div>
            </div>
            {if $smarty.foreach.latest.index%3 == 0}
            <div class="clearfix visible-xs"></div>
            {/if}
            {if $smarty.foreach.latest.index%3 == 1}
            <div class="clearfix visible-sm"></div>
            {/if}
            {if $smarty.foreach.latest.index%3 == 2}
            <div class="clearfix visible-xs"></div>
            {/if}
        {/if}
        {/foreach}
        {/if}
    </div>
    <div class="col-xs-12 article no-padding" ng-show="showPopular">
        {if isset($response.popularVideos) && $response.popularVideos|count > 0}
        {foreach from=$response.popularVideos item=video name=popularVideos}
        {if $smarty.foreach.popularVideos.index > 3}
        {else}
            <div class="col-xs-12 col-sm-6 col-md-3 singleArticle" single-article-hover>
                <div class="clearfix"></div>
                <div class="col-md-12 no-padding articleImg">
                   <div class="videoLink">
                        <a href="{$APP_BASE_URL}insight/{$video->perma_link|lower}">
                            <p style="position:absolute; width:100%; height:100%; top:0">
                            </p>
                        </a>
                        <iframe src="https://www.youtube.com/embed/{$video->video_id}" height="270" width="100%" allowfullscreen="" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 articleContent homePageArticle no-padding">
                    <h4 class="text-bold center">
                        <a href="{$APP_BASE_URL}insight/{$video->perma_link|lower}" class="text-dark-gray">{$video->title}</a></h4>
                </div>
                <div class="col-xs-12">
                    <a href="{$APP_BASE_URL}insight/{$video->perma_link|lower}" class="btn btn-box-darkblue readmore margin-vertical-per-12">Read More</a>
                </div>
            </div>
            {if $smarty.foreach.latest.index%3 == 0}
            <div class="clearfix visible-xs"></div>
            {/if}
            {if $smarty.foreach.latest.index%3 == 1}
            <div class="clearfix visible-sm"></div>
            {/if}
            {if $smarty.foreach.latest.index%3 == 2}
            <div class="clearfix visible-xs"></div>
            {/if}
        {/if}
        {/foreach}
        {/if}
        </div>


    <!-- Sponsors -->
    <div class="col-xs-12 sponsors">
        <p class="text-brightorange center text-45 margin-vertical-per-6">Partners</p>
        <div class="col-xs-6 col-sm-3 no-padding">
            <img src="{$MEDIA_FILES_URL}images/sponsors/microsoft.png" class="img-reponsive" />
        </div>

        <div class="col-xs-6 col-sm-3 no-padding">
            <img src="{$MEDIA_FILES_URL}images/sponsors/Samsung.png" class="img-reponsive" />
        </div> 

        <div class="col-xs-6 col-sm-3 no-padding">
            <img src="{$MEDIA_FILES_URL}images/sponsors/emc2.png" class="img-reponsive" />
        </div> 

        <div class="col-xs-6 col-sm-3 no-padding">
            <img src="{$MEDIA_FILES_URL}images/sponsors/amazon.png" class="img-reponsive" />
        </div> 
    </div>   
</div>
{/block}