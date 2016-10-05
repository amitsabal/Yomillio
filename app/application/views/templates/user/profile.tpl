{extends file='layouts/layout.tpl'}

{block name="css"}
<link rel="stylesheet" href="{$MEDIA_FILES_URL}css/profile.css">

{/block}

<!-- {block name="js"}
<script src="{$MEDIA_FILES_URL}js/user.js"></script>
{/block} -->

{block name="content"}
<div class="viewAllArticle bg-light-gray" ng-model="type_id">
    <div class="container">
        <div class="col-xs-7 no-padding">
            <div class="font-family-light text-26 margin-vertical-10"><div class="arrow_box"></div>My Profile</div>
        </div>
        <div class="col-xs-5 no-padding">
            <ol class="breadcrumb">
              <li><a href="{$APP_BASE_URL}" class="text-dark-gray">Home</a></li>
              <li class="active">My Profile</li>
            </ol>
        </div>
    </div>
</div>

<div class="container bg-white" ng-model="user">
    <div class="col-xs-12 col-md-12 no-padding margin-top-30">
        <div class="col-xs-12 no-padding">
            <div class="col-xs-12 col-sm-4 no-left-padding">
                {if isset($response.profile->user->profile_pic)}
                <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$response.profile->user->profile_pic}" class="img-responsive pull-left">
                {else if isset($response.profile->user->linkedin_picture_url)  && strlen(trim($response.profile->user->linkedin_picture_url)) > 0}
                <img src="{$response.profile->user->linkedin_picture_url}" class="img-responsive pull-left">
                {else}
                <img src="{$MEDIA_FILES_URL}images/profile.png" class="img-responsive pull-left">
                {/if}
                <div class="text-blue pull-left profileUserName padding-left-10 col-xs-8">{$response.profile->user->first_name} {$response.profile->user->last_name}</div>
                <div class="col-xs-4 pull-right">
                    <a href="{$APP_BASE_URL}account/logout"><button class="btn btn-blue margin-top-20 profile-logout ">LOG OUT</button></a>
                </div>
                <div class="col-xs-12 no-left-padding margin-top-20">
                    <fieldset>
                        <legend>Profile</legend>
                        <ul class="profile-list list-group">
                            <li class="list-group-item"><a href="#update-profile"><i class="fa fa-user"></i>  My Profile</a></li>
                            {if ($response.profile->user->login_type != "linkedin")}
                            <li class="list-group-item"><a href="#account-settings"><i class="fa fa-cogs"></i>  Account Settings</a></li>
                            {/if}
                            <li class="list-group-item"><a href="#articles"><i class="fa fa-cogs"></i>  Articles</a></li>
                            <li class="list-group-item"><a href="#forums"><i class="fa fa-cogs"></i>  Forums</a></li>
                            <li class="list-group-item"><a href="#recent-activity"><i class="fa fa-paw"></i>  Recent Comments</a></li>
                            <li class="list-group-item">
                                <i class="fa fa-exclamation-triangle"></i> <a href="{$APP_BASE_URL}account/resetactivationkey/{$response.profile->user->activation_key}">Resend Activation Key</a>
                            </li>
                        </ul>
                    </fieldset>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8 no-right-padding">
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="update-profile">
                                        
                    <div class="col-xs-12 no-padding padding-10" >
                        <h3 class="no-margin">Update Profile</h3>
                        <div class="col-xs-12" id="profileListView">
                            <div class="col-xs-12 col-sm-4 no-padding">
                                <div class="profileupload  margin-top-20">   
                                    {if isset($response.profile->user->profile_pic)} 
                                        <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$response.profile->user->profile_pic}" class="img-responsive pull-left" alt="profile" id="profile_pic" style="height: 140px;">
                                    {else}
                                        <img src="{$MEDIA_FILES_URL}images/profile.png" class="img-responsive" alt="profile" id="profile_pic" style="height: 140px;" />
                                    {/if}                               
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">                                
                                <span class="input-icon margin-top-20">
                                    <label>Name :</label> {$response.profile->user->first_name} {$response.profile->user->last_name}
                                </span>
                                <span class="input-icon margin-top-20">
                                    <label>Job Title :</label> {$response.profile->user->linkedin_job_title}
                                </span>
                                <span class="input-icon margin-top-20">
                                    <label>Biodata :</label> {$response.profile->user->bio}
                                 </span>
                            </div>
                            <div class="clearfix"></div>
                                    <input type="button" value="EDIT" id="edit_profile" class="col-xs-4 col-sm-3 col-md-2 btn btn-blue margin-right-5 pull-right">
                        </div>
                        <form name="profileUpdate" action="{$APP_BASE_URL}user/updateprofile" method="post" enctype="multipart/form-data" id="profileUpdate" class="no-display" onsubmit="return ValidateProfile();">
                            <input type="hidden" name="curUrl" value="" />
                            <div class="col-xs-12 col-sm-4 no-padding">
                                <div class="profileupload  margin-top-20">
                                    {if isset($response.profile->user->profile_pic)} 
                                        <img src="{$MEDIA_FILES_URL}uploads/images/profile/{$response.profile->user->profile_pic}" class="img-responsive pull-left" alt="profile" id="profile_pic" style="height: 140px;">
                                    {else}
                                        <img src="{$MEDIA_FILES_URL}images/profile.png" class="img-responsive" alt="profile" id="profile_pic" style="height: 140px;" />
                                    {/if} 
                                    <div class="col-xs-12 uploadimg padding-5"><input type="file" name="profile_pic" id="profilePicUpload" data-file-type="png,jpg,jpeg" /><img src="{$MEDIA_FILES_URL}images/upload.png" /><span> UPLOAD</span></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <span class="input-icon margin-top-20">
                                    <input type="text" class="form-control" id="firstname" name="first_name" placeholder="First Name" maxlength="50" value="{$response.profile->user->first_name}" />
                                </span>
                                <span class="input-icon margin-top-20">
                                    <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Last Name" maxlength="50" value="{$response.profile->user->last_name}"/>
                                </span>	
                                <div class="clearfix"></div>
                                <span class="input-icon margin-top-20">
                                    <input type="text" class="form-control" id="jobtitle" name="linkedin_job_title" placeholder="Job Title" maxlength="256" value="{$response.profile->user->linkedin_job_title}" />
                                </span>	
                                <div class="clearfix"></div>
                                <span class="input-icon margin-top-20">
                                    <textarea type="text" class="form-control" id="biodata" name="bio" placeholder="Biodata" rows="4" >{$response.profile->user->bio}</textarea>
                                </span>
                                
                                <div class="col-xs-12 padding-vertical-10 padding-right-20">
                                    <button type="submit" class="col-xs-4 col-sm-3 btn btn-blue pull-right"> SAVE </button>
                                    <input type="button" value="CANCEL" id="cancel_profile" class="col-xs-4 col-sm-3 col-md-3 btn btn-blue margin-right-5 pull-right">
                                </div>	
                            </div>	
                        </form>
                    </div>
                </div>
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="account-settings">
                    <div class="col-xs-12 no-padding padding-10">
                        <h3 class="no-margin">Change Password</h3>
                        <form name="changePassword" id="changepassword-form" action="{$APP_BASE_URL}user/changepassword" method="post" onsubmit="return ChangePassword();">
                            <div class="form-group col-xs-12 floating-label-form-group">
                                <div class="col-xs-12 input-icon margin-top-20">
                                    <input class="form-control" type="password" id="oldPassword" name="oldPassword" placeholder="Old Password" ng-model="user.oldPassword" />
                                </div>
                                <div class="col-xs-12 input-icon margin-top-20">
                                    <input class="form-control" type="password" id="password" name="password" placeholder="New Password" ng-model="user.password" />
                                </div>                              
                                <div class="col-xs-12 input-icon margin-top-20">
                                    <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" ng-model="user.confirmPassword" />
                                </div>    
                                <div class="col-xs-12 input-icon margin-top-20">
                                    <label>&nbsp;</label>
                                    <div>                                
                                        <button type="submit" class="btn btn-md btn-blue pull-right">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {assign articles $response.profile->user->articles}
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="articles">
                    <div class="col-xs-12 no-padding padding-10">
                        <h3 class="no-margin">Submitted Articles</h3>
                        <div class="activityContentDiv padding-top-10 col-xs-12 no-padding">
                            {foreach from=$articles item=article name=popular key=k}
                            
                            <div class="col-xs-12 col-sm-6 col-md-4 singleArticle" single-article-hover>
                                <div class="clearfix"></div>
                                <div class="col-md-12 no-padding articleImg">
                                    <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}">
                                        {if $article->published_by eq ''}      
                                        <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->submitted_image}" class="img-responsive width_100">                                         
                                        {else}
                                        <img src="{$APP_BASE_URL}image/article?file_name={$article->id}/{$article->thumbnail_image}" class="img-responsive width_100">     
                                        {/if}
                                    </a>
                                    <h4 class="text-bold left">
                                       <a href="{$APP_BASE_URL}article/{$article->perma_link|lower}" class="text-dark-gray">{$article->title}</a></h4>
                                    
                                    <div class="text-medium text-gray margin-bottom-10">- {$article->created_at|date_format:'d M Y'}, Time {$article->created_at|date_format:'h:i A'}</div>
                                </div>
                                 {if $smarty.foreach.popular.index%2 == 0}
                                    <div class="clearfix visible-xs"></div>
                                    {/if}
                                    {if $smarty.foreach.popular.index%2 == 1}
                                    <div class="clearfix visible-sm"></div>
                                    {/if}
                            </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
                {assign comments $response.profile->user->comments}
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="recent-activity">
                    <div class="col-xs-12 no-padding padding-10">
                        <h3 class="no-margin">Recent Comments</h3>
                        <div class="activityContentDiv padding-top-10 col-xs-12 no-padding">
                            {assign curArticleId 0}
                            {foreach from=$comments item=comment name=popular key=k}

                            
                            {if $curArticleId != $comment->article_id}
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 singleArticle" single-article-hover>
                                <div class="clearfix"></div>
                                <div class="col-md-4 no-padding articleImg">
                                    <a href="{$APP_BASE_URL}article/{$comment->article->perma_link|lower}">
                                        <img src="{$APP_BASE_URL}image/article?file_name={$comment->article->id}/{$comment->article->thumbnail_image}" class="img-responsive width_100">
                                    </a>
                                    
                                </div>
                                
                                <div class="col-md-8 articleContent homePageArticle no-padding padding-left-20">
                                    <h4 class="text-bold left">
                                       <a href="{$APP_BASE_URL}article/{$comment->article->perma_link|lower}" class="text-dark-gray">{$comment->article->title}</a></h4>
                                    <ul>
                            {/if}
                                    <li>
                                        <div>{$comment->comment}</div>
                                        <div class="text-medium text-gray margin-bottom-10">- {$comment->created_at|date_format:'d M Y'}, Time {$comment->created_at|date_format:'h:i A'}</div>
                                    </li>
                            {assign curArticleId $comment->article_id}
                            
                             {if !isset($comments[$k+1]) || $curArticleId != $comments[$k+1]->article_id}       
                                </div>
                                <div class="clearfix"></div>
                                <hr/>
                            </div>
                            {/if}
                            
                            {/foreach}
                        </div>
                    </div>
                </div>
                {assign forums $response.profile->user->forums}
                <div class="col-xs-12 no-padding bg-grey profile-tab" id="forums">
                    <div class="col-xs-12 no-padding padding-10">
                        <h3 class="no-margin">Submitted Forums</h3>
                        <div class="activityContentDiv padding-top-10 col-xs-12 no-padding">
                            
                            {foreach from=$forums item=forum name=popular key=k}
                                <div class="col-xs-12 no-padding padding-bottom-10">
                                    <div class="row no-margin forumList border-bottom-light-grey border-right-light-grey border-width-1 bg-glass-grey">
                                        
                                        <div class="col-xs-6 col-sm-9 border-horizontal-light-grey border-width-1 padding-20">
                                            <h4 class="no-top-margin"><a href="{$APP_BASE_URL}forum/{$forum->perma_link|lower}" class="text-sky-blue">{$forum->title|truncate:45}</a></h4>
                                            Posted in <a href="{$APP_BASE_URL}forums/category/{$forum->category->title|lower|urlencode}" class="text-gray">{$forum->category->title}</a>, <span>{$forum->created_at|date_format:'M d, Y'} at {$forum->created_at|date_format:'h:i A'} </span> </p>
                                            
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
                                </div>
                                <div class="clearfix"></div>
                            {foreachelse}
                                <h3 class="no-top-margin">No Forums Found!</h3>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{/block}

<!-- Article Content -->