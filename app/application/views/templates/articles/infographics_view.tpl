{extends file='layouts/layout.tpl'}

{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/infographic.css" />
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/jquery.tagit.css">
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/tagit.ui-zendesk.css">
<script type="text/javascript">
    var articleId = {$response.article->id};
    var commentsCount = {$response.article->comments|count};
</script>
{/block}

{block name="js"}
<script src="{$MEDIA_FILES_URL}js/infographic.js"></script>
<script src="{$MEDIA_FILES_URL}js/bower_components/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="{$MEDIA_FILES_URL}js/tag-it.min.js" type="text/javascript"></script>
<script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script src="{$MEDIA_FILES_URL}js/bower_components/adapters/jquery.js" type="text/javascript"></script>
<script src="{$MEDIA_FILES_URL}js/ckEditorCode.js" type="text/javascript"></script>
{/block}

{block name="content"}

{include file='popups/newarticle.popup.tpl'}  

{assign article $response.article}
<!-- View Full Image -->
<div class="viewFullInfographicImg" ng-model="article">
	<div class="infographicContainer"></div>
	<div class="position-relative">
		<img src="{$MEDIA_FILES_URL}uploads/images/articles/{$article->id}/{$article->banner_image}" alt="Infographic Image" class="infographicImgFull img-responsive">
		<span class="closeFullImgIcon">
			<img src="{$MEDIA_FILES_URL}images/close-button.png">
		</span>
	</div>
</div>

<!-- Infographic Content -->
<div class="infographicArticle margin-top-20" ng-model="article">
	<div class="container bg-white">
		<div id="loadingArticleView" class="text-center loading"></div>
		<div class="col-xs-12 padding-top-10">
			<a href="{$APP_BASE_URL}infographics/category/{$article->category|lower}"><span class="infographicType">{$article->category|upper}</span></a>
            <div id="add_new_article"><span class="inner_page_new_article pull-right">New Article</span></div>
			<div class="clearfix"></div>
			<!-- Infographic Heading -->
			<h1 class="font-family-bold text-45 text-bold">{$article->title}</h1> 
			<div class="clearfix"></div>
			<!-- Infographic Author Name -->
			<div class="col-xs-12 no-padding">
				<div class="pull-left padding-right-10">
					{if !isset($article->author_img)}
                    <img src="{$MEDIA_FILES_URL}images/Admin.png" class="img-circle" width="38" height="38">
                    {else}
                    <img src="{$article->author_img}" class="img-circle" width="38" height="38">
                    {/if}
				</div>
				<div class="pull-left">
					<span class="text-small">{$article->published_at|date_format:'M d, Y'}</span><br>
					<span class="text-small">
						BY
						<span class="infographicAuthorName padding-right-5 text-blue">{$article->author}</span> |
                        <a href="#" ng-click="showInfographicComments()">
    						<span class="infographicNoOfComment padding-left-5 text-blue" ng-bind="commentsCount"> </span>
    						<span class="infographicNoOfComment padding-left-5 text-blue"> COMMENTS</span>
                        </a>
					</span>
				</div>
			</div>
			<!-- Infographic Image & News Letter -->
			<div class="col-xs-12 no-padding margin-top-30">

				<div class="shareButton bg-white fixedShare hidden-xs hidden-sm" fixed-share>
					{if $article->type_id == 2}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/facebook.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://plus.google.com/share?url={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://twitter.com/home?status={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                        <div class="clearfix"></div>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank"><img class="margin-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
                    {/if}
				    <div class="clearfix"></div>
				</div>
                
				<a class="infographicImg" href="#">
					<img src="{$MEDIA_FILES_URL}uploads/images/articles/{$article->id}/{$article->banner_image}" alt="Article Image" class="img-responsive width_100"/>
					<span class="inforgaphicViewFull">
						<img src="{$MEDIA_FILES_URL}images/full.png">
					</span>
				</a>
				<div class="clearfix"></div>
				<div class="shareButton margin-top-10 hidden-md hidden-lg">
					<a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank" class="margin-right-10"><img src="{$MEDIA_FILES_URL}images/facebook.jpg"></a>
					<a href="https://twitter.com/home?status={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank" class="margin-right-10"><img src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
				</div>
                
				<div class="clearfix"></div>
				<!-- Infographic Information -->
				<div class="infographicInformation margin-top-10">
					<!-- <span class="text-65 pull-left padding-right-10 text-blue">T</span> -->
					<div class="font-family-light">{$article->content}</div>
				</div>
				<div class="clearfix"></div>
                {if $article->content != ''}
				<div class="shareButton margin-top-10 hidden-md hidden-lg">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank" class="margin-right-10"><img src="{$MEDIA_FILES_URL}images/facebook.jpg"></a>
					<a href="https://twitter.com/home?status={$APP_BASE_URL}infographic/{$article->perma_link|lower}" target="_blank" class="margin-right-10"><img src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
                </div>
                {/if}
                <div class="clearfix"></div>
				<!-- Artical Tags -->
				<div class="infographicTagsDiv col-xs-12 no-padding margin-top-30">
					<p class="text-medium">
						<span class="text-bold">TAGS</span>
                        {foreach  from=$article->tags item=tag}
                        <span class="infographicTag"><a href="{$APP_BASE_URL}infographics/tag/{$tag|lower}">{$tag}</a></span>
                        {/foreach}
					</p>
				</div>
				<div class="clearfix"></div>
                
				<!-- PRE & NEXT Infographic -->
				<div class=" col-xs-12 col-md-8 no-padding margin-top-30">
                        <div class="col-xs-12 col-sm-6 no-left-padding preArticleDiv">
                            {if isset($article->previous_article)}
                            {if $article->previous_article->type_id == 1}
                            <a href="{$APP_BASE_URL}article/{$article->previous_article->perma_link|lower}" class="linkDarkBlack width_100">
                            {else if $article->previous_article->type_id == 2}
                            <a href="{$APP_BASE_URL}infographic/{$article->previous_article->perma_link|lower}" class="linkDarkBlack width_100">
                            {else}
                            <a href="{$APP_BASE_URL}video/{$article->previous_article->perma_link|lower}" class="linkDarkBlack width_100">
                            {/if}
                            
                                <p><i class="fa fa-angle-left"></i> READ PREVIOUS</p>
                                <div class="col-xs-12 no-padding preNextArticle preNextInfographic">
                                    <div class="col-xs-7 no-left-padding">
                                        <p>{$article->previous_article->title}</p>
                                    </div>
                                    <div class="col-xs-5 no-padding">
                                        <img src="{$MEDIA_FILES_URL}uploads/images/articles/{$article->previous_article->id}/{$article->previous_article->thumbnail_image}" class="img-responsive width_100" alt="">
                                    </div>
                                </div>
                            </a>
                            {/if}
                        </div>
                        <div class="col-xs-12 col-sm-6 no-right-padding nextArticleDiv">
                            {if isset($article->next_article)}
                            {if $article->next_article->type_id == 1}
                            <a href="{$APP_BASE_URL}article/{$article->next_article->perma_link|lower}" class="linkDarkBlack pull-right width_100">
                            {else if $article->next_article->type_id == 2}
                            <a href="{$APP_BASE_URL}infographic/{$article->next_article->perma_link|lower}" class="linkDarkBlack pull-right width_100">
                            {else}
                            <a href="{$APP_BASE_URL}video/{$article->next_article->perma_link|lower}" class="linkDarkBlack pull-right width_100">
                            {/if}
                            
                                <p class="pull-right">READ NEXT <i class="fa fa-angle-right"></i></p>
                                <div class="col-xs-12 no-padding preNextArticle preNextInfographic">
                                    <div class="col-xs-5 no-padding">
                                        <img src="{$MEDIA_FILES_URL}uploads/images/articles/{$article->next_article->id}/{$article->next_article->thumbnail_image}" class="img-responsive width_100" alt="">
                                    </div>
                                    <div class="col-xs-7 no-right-padding">
                                        <p>{$article->next_article->title}</p>
                                    </div>
                                </div>
                            </a>
                            {/if}
                        </div>
                    </div>
			</div>
			<!-- Recommended -->
			<div class="clearfix"></div>
            <div class="recommended col-xs-12 no-padding margin-top-50">
                <div class="recommendedHeading col-xs-12 no-padding">
                    <h3 class="text-blue">
                        <span class="pull-left padding-right-10">RECOMMENDED </span><br>
                        <hr class="recommendedHeadingLine">
                    </h3>
                </div>
                <div class="clearfix"></div>
                <div class="recommendedContentDiv padding-top-10 col-xs-12 no-padding">
                	{if isset($article->recommended_articles)}
                        {foreach from=$article->recommended_articles item=recomended}
                        <span>
                            {if $recomended->type_id == 1}
                            <a class="col-xs-12 col-sm-6 col-md-3 margin-bottom-20" href="{$APP_BASE_URL}article/{$recomended->perma_link|lower}">
                            {else if $recomended->type_id == 2}
                            <a class="col-xs-12 col-sm-6 col-md-3 margin-bottom-20" href="{$APP_BASE_URL}infographic/{$recomended->perma_link|lower}">
                            {else}
                            <a class="col-xs-12 col-sm-6 col-md-3 margin-bottom-20" href="{$APP_BASE_URL}video/{$recomended->perma_link|lower}" video-play-hover>
                            {/if}
                            
                                <!--<div class="recomendedImg" style="background: url({$MEDIA_FILES_URL}uploads/images/articles/{$recomended->id}/{$recomended->banner_image}) center center no-repeat;">-->
                                <div class="recomendedImg">
                                    <img src="{$MEDIA_FILES_URL}uploads/images/articles/{$recomended->id}/{$recomended->banner_image}" style="height: 200px" />
                                    {if $recomended->type_id == 3}
                                    <div class="videoImgContent">
                                        <div class="videoImgPlayButton">
                                            <span class="videoPlayImg">
                                                <img src="{$MEDIA_FILES_URL}images/play.png" class="play" alt="">
                                                <img src="{$MEDIA_FILES_URL}images/play1.png" class="playHover" alt="">
                                            </span>
                                        </div>
                                    </div>
                                    {/if}
                                </div>
                                <div class="recommendedContent padding-top-10">
                                    <p class="text-extra-large font-family-medium">{$recomended->title}</p>
                                </div>
                            </a>
                        </span>
                        {/foreach}
                        {/if}
                </div>
            </div>
            
			<!-- Comments -->
            <div class="clearfix"></div>
            <div class="infographicCommentDiv col-xs-12 col-md-8 no-padding">
                <div class="numberOfComment numberOfInfographicCommentDiv" tabindex="-1">
                    THERE ARE <i class="text-blue" ng-bind="commentsCount"> </i>  COMMENTS.
                    <a href="#" class="padding-left-5 linkBlue" ng-click="infographicCommentShow()"> SOMTHING TO SAY? </a>
                </div>
                {foreach from=$article->comments item=comment}
                <div class="infographicComment padding-top-20">
                    <div class="padding-right-10 commenterName">
                    	<a href="{$comment->linkedin_profile_url}" target="_blank">
                            {if isset($comment->linkedin_picture_url) && strlen(trim($comment->linkedin_picture_url)) > 0}
                                <img src="{$comment->linkedin_picture_url}" alt="" width="38" height="38" class="img-circle" />
                            {else if isset($comment->profile_pic) && strlen(trim($comment->profile_pic)) > 0}
                                <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$comment->profile_pic}" alt="" width="38" height="38" class="img-circle" />
                            {else}
                                <img src="{$MEDIA_FILES_URL}/images/user.png" alt="" width="38" height="38"/>
                            {/if}
                            
                        </a>
                        <span class="infographicCommenterName font-family-medium text-bold text-blue">{$comment->first_name} {$comment->last_name}</span>
                    </div>
                    <div class="infographicRelatedComment margin-top-10">
                        <p class="infographicCommenterName font-family-medium">{$comment->comment}</p>
                    </div>
                   
                    <span class="text-medium">{$comment->created_at|date_format:'M d, Y'}</span><br>
                    <div class="clearfix"></div>
                </div>
                {/foreach}
                {literal}
                <div class="articleComment padding-top-20" ng-repeat="comment in comments">
                    <div class="padding-right-10 commenterName">
                        <a href="{{comment.linkedin_profile_url}}" target="_blank" ng-if="comment.linkedin_picture_url != null && comment.linkedin_picture_url != ''">
                            <span ng-if="comment.linkedin_picture_url == null && comment.profile_pic == null">
                                <img src="{/literal}{{$MEDIA_FILES_URL}}{literal}/images/user.png" alt="" width="38" height="38"/>
                            </span>
                            
                            <span ng-if="comment.linkedin_picture_url != null && comment.linkedin_picture_url != ''">
                                <img src="{{comment.linkedin_picture_url}}" alt="" width="38" height="38" class="img-circle" />
                            </span>
                            
                            <span ng-if="comment.profile_pic != null  && comment.profile_pic != ''">
                                <img src="{{comment.profile_pic}}" alt="" width="38" height="38" class="img-circle"/>
                            </span>
                            
                        </a>
                        <span class="articleCommenterName font-family-medium text-bold text-blue" ng-bind="comment.first_name+' '+comment.last_name"></span>
                    </div>
                    <div class="articleRelatedComment margin-top-10">
                        <p class="articleCommenterName" ng-bind="comment.comment"></p>
                    </div>
                   
                    <span class="text-medium" ng-bind="comment.created_at | customDateFormat | date:'MMM dd, yyyy'"></span><br>
                    <div class="clearfix"></div>
                </div>
                <div class="articleCommentHere col-xs-12 no-padding margin-top-20 margin-bottom-20" id="infographic_comment_here">
                    <div class="toCommentLogin text-bold" before-log-in-display>
                        SOMTHING TO SAY? <a href="#" class="btn-blue logInButton">LOG IN</a> OR <a href="#" class="btn-blue signUpButton"> SIGN UP</a>
                    </div>
                    <div class="toCommentHere" after-log-in-display ng-model="comment">
                        <form name="commentForm" ng-submit="addComment(comment);">
                            <textarea class="width_100" id="commentArea" rows="4" cols="50"  ng-model="comment.comment" placeholder="Enter Comment" class="form-control" required></textarea>
                            <button class="btn btn-blue pull-right commentsubmit" type="submit">Comment</button>
                        </form>
                    </div>
                </div>
                {/literal}
            </div>
		</div>
	</div>
</div>

{/block}