{extends file='layouts/layout.tpl'}

{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/?f=articleView">
{/block}

{block name="js"}
<script src="{$MEDIA_FILES_URL}js/webpage.js"></script>
{/block}

{block name="content"}
<div class="viewAllArticle bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>{$response.webpage->webpage->title|upper}</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li class="active">{$response.webpage->webpage->title}</li>
            </ol>
        </div>
    </div>
</div>
<div class="container">
	<div class="col-xs-12 bg-white padding-top-30 word-warp" id="page_content">
	    {if isset($response.webpage->webpage->content)}
            {htmlspecialchars_decode($response.webpage->webpage->content)}
	    {/if}
    </div>
</div>
{/block}