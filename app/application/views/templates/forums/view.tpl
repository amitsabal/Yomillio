{extends file='layouts/layout.tpl'}


{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/forum.css">
{/block}

{block name="content"}

{assign forum $response.forum}

<!-- Forum Headding -->
<div class="viewAllArticle bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>FORUM : {$forum->category->title|upper}</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li><a href="{$APP_BASE_URL}forums" class="text-dark-gray">Forums</a></li>
              <li class="active">View</li>
            </ol>
        </div>
    </div>
</div>
<!-- Related Catogery -->
<!--<div class="container bg-light-blue no-padding" ng-controller="forumController">
	<div class="filterForum">
		<!-- <p class="pull-left text-medium no-margin font-family-light padding-vertical-5 text-white text-bold">FILTER</p> -->
		<!-- <ul>
            {if isset($response.forumcategories)}
                <li><a href="{$APP_BASE_URL}forums">ALL FORUMS</a></li>
                {foreach from=$response.forumcategories name=category item=category}
                    {if $smarty.foreach.category.index < 3}
                    <li><a href="{$APP_BASE_URL}forums/category/{$category->title|lower|urlencode}" {if $forum->category->title|lower == $category->title|lower}class="active"{/if}>{$category->title|upper}</a></li>
                    {/if}
                    {if $smarty.foreach.category.index >= 3}
                        {if $smarty.foreach.category.index == 3}
                            <li class="pull-right">
                                <div class="dropdown">
                                    <a href="#" class="linkWhite dropdown-toggle" type="button" id="forumMore" data-toggle="dropdown">MORE <i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu articleDropdown" role="menu" aria-labelledby="forumMore">
                        {/if}
                                        <li><a href="{$APP_BASE_URL}forums/category/{$category->title|lower|urlencode}">{$category->title|upper}</a></li>
                        {if $smarty.foreach.category.last}
                                    </ul>
                                </div>
                            </li>
                        {/if}
                    {/if}
                {/foreach}
            {/if}
		</ul>
	</div>
</div>-->
<div class="container bg-white" ng-controller="forumController">
    
	<div class="col-xs-12 padding-vertical-50">
		<div class="col-xs-12 visible-xs no-padding margin-bottom-20">
			<div class="col-xs-4 pull-right no-padding">
				<button class="btn btn-box-orange pull-right" id="add_new_threads">NEW THREAD</button>
			</div>
		</div>
		<div class="col-xs-12 col-md-9 no-left-padding xs-no-padding">
			<div class="col-xs-3 col-sm-1 date no-padding">
	            <div class="padding-5 background-box-grey width_90 center">
	                <p class="text-gray text-extra-large no-margin padding-5">{$forum->created_at|date_format:'M'|UPPER}</p>
	                <p class="text-gray text-24 text-bold no-margin">{$forum->created_at|date_format:'d'}</p>
	            </div>
	        </div>
	        <div class="btn-group col-sm-11 col-xs-9">
	            <p class="text-extra-extra-large font-family-bold padding-top-20 text-metallic-blue"> {$forum->title}</p>
	        </div>
			<!-- Forum Author Name -->
			<div class="clearfix"></div>
			<div class="col-xs-12 no-padding margin-top-25">
				<div class="col-xs-3 col-sm-1 no-padding">
                    {if isset($forum->author->linkedin_picture_url) && strlen(trim($forum->author->linkedin_picture_url)) > 0}
                        <img src="{$forum->author->linkedin_picture_url}" alt="" class="width_90 center-margin border-2-orange radius-5" />
                    {else if isset($forum->author->profile_pic) && strlen(trim($forum->author->profile_pic)) > 0}
                        <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$forum->author->profile_pic}" alt="" class="width_90 center-margin border-2-orange radius-5"/>
                    {else}
                        <img src="{$MEDIA_FILES_URL}/images/user.png" alt="" class="width_90 center-margin border-2-orange radius-5"/>
                    {/if}
				</div>
				<div class=" col-sm-11 col-xs-9">

					<div class="summary text-gray">						
						<p>	
							{$forum->summary|nl2br}
						</p>
					</div>
					<div class="text-medium text-gray">Posted By<span class="text-medium text-orange"> {$forum->author->first_name} {$forum->author->last_name}</span> in <a href="{$APP_BASE_URL}forums/category/{$forum->category->title|lower|urlencode}" class="text-orange">{$forum->category->title}</a></div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="shareButton bg-white pull-left margin-top-25">
	            <a href="https://www.facebook.com/sharer/sharer.php?u={$APP_BASE_URL}forum/{$forum->perma_link|lower}" target="_blank"><img class="margin-right-3" src="{$MEDIA_FILES_URL}images/facebook.jpg"></a>
	            <a href="https://plus.google.com/share?url={$APP_BASE_URL}forum/{$forum->perma_link|lower}" target="_blank"><img class="margin-right-3" src="{$MEDIA_FILES_URL}images/google-plus.jpg"></a>
	            <a href="https://twitter.com/home?status={$APP_BASE_URL}forum/{$forum->perma_link|lower}" target="_blank"><img class="margin-right-3" src="{$MEDIA_FILES_URL}images/twitter.jpg"></a>
	            <a href="https://www.linkedin.com/shareArticle?mini=true&url={$APP_BASE_URL}forum/{$forum->perma_link|lower}" target="_blank"><img class="margin-right-3" src="{$MEDIA_FILES_URL}images/linkedin.jpg"></a>
			</div>
			<div class="likeUnlike pull-right text-large margin-top-25" ng-model="forumVote">
				<a class="linkGrayHover" href="#" ng-click="voteForForum(forumVote,1)">
					<i class="fa fa-thumbs-o-up"></i> <span id="forumVoteUp"> {$forum->vote_up}</span>
				</a>
				<a class="linkGrayHover padding-left-10" href="#"  ng-click="voteForForum(forumVote,0)">
					<i class="fa fa-thumbs-o-down"></i> <span id="forumVoteDown"> {$forum->vote_down}</span>
				</a>
			</div>
			<div class="clearfix"></div>
			<!-- <div class="shareButton margin-top-10 hidden-md hidden-lg">
				<a href="#" target="_blank" class="margin-right-10">
					<img src="{$MEDIA_FILES_URL}images/facebookButton.jpg" alt="">
				</a>
				<a href="#" target="_blank" class="margin-right-10">
					<img src="{$MEDIA_FILES_URL}images/TwitterButton.jpg" alt="">
				</a>
			</div> -->
			<hr>
			<div class="clearfix"></div>

			<!-- Comment Section -->
			<div class="forumCommentDiv col-xs-12 no-padding">
                {if $forum->answers|count > 0}
                <p class="text-large text-bold text-gray margin-bottom-20">ANSWERS</p>
                {foreach from=$forum->answers|@array_reverse item=answer name=answer}
                <div class="clearfix"></div>
				<div class="col-xs-12 no-padding margin-bottom-per-6">
					<div class="col-xs-3 col-sm-1 no-padding">
                        {if isset($answer->author->linkedin_picture_url) && strlen(trim($answer->author->linkedin_picture_url)) > 0}
                            <img src="{$answer->author->linkedin_picture_url}" alt="" class="width_90 center-margin border-2-orange radius-5" />
                        {else if isset($answer->author->profile_pic) && strlen(trim($answer->author->profile_pic)) > 0}
                            <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$answer->author->profile_pic}" alt="" class="width_90 center-margin border-2-orange radius-5" />
                        {else}
                            <img src="{$MEDIA_FILES_URL}/images/user.png" alt="" class="width_90 center-margin border-2-orange radius-5"/>
                        {/if}
					</div>
					<div class="col-xs-9 col-sm-11">
						<div class="margin-top-10 leter-spacing">
							<p class="text-medium padding-top-10 text-gray">	
								<span class="text-medium font-family-bold text-blue">Best answers: </span>{$answer->answer|nl2br}
							</p>
						</div>
						<div class="text-medium text-gray">Posted By <span class="text-medium text-orange"> {$answer->author->first_name} {if isset($answer->author->lastName)}{$answer->author->last_name}{/if}</span> Date 
						<span class="text-medium">
							{$answer->created_at|date_format:'M d, Y '}
						</span> Time <span class="text-medium">
							{$answer->created_at|date_format: 'h:i A'}
						</span>
					</div>
						<div class="col-xs-12 text-large no-padding margin-top-10">
							<a class="linkGrayHover" href="#" ng-click="voteForAnswer({$answer->id},1);">
								<i class="fa fa-thumbs-o-up"></i> <span id="forumAnswerVoteUp{$answer->id}">{$answer->vote_up}</span>
							</a>
							<a class="linkGrayHover padding-left-10" href="#" ng-click="voteForAnswer({$answer->id},0);">
								<i class="fa fa-thumbs-o-down"></i> <span id="forumAnswerVoteDown{$answer->id}">{$answer->vote_down}</span>
							</a>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
                {/foreach}
                {/if}
			</div>
			<div class="clearfix"></div>
			<!-- Comment Area -->
			<div class="col-xs-12 no-padding forumTextAreaBackGround" ng-controller="forumController">
				<div class="col-xs-12 no-padding">
                    <input type="hidden" name="forum_id" id="forum_id" value="{$forum->id}" ng-model="forumanswer.forum_id" />
                    <input type="hidden" name="user_id" id="user_id" value="" ng-model="forumanswer.user_id" />
					<!-- <div class="pull-left padding-right-10">
						<img src="{$MEDIA_FILES_URL}images/Admin.png" class="img-circle commentor-image" width="38" height="38">
					</div>
					<div class="pull-left commenterName"> -->
						<!--<span class="text-large font-family-medium text-blue" ng-if="firstName != undefined" ng-bind="firstName+' '+lastName"> </span>
                        <span class="text-large font-family-medium text-blue" ng-if="firstName == undefined || firstName == null">Anonymous </span>
						<span class="text-large font-family-medium text-blue username"></span>
					</div>-->
					<p class="text-large text-bold text-gray">YOUR ANSWERS</p>
					<textarea name="answer" id="answer" class="width_100 margin-top-10 padding-10" rows="8" cols="50"  ng-model="forumanswer.answer"></textarea>
					<div class="clearfix"></div>
					<div class="col-xs-12 no-padding margin-top-20">
                    <div class="col-xs-12 col-md-12 no-padding">
                        <div class="col-xs-3 col-xs-offset-2">
                        <label for="forum_tags">Enter Secure Code <span class="text-red">*</span> : </label>
                        <img id="captcha" src="{$APP_BASE_URL}captcha" alt="CAPTCHA Image" style="border: 1px solid #000; margin-right: 15px" />
                        </div>
                        <div class="col-xs-4">                        
                        <input type="text" name="captcha_code" id="captcha_code" size="10" maxlength="6" ng-model="forumanswer.captcha_code" />
                        <a href="#" onclick="document.getElementById('captcha').src = '{$APP_BASE_URL}captcha?' + Math.random(); return false">
                            <img src="{$MEDIA_FILES_URL}images/refresh.png" height="32" width="32" alt="Reload Image" onclick="this.blur()" align="bottom" border="0">
                        </a>
                        </div>
                        <span class="col-xs-12 label label-danger">{if isset($response.error) && isset($response.error.captcha_code)}{$response.error.captcha_code}{/if}</span>
                    </div>
                </div>
					<div class="padding-top-20">
						<button class="btn btn-box-orange submitAnswerButton" ng-click="postAnswer(forumanswer);" ng-disabled="disablePost">SUBMIT</button>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<hr>
			
			<div class="col-xs-12 no-padding margin-top-30 margin-bottom-20">
				<div class="col-xs-12 col-sm-6 no-left-padding preArticleDiv">
                    {if isset($response.previous_forum)}
					<a href="{$APP_BASE_URL}forum/{$response.previous_forum->perma_link}" class="linkDarkBlack"><p><i class="fa fa-angle-left"></i> READ PREVIOUS</p></a>
					<a href="{$APP_BASE_URL}forum/{$response.previous_forum->perma_link}" class="col-xs-12 linkDarkBlack no-padding preNextForum">
						<div class="col-xs-12 no-left-padding">
							<p class="text-large font-family-bold">{$response.previous_forum->title}</p>
						</div>
					</a>
                    {/if}
				</div>
				<div class="col-xs-12 col-sm-6 no-right-padding nextArticleDiv">
                    {if isset($response.next_forum)}
					<a href="{$APP_BASE_URL}forum/{$response.next_forum->perma_link}" class="linkDarkBlack"><p class="pull-right">READ NEXT <i class="fa fa-angle-right"></i></p></a>
					<a href="{$APP_BASE_URL}forum/{$response.next_forum->perma_link}" class="col-xs-12 no-padding linkDarkBlack preNextForum">
						<div class="col-xs-12 no-right-padding">
							<p class="text-large font-family-bold">{$response.next_forum->title}</p>
						</div>
					</a>
                    {/if}
				</div>
			</div>
		</div>
		
		<div class="col-xs-12 col-sm-3 no-right-padding">			
			<div class="col-xs-12 hidden-xs no-padding margin-bottom-20">
				<div class="col-xs-4 pull-right no-padding">
					<button class="btn btn-box-orange pull-right newThread" id="add_new_threads">NEW THREAD</button>
				</div>
			</div>
			<div class="clearfix"></div>
	        <div ng-controller="forumController">
	            <h4 class="text-bold text-gray padding-vertical-10 no-top-margin">CATEGORIES</h4>
	            <div class="filterForum">
	                <!-- <p class="pull-left text-medium no-margin font-family-light padding-vertical-5 text-white text-bold">FILTER</p> -->
	                <ul>
	                    {if isset($response.forumcategories)}
	                        <li><i class="fa fa-arrow-circle-right text-orange"></i><a href="{$APP_BASE_URL}forums">ALL FORUMS</a></li>
	                        {foreach from=$response.forumcategories name=category item=category}
	                            {if $smarty.foreach.category.index < 4}
	                            <li><i class="fa fa-arrow-circle-right text-orange"></i><a href="{$APP_BASE_URL}forums/category/{$category->title|lower|urlencode}">{$category->title|UPPER}</a></li>
	                            {/if}
	                            
	                            {if $smarty.foreach.category.index >= 4}
	                                {if $smarty.foreach.category.index == 4}
	                                    <li>
	                                        <div class="dropdown categorydropdown">
	                                            <ul class="articleDropdown">
	                                {/if}
	                                            <li><i class="fa fa-arrow-circle-right text-orange"></i><a href="{$APP_BASE_URL}forums/category/{$category->title|lower|urlencode}">{$category->title|UPPER}</a></li>
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
	             <h4 class="text-bold text-gray padding-vertical-10">TRENDING POSTS</h4>
	            <div class="recentpost">
	                {if isset($response.trending_forums)}
	                    <ul>
	                    	{foreach from=$response.trending_forums item=trending name=trending}
	                        <li>
	                            <div class="col-xs-12 padding-vertical-10 border-bottom border-dark">
	                                <div class="col-xs-1 no-padding">
	                                    <i class="fa fa-chevron-right"></i>
	                                </div>
	                                <div class="col-xs-11 no-padding">
	                                    <a href="{$APP_BASE_URL}forum/{$trending->perma_link}" class="text-metallic-blue text-bold">{$trending->title}</a>
	                                   
	                                </div> <div class="text-gray">{$trending->created_at|date_format:'d M y'}</div>
	                            </div>
	                        </li>
	                    {/foreach}
	                    </ul>
	                    {/if}
	            </div>
	            <!-- <div class="clearfix"></div>
	             <h4 class="text-bold text-gray padding-vertical-10">ARHIEVE</h4>
	            <div class="archieve">
	                <ul>
	                    <li><i class="fa fa-arrow-circle-right text-gray"></i>2015</li>
	                    <li><i class="fa fa-arrow-circle-right text-gray"></i>2014</li>
	                    <li><i class="fa fa-arrow-circle-right text-gray"></i>2013</li>
	                </ul>
	            </div> -->
	        </div>
	    </div>
	</div>
</div>

{/block}